<?php

namespace App\Controllers;

use App\Models\CoursesModel;

class CoursesController extends MasterController
{

	public function __construct() {
		$this->model = new CoursesModel();
    	$this->main_route = 'courses';
    	$this->view_subdir = 'courses';
    	$this->view_varname = 'course';
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
	public function select2Courses()
	{
		$model = $this->model;
		$fields = ['id','code','name'];
        if(isset($_GET['_type']) && $_GET['_type'] === 'query'){
			$response = $model->select2Get($fields, 'name', 'both', $_GET['q'] ?? '',['is_active' => 1]);
            return $this->response->setJSON($response);
        }
        return $this->response->setJSON($model->select2Get($fields));
	}

}
