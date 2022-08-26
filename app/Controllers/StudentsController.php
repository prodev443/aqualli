<?php

namespace App\Controllers;

use App\Libraries\Email;
use App\Libraries\PDFLib;
use App\Models\CurrentCoursesStudentsModel;
use App\Models\EmailSubmissionsModel;
use App\Models\PdfModel;
use App\Models\StudentsModel;
use App\Models\UserModel;
use Exception;

class StudentsController extends MasterController
{

    protected $model = null;
    protected $controllerName = 'StudentsController';

    public function __construct()
    {
        $this->model = new StudentsModel();
        $this->main_route = 'students';
        $this->view_subdir = 'students';
        $this->view_varname = 'student';
    }

    // * Método POST de inserción
    public function insert()
    {

        $response = []; // Respuesta JSON

        $validation_rules = [
            'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
        ];
        $validation_errors = [
            'photo' => [
                'mime_in' => 'Solo se admite formato JPG para imágenes',
            ],
        ];

        if ($this->validate($validation_rules, $validation_errors)) {

            $photo = $this->request->getFile('photo'); // Archivo de fotografía

            if ($photo !== null && $photo->isValid()) {

                $photo_path = $photo->getRandomName();

                // Añadir la información de la nueva foto a $_POST

                $_POST['photo_path'] = $photo_path;

            }

            // Actualización de datos en el modelo
            if ($this->checkModel()) {
                $model = $this->model;
                $result = $model->customInsert($_POST);
                switch ($result) {
                    case 'db_error':
                        $response['errors'] = $model->errors();
                        break;
                    case 'not_allowed':
                        $response['errors'] = ['Acceso Restringido'];
                        break;
                }
            } else {
                $response['error'] = ['Error de sistema'];
            }

        } else {
            $response['errors'] = $this->validator->getErrors();
        }

        if (!isset($response['errors'])) {

            if ($photo !== null && $photo->isValid()) {
                // Subir foto al servidor
                $photo->store('students/', $photo_path);

            }
        }

        $response['token'] = csrf_hash();

        return $this->response->setJSON($response);

    }

    // * Método POST de actualización
    public function update()
    {

        $response = []; // Respuesta JSON

        $validation_rules = [
            'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
        ];
        $validation_errors = [
            'photo' => [
                'mime_in' => 'Solo se admite formato JPG para imágenes',
            ],
        ];

        if ($this->validate($validation_rules, $validation_errors)) {

            $photo = $this->request->getFile('photo'); // Archivo de fotografía

            $current_info = $this->model->select('photo_path')->where(['id' => $_POST['id'] ?? ''])->first();

            if ($photo !== null && $photo->isValid()) {

                $photo_path = $photo->getRandomName();

                // Añadir la información de la nueva foto a $_POST

                $_POST['photo_path'] = $photo_path;

                // Obtiene información de foto antigua
                if (!empty($current_info)) {
                    $old_photo_path = WRITEPATH . 'uploads/students/' . $current_info['photo_path'];
                }
            }

            // Actualización de datos en el modelo
            if ($this->checkModel()) {
                $model = $this->model;
                if (isset($_POST['id'])) {
                    $result = $model->customSave($_POST);
                    switch ($result) {
                        case 'db_error':
                            $response['errors'] = $model->errors();
                            break;
                        case 'not_allowed':
                            $response['errors'] = ['Acceso Restringido'];
                            break;
                    }
                } else {
                    $response['errors'] = ['Datos Faltantes'];
                }
            } else {
                $response['error'] = ['Error de sistema'];
            }

        } else {
            $response['errors'] = $this->validator->getErrors();
        }

        if (!isset($response['errors'])) {

            if ($photo !== null && $photo->isValid()) {
                // Subir foto al servidor
                $photo->store('students/', $photo_path);
                // Eliminar foto antigua del directorio de subidas
                if (isset($old_photo_path)) {
                    if (is_file($old_photo_path)) {
                        unlink($old_photo_path);
                    }
                }
            }
        }

        $response['token'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    // * Método DELETE de eliminación
    public function delete()
    {

        $response = []; // Respuesta JSON

        parse_str(file_get_contents('php://input'), $_DELETE);

        $current_info = $this->model->select('photo_path')->where(['id' => $_DELETE['id'] ?? ''])->first();

        if (!empty($current_info)) {
            $old_photo_path = WRITEPATH . 'uploads/students/' . $current_info['photo_path'];
        }

        // Actualización de datos en el modelo
        if ($this->checkModel()) {
            $model = $this->model;
            if (isset($_DELETE['id'])) {
                $result = $model->customDelete($_DELETE['id']);
                switch ($result) {
                    case 'db_error':
                        $response['errors'] = $model->errors();
                        break;
                    case 'not_allowed':
                        $response['errors'] = ['Acceso Restringido'];
                        break;
                }
            } else {
                $response['errors'] = ['Datos Faltantes'];
            }
        } else {
            $response['error'] = ['Error de sistema'];
        }

        if (!isset($response['errors'])) {

            if (isset($old_photo_path)) {
                if (is_file($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }

        }

        $response['token'] = csrf_hash();

        return $this->response->setJSON($response);

    }

    // * Obtiene la foto del alumno
    public function getPhoto($student_id)
    {

        $student = $this->model->find($student_id);

        if (!empty($student)) {
            $photo_path = WRITEPATH . 'uploads/students/' . $student['photo_path'];
            if (is_file($photo_path)) {
                $mime = mime_content_type($photo_path); //<-- detect file type
                header('Content-Length: ' . filesize($photo_path)); //<-- sends filesize header
                header("Content-Type: $mime"); //<-- send mime-type header
                header('Content-Disposition: inline; filename="' . $photo_path . '";'); //<-- sends filename header
                readfile($photo_path); //<--reads and outputs the file onto the output buffer
                exit();
            }
        } else {
            return view('errors/restricted');
        }

    }

    // * Elimina la fotografía del estudiante
    public function deletePhoto()
    {
        $response = [];
        parse_str(file_get_contents('php://input'), $_DELETE);
        if (isset($_DELETE['id'])) {
            $student_id = $_DELETE['id'];
            $model = $this->model;
            $current_info = $model->find($student_id);
            if (!empty($current_info)) {
                $old_photo_path = WRITEPATH . 'uploads/students/' . $current_info['photo_path'];
            }
            $update_data = ['id' => $student_id, 'photo_path' => ''];
            $result = $model->customSave($update_data);
            switch ($result) {
                case 'db_error':
                    $response['errors'] = $model->errors();
                    break;
                case 'not_allowed':
                    $response['errors'] = ['Acceso Restringido'];
                    break;
            }
            if (!isset($response['errors'])) {
                if (isset($old_photo_path)) {
                    if (is_file($old_photo_path)) {
                        unlink($old_photo_path);
                    }
                }
            }
        } else {
            $response['errors'] = ['Datos Faltantes'];
        }
    }

    /**
     * * Obtiene los registros del módulo para Select2
     *
     * * Select2 es un plugin de JQuery que proporciona
     * * un control html <select> con búsqueda dinámica
     * * mediante AJAX $_GET
     *
     * @return string JSON response
     **/
    public function select2Students()
    {
        $model = $this->model;
        $fields = ['students.`id`', 'CONCAT(students.`first_name`," ",students.`last_name`," ",students.`second_last_name`) AS `name`'];
        if (isset($_GET['_type']) && $_GET['_type'] === 'query') {
            $response = $model->select2Get($fields, 'CONCAT(students.`first_name`," ",students.`last_name`," ",students.`second_last_name`)', 'both', $_GET['q'] ?? '');
            return $this->response->setJSON($response);
        }
        return $this->response->setJSON($model->select2Get($fields));
    }

    /**
     * Devuelve los cursos del alumno
     *
     * Respuesta JSON por GET
     *
     * @param string $student_id
     * @return 
     **/
    public function getCourses(string $student_id)
    {
        $result = $this->model->getCourses($student_id);
        return $this->response->setJSON($result);
    }

}
