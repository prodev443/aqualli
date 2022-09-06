<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MainModel;

/**
 * Controlador base
 * Utiliza un modelo subclase de MainModel
 */

class MasterController extends BaseController {

    protected MainModel $model; // * Modelo del controlador
    protected $main_route = null; // * Ruta principal del controlador o módulo (solo letras)
    protected $view_subdir = null; // * Subdirectorio de vistas en views/* sin '/' (solo letras)
    protected $view_varname = null; // * Nombre de la variable utilizada en la vista: view($view_subdir.'', ["{$view_varname}" => $result])

    /**
     * * Asigna el estado de la respuesta a la solicitud en
     * * base a la respuesta del modelo
     * @param string $modelResult
     * 
     * @return void
     */
    protected function setResponseStatus(string $modelResult): bool
    {
        switch ($modelResult) {
            case 'db_error':
                $this->response->setStatusCode(500, 'Error en la base de datos');
                return false;
            case 'not_allowed':
                $this->response->setStatusCode(403, 'No se tiene acceso al recurso');
                return false;
            
            default:
                $this->response->setStatusCode(200, 'Solicitud completada');
                return true;
        }
    }

    // Métodos para cargar vistas

    /**
     * * Carga la vista de lista
     * @return mixed
     */
    public function index()
    {
		if($this->model->checkPermissions()){
			return view($this->view_subdir.'/list');
		} else {
			return redirect()->route('login');
		}
    }

	/**
     * * Carga la vista de detalle
	 * @param string $id ID del registro del módulo
	 * 
	 * @return mixed
	 */
	public function detail($id = null)
    {
        $model = $this->model;
		if ($model->checkPermissions()) {
			$result = $model->find($id);
			if(empty($result)) return redirect()->route($this->main_route);
			return view($this->view_subdir.'/detail', ["{$this->view_varname}" => $result]);
		} else {
			return redirect()->route('home');
		}
    }

    /**
     * * Carga la vista de edición
     * @param string $id
     * 
     * @return mixed
     */
    public function edit($id = null)
    {
        $model = $this->model;
		if ($model->checkPermissions('edit')) {
			$result = $model->find($id);
			if(empty($result)) return redirect()->route($this->main_route);
			return view($this->view_subdir.'/edit', ["{$this->view_varname}" => $result]);
		} else {
			return redirect()->route('home');
		}
    }

    /**
     * * Carga la vista de detalle
     * @return mixed
     */
    public function create()
    {
        $model = $this->model;
		if ($model->checkPermissions('create')) {
			return view($this->view_subdir.'/create');
		} else {
			return redirect()->route('home');
		}
    }
    
    // Métodos de recuperación tipo API

	/**
     * * Consulta SELECT
     * 
	 * @param string $id ID del registro
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function get($id = null)
	{
        if($id === null){
            $response = $this->model->listAll();
        } else {
            $response = $this->model->find($id);
        }
		return $this->response->setJSON($response);
	}

    /**
	 * * HTTP POST INSERT
	 *
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function insert()
	{
        $this->setResponseStatus($this->model->customInsert($_POST));
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * HTTP POST UPDATE
	 *
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function update()
	{
        $this->setResponseStatus($this->model->customSave($_POST));
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
     * * HTTP DELETE
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function delete(){
        parse_str(file_get_contents('php://input'), $_DELETE);
        try {
            $this->setResponseStatus($this->model->customDelete($_DELETE['id']));
        } catch (\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan parámetros en la solicitud');
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

	/**
	 * * UPDATE | INSERT HTTP POST
     * * Ej. POST: {records: { 0 : {...} }}
	 *
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function updateArray()
	{
        try {
            foreach ($_POST['records'] as $record) {
                if (!$this->setResponseStatus($this->model->customSave($record))) {
                    throw new \Throwable("Error en la base de datos"); 
                }
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
            $this->response->setStatusCode(500, 'Faltan parámetros en la solicitud');
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Elimina un array de datos mediante HTTP POST
     * * Solicitud DELETE CSRF
     * * Recibe una estructura de datos {token: token_hash, records: { 0 : {id: ''} }} en $_DELETE
	 *
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function deleteArray(){
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            foreach ($_DELETE['records'] as $record) {
                if (! $this->setResponseStatus($this->model->customDelete($record['id']))) {
                    throw new \Exception("Error en la base de datos");
                }
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Agrega un array de registros de relación m -m
	 * * POST
	 * 
	 * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function postRelated(string $relationship, string $main_fk, string $related_fk)
	{
        try {
            foreach ($_POST['records'] as $record) {
                $result = $this->model->insertRelated($relationship, $main_fk,$related_fk, $record[$main_fk], $record[$related_fk]);
                if (! $this->setResponseStatus($result)) {
                    throw new \Exception("Error en la base de datos");
                }
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Elimina un array de registros de una relación
     * * DELETE
	 *
     * Utiliza deleteRelated de MainModel
	 * 
	 * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @return \CodeIgniter\HTTP\ResponseInterface
	 **/
	public function deleteRelated($relationship = '', $main_fk = '', $related_fk = ''){
        try {
            parse_str(file_get_contents('php://input'), $_DELETE);
            foreach ($_DELETE['records'] as $record) {
                $result = $this->model->deleteRelated($relationship, $main_fk,$related_fk, $record[$main_fk], $record[$related_fk]);
                if (! $this->setResponseStatus($result)) {
                    throw new \Exception("Error en la base de datos");
                }
            }
        } catch (\Throwable $th) {
            log_message('critical', $th);
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}
}