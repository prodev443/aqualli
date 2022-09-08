<?php

namespace App\Controllers;

use App\Models\SchedulesModel;

class SchedulesController extends MasterController
{

	public function __construct() {
		$this->model = new SchedulesModel();
    	$this->main_route = 'schedules';
    	$this->view_subdir = 'schedules';
    	$this->view_varname = 'schedule';
	}

	/**
	 * * Consulta el horario de un grupo en específico
     * 
	 * @param string $groupId
	 * @return \CodeIgniter\HTTP\ResponseInterface JSON Response
	 **/
	public function getByGroup($groupId)
	{
		$response = [];
		$model = $this->model;
		$response = $model->listAll(['group_id' => $groupId]);
		if (!empty($response)) {
            $response = array_map(function($i){
                $i['title'] = $i['course'];
                return $i;
            }, $response);
        }
		return $this->response->setJSON($response);
	}

}
