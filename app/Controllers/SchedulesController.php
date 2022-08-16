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

}
