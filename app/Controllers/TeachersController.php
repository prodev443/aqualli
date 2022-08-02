<?php

namespace App\Controllers;

use App\Models\TeachersModel;

class TeachersController extends MasterController
{

	public function __construct() {
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
		$fields = ['id','CONCAT(teachers.first_name,\' \',teachers.last_name) AS `text`'];
        if(isset($_GET['_type']) && $_GET['_type'] === 'query'){
			$response = $model->select2Get($fields, 'CONCAT(teachers.first_name,\' \',teachers.last_name)', 'both', $_GET['q'] ?? '');
            return $this->response->setJSON($response);
        }
        return $this->response->setJSON($model->select2Get($fields));
	}


	// * Método POST de inserción
	public function insert(){

		$response = []; // Respuesta JSON

        $validation_rules = [
            'cv' => 'mime_in[cv,application/pdf]',
            'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
        ];
        $validation_errors = [
            'cv' => [
                'mime_in' => 'Solo se acepta PDF para el CV',
            ],
			'photo' => [
				'mime_in' => 'Solo se admite formato JPG para imágenes'
			]
        ];

		if( $this->validate($validation_rules, $validation_errors)){
			
			$cv = $this->request->getFile('cv'); // Archivo de currículum vitae
			$photo = $this->request->getFile('photo'); // Archivo de fotografía

			// Verificación de nuevo CV
		
			if($cv !== null && $cv->isValid()){
				$cv_label =  $cv->getClientName();
				$cv_path = $cv->getRandomName();

				// Añadir la información del nuevo CV a $_POST

				$_POST['cv_name'] = $cv_label;
				$_POST['cv_path'] = $cv_path;
			}

			if($photo !== null && $photo->isValid()){

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
		
		if(! isset($response['errors'])){
			
			if ($cv !== null && $cv->isValid()) {
				// Subir el currículum al servidor
				$cv->store('teachers/', $cv_path);

			}

			if ($photo !== null && $photo->isValid()) {
				// Subir foto al servidor
				$photo->store('teachers/', $photo_path);

			}
		}

		$response['token'] = csrf_hash();

		return $this->response->setJSON($response);

	}

	// * Método POST de actualización
	public function update(){
		
		$response = []; // Respuesta JSON

        $validation_rules = [
            'cv' => 'mime_in[cv,application/pdf]',
            'photo' => 'mime_in[photo,image/jpeg,image/pjpeg]',
        ];
        $validation_errors = [
            'cv' => [
                'mime_in' => 'Solo se acepta PDF para el CV',
            ],
			'photo' => [
				'mime_in' => 'Solo se admite formato JPG para imágenes'
			]
        ];

		if( $this->validate($validation_rules, $validation_errors)){
			
			$cv = $this->request->getFile('cv'); // Archivo de currículum vitae
			$photo = $this->request->getFile('photo'); // Archivo de fotografía

			$current_info = $this->model->select('cv_path,photo_path')->where(['id' => $_POST['id'] ?? ''])->first();

			// Verificación de nuevo CV
		
			if($cv !== null && $cv->isValid()){
				$cv_label =  $cv->getClientName();
				$cv_path = $cv->getRandomName();

				// Añadir la información del nuevo CV a $_POST

				$_POST['cv_name'] = $cv_label;
				$_POST['cv_path'] = $cv_path;

				// Obtiene información de CV antiguo
				if(! empty($current_info)){
					$old_cv_path = WRITEPATH . 'uploads/teachers/'.$current_info['cv_path'];
				}
			}

			if($photo !== null && $photo->isValid()){

				$photo_path = $photo->getRandomName();

				// Añadir la información de la nueva foto a $_POST

				$_POST['photo_path'] = $photo_path;

				// Obtiene información de foto antigua
				if(! empty($current_info)){
					$old_photo_path = WRITEPATH . 'uploads/teachers/'.$current_info['photo_path'];
				}
			}

			// Actualización de datos en el modelo
			if ($this->checkModel()) {
				$model = $this->model;
				if(isset($_POST['id'])){
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
		
		if(! isset($response['errors'])){
			
			if ($cv !== null && $cv->isValid()) {
				// Subir el currículum al servidor
				$cv->store('teachers/', $cv_path);
				// Eliminar el CV antiguo del directorio de subidas
				if(isset($old_cv_path)){
					if(is_file($old_cv_path)){
						unlink($old_cv_path);
					}
				}
			}

			if ($photo !== null && $photo->isValid()) {
				// Subir foto al servidor
				$photo->store('teachers/', $photo_path);
				// Eliminar foto antigua del directorio de subidas
				if(isset($old_photo_path)){
					if(is_file($old_photo_path)){
						unlink($old_photo_path);
					}
				}
			}
		}

		$response['token'] = csrf_hash();

		return $this->response->setJSON($response);
	}

	// * Método DELETE de eliminación
	public function delete(){

		$response = []; // Respuesta JSON

		parse_str(file_get_contents('php://input'), $_DELETE);
		
		$current_info = $this->model->select('cv_path,photo_path')->where(['id' => $_DELETE['id'] ?? ''])->first();
		
		if(! empty($current_info)){
			$old_cv_path = WRITEPATH . 'uploads/teachers/'.$current_info['cv_path'];
			$old_photo_path = WRITEPATH . 'uploads/teachers/'.$current_info['photo_path'];
		}

		// Actualización de datos en el modelo
		if ($this->checkModel()) {
			$model = $this->model;
			if(isset($_DELETE['id'])){
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

		if(! isset($response['errors'])){
			
			if(isset($old_cv_path)){
				if(is_file($old_cv_path)){
					unlink($old_cv_path);
				}
			}

			if(isset($old_photo_path)){
				if(is_file($old_photo_path)){
					unlink($old_photo_path);
				}
			}
			
		}

		$response['token'] = csrf_hash();

		return $this->response->setJSON($response);

	}

	// * Descarga el CV del profesor
	public function getCV($teacher_id){

		$teacher = $this->model->find($teacher_id);

		if(! empty($teacher)){
			$cv_path = WRITEPATH . 'uploads/teachers/'.$teacher['cv_path'];
			if(is_file($cv_path)){
				return $this->response->download($cv_path, null)->setFileName($teacher['cv_name']);
			} else {
				return view('errors/html/error_404.php');
			}
		} else {
			return view('errors/restricted');
		}

	}

	// * Obtiene la foto del profesor
	public function getPhoto($teacher_id){

		$teacher = $this->model->find($teacher_id);

		if(! empty($teacher)){
			$photo_path = WRITEPATH . 'uploads/teachers/'.$teacher['photo_path'];
			if(is_file($photo_path)){
				$mime = mime_content_type($photo_path); //<-- detect file type
				header('Content-Length: '.filesize($photo_path)); //<-- sends filesize header
				header("Content-Type: $mime"); //<-- send mime-type header
				header('Content-Disposition: inline; filename="'.$photo_path.'";'); //<-- sends filename header
				readfile($photo_path); //<--reads and outputs the file onto the output buffer
				exit();
			}
		} else {
			return view('errors/restricted');
		}

	}

	// * Elimina la fotografía del profesor
	public function deletePhoto()
	{
		$response = [];
		parse_str(file_get_contents('php://input'), $_DELETE);
		if(isset($_DELETE['id'])){
			$teacher_id = $_DELETE['id'];
			$model = $this->model;
			$current_info = $model->find($teacher_id);
			if(! empty($current_info)){
				$old_photo_path = WRITEPATH . 'uploads/teachers/'.$current_info['photo_path'];
			}
			$update_data = [ 'id' => $teacher_id, 'photo_path' => '' ];
			$result = $model->customSave($update_data);
			switch ($result) {
				case 'db_error':
					$response['errors'] = $model->errors();
					break;
				case 'not_allowed':
					$response['errors'] = ['Acceso Restringido'];
					break;
			}
			if (! isset($response['errors'])) {
				if(isset($old_photo_path)){
					if(is_file($old_photo_path)){
						unlink($old_photo_path);
					}
				}
			}
		} else {
			 $response['errors'] = ['Datos Faltantes'];
		}
		$response['token'] = csrf_hash();

		return $this->response->setJSON($response);
	}

	// * Elimina el cv del profesor
	public function deleteCV()
	{
		$response = [];
		parse_str(file_get_contents('php://input'), $_DELETE);
		if(isset($_DELETE['id'])){
			$teacher_id = $_DELETE['id'];
			$model = $this->model;
			$current_info = $model->find($teacher_id);
			if(! empty($current_info)){
				$old_cv_path = WRITEPATH . 'uploads/teachers/'.$current_info['cv_path'];
			}
			$update_data = [ 'id' => $teacher_id, 'cv_path' => '', 'cv_name' => '' ];
			$result = $model->customSave($update_data);
			switch ($result) {
				case 'db_error':
					$response['errors'] = $model->errors();
					break;
				case 'not_allowed':
					$response['errors'] = ['Acceso Restringido'];
					break;
			}
			if (! isset($response['errors'])) {
				if(isset($old_cv_path)){
					if(is_file($old_cv_path)){
						unlink($old_cv_path);
					}
				}
			}
		} else {
			 $response['errors'] = ['Datos Faltantes'];
		}
		$response['token'] = csrf_hash();

		return $this->response->setJSON($response);
	}

}
