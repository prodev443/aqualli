<?php

namespace App\Controllers;

use App\Models\GroupsModel;

class GroupsController extends MasterController
{

	public function __construct() {
		$this->model = new GroupsModel();
    	$this->main_route = 'groups';
    	$this->view_subdir = 'groups';
    	$this->view_varname = 'group';
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
	public function select2groups()
	{
		$model = $this->model;
		$fields = ['id','name'];
        if(isset($_GET['_type']) && $_GET['_type'] === 'query'){
			$response = $model->select2Get($fields, 'name', 'both', $_GET['q'] ?? '');
            return $this->response->setJSON($response);
        }
        return $this->response->setJSON($model->select2Get($fields));
	}

}
