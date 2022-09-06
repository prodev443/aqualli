<?php

namespace App\Controllers;

use App\Models\StudentsModel;

class StudentsController extends MasterController
{
    protected $validation_rules = [
        'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
    ];
    protected $validation_errors = [
        'photo' => [
            'mime_in' => 'Solo se admite formato JPG para imágenes',
        ],
    ];

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
        try {
            if ($this->validate($this->validation_rules, $this->validation_errors)) {
                $photo = $this->request->getFile('photo'); // Archivo de fotografía

                if ($photo !== null && $photo->isValid()) {
                    $_POST['photo_path'] = $photo->getRandomName();
                }

                if (!$this->setResponseStatus($this->model->customInsert($_POST))) {
                    throw new \Exception();
                }

                if ($photo !== null && $photo->isValid()) {
                    $photo->store('students/', $_POST['photo_path']);
                }
            } else {
                $errors = $this->validator->getErrors();
                $this->response->setStatusCode(500, array_pop($errors));
            }
        } finally {
        }

        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    // * Método POST de actualización
    public function update()
    {
        try {
            if ($this->validate($this->validation_rules, $this->validation_errors)) {
                $photo = $this->request->getFile('photo'); // Archivo de fotografía
                $current_info = $this->model->select('photo_path')->where('id', $_POST['id'])->first();

                if ($photo !== null && $photo->isValid()) {
                    $_POST['photo_path'] = $photo->getRandomName();
                }

                if (!$this->setResponseStatus($this->model->customSave($_POST))) {
                    throw new \Exception();
                }

                if ($photo !== null && $photo->isValid()) {
                    $photo->store('students/', $_POST['photo_path']);
                    deleteFile(WRITEPATH . "uploads/students/" . $current_info['photo_path'] ?? '');
                }
            } else {
                $errors = $this->validator->getErrors();
                $this->response->setStatusCode(500, array_pop($errors));
            }
        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }

        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    // * Método DELETE de eliminación
    public function delete()
    {
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            $current_info = $this->model->select('photo_path')->where(['id' => $_DELETE['id']])->first();

            if (!$this->setResponseStatus($this->model->customDelete($_DELETE['id']))) {
                throw new \Exception();
            }

            deleteFile(WRITEPATH . "uploads/students/" . $current_info['photo_path'] ?? '');
        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    // * Obtiene la foto del alumno
    public function getPhoto($student_id)
    {
        try {
            $student = $this->model->find($student_id);
            $photo_path = WRITEPATH . 'uploads/students/' . $student['photo_path'];
            if (is_file($photo_path)) {
                $mime = mime_content_type($photo_path); //<-- detect file type
                header('Content-Length: ' . filesize($photo_path)); //<-- sends filesize header
                header("Content-Type: $mime"); //<-- send mime-type header
                header('Content-Disposition: inline; filename="' . $photo_path . '";'); //<-- sends filename header
                readfile($photo_path); //<--reads and outputs the file onto the output buffer
                exit();
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
            return $this->response->setStatusCode(403, 'Sin acceso al archivo');
        }
    }

    // * Elimina la fotografía del alumno
    public function deletePhoto()
    {
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            $current_info = $this->model->find($_DELETE['id']);
            $update_data = ['id' => $_DELETE['id'], 'photo_path' => ''];
            if (!$this->setResponseStatus($this->model->customSave($update_data))) {
                throw new \Exception();
            }
            deleteFile(WRITEPATH . "uploads/students/" . $current_info['photo_path'] ?? '');
        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
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
