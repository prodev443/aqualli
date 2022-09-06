<?php

namespace App\Controllers;

use App\Models\TeachersModel;

class TeachersController extends MasterController
{
    protected $validation_rules = [
        'cv' => 'mime_in[cv,application/pdf]',
        'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
    ];
    protected $validation_errors = [
        'cv' => [
            'mime_in' => 'Solo se acepta PDF para el CV',
        ],
        'photo' => [
            'mime_in' => 'Solo se admite formato JPG para imágenes',
        ],
    ];

    public function __construct()
    {
        helper('files');
        $this->model = new TeachersModel();
        $this->main_route = 'teachers';
        $this->view_subdir = 'teachers';
        $this->view_varname = 'teacher';
    }

    /**
     * Obtiene los registros del módulo para Select2
     *
     * * Select2 es un plugin de JQuery que proporciona
     * * un control html <select> con búsqueda dinámica
     * * mediante AJAX $_GET
     *
     * @return string JSON response
     **/
    public function select2Teachers()
    {
        $model = $this->model;
        $fields = ['id', 'CONCAT(teachers.first_name,\' \',teachers.last_name) AS `text`'];
        if (isset($_GET['_type']) && $_GET['_type'] === 'query') {
            $response = $model->select2Get($fields, 'CONCAT(teachers.first_name,\' \',teachers.last_name)', 'both', $_GET['q'] ?? '');
            return $this->response->setJSON($response);
        }
        return $this->response->setJSON($model->select2Get($fields));
    }

    // * Método POST de inserción
    public function insert()
    {
        try {
            if ($this->validate($this->validation_rules, $this->validation_errors)) {
                $cv = $this->request->getFile('cv'); // Archivo de currículum vitae
                $photo = $this->request->getFile('photo'); // Archivo de fotografía

                if ($cv !== null && $cv->isValid()) {
                    $_POST['cv_name'] = $cv->getClientName();
                    $_POST['cv_path'] = $cv->getRandomName();
                }

                if ($photo !== null && $photo->isValid()) {
                    $_POST['photo_path'] = $photo->getRandomName();
                }

                if (!$this->setResponseStatus($this->model->customInsert($_POST))) {
                    throw new \Exception();
                }

                if ($cv !== null && $cv->isValid()) {
                    $cv->store('teachers/', $_POST['cv_path']);
                }

                if ($photo !== null && $photo->isValid()) {
                    $photo->store('teachers/', $_POST['photo_path']);
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
                $cv = $this->request->getFile('cv'); // Archivo de currículum vitae
                $photo = $this->request->getFile('photo'); // Archivo de fotografía
                $current_info = $this->model->select('cv_path,photo_path')->where('id', $_POST['id'])->first();

                if ($cv !== null && $cv->isValid()) {
                    $_POST['cv_name'] = $cv->getClientName();
                    $_POST['cv_path'] = $$cv->getRandomName();
                }

                if ($photo !== null && $photo->isValid()) {
                    $_POST['photo_path'] = $photo->getRandomName();
                }

                if (!$this->setResponseStatus($this->model->customSave($_POST))) {
                    throw new \Exception();
                }

                if ($cv !== null && $cv->isValid()) {
                    $cv->store('teachers/', $_POST['cv_path']);
                    deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['cv_path'] ?? '');
                }

                if ($photo !== null && $photo->isValid()) {
                    $photo->store('teachers/', $_POST['photo_path']);
                    deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['photo_path'] ?? '');
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
            log_message('debug', var_export($_DELETE, true));
            $current_info = $this->model->select('cv_path,photo_path')->where(['id' => $_DELETE['id']])->first();

            if (!$this->setResponseStatus($this->model->customDelete($_DELETE['id']))) {
                throw new \Exception();
            }

            deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['cv_path'] ?? '');
            deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['photo_path'] ?? '');

        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    // * Descarga el CV del profesor
    public function getCV($teacher_id)
    {
        try {
            $teacher = $this->model->find($teacher_id);
            $cv_path = WRITEPATH . 'uploads/teachers/' . $teacher['cv_path'];
            if (is_file($cv_path)) {
                return $this->response->download($cv_path, null)->setFileName($teacher['cv_name']);
            } else {
                return $this->response->setStatusCode(500, 'No se encuentra el archivo');
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
            return $this->response->setStatusCode(403, 'Sin acceso al documento');
        }
    }

    // * Obtiene la foto del profesor
    public function getPhoto($teacher_id)
    {
        try {
            $teacher = $this->model->find($teacher_id);
            $photo_path = WRITEPATH . 'uploads/teachers/' . $teacher['photo_path'];
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

    // * Elimina la fotografía del profesor
    public function deletePhoto()
    {
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            $current_info = $this->model->find($_DELETE['id']);
            $update_data = ['id' => $_DELETE['id'], 'photo_path' => ''];
            if (!$this->setResponseStatus($this->model->customSave($update_data))) {
                throw new \Exception();
            }
            deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['photo_path'] ?? '');
        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    // * Elimina el cv del profesor
    public function deleteCV()
    {
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            $current_info = $this->model->find($_DELETE['id']);
            $update_data = ['id' => $_DELETE['id'], 'cv_path' => '', 'cv_name' => ''];
            if (!$this->setResponseStatus($this->model->customSave($update_data))) {
                throw new \Exception();
            }
            deleteFile(WRITEPATH . "uploads/teachers/" . $current_info['cv_path'] ?? '');
        } catch(\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan datos para la solicitud');
        }
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }
}
