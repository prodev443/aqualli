<?php

namespace App\Controllers;

use App\Models\ScoresModel;

class ScoresController extends MasterController
{

    protected $controllerName = 'ScoresController';

    public function __construct()
    {
        $this->model = new ScoresModel();
        $this->main_route = 'scores';
        // $this->view_subdir = 'scores';
        // $this->view_varname = 'score';
    }

}
