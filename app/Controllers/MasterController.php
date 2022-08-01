<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * Controlador base
 * Utiliza un modelo subclase de MainModel
 */

class MasterController extends BaseController {

    protected $model = null; // * Modelo del controlador
    protected $main_route = null; // * Ruta principal del controlador o módulo (solo letras)
    protected $view_subdir = null; // * Subdirectorio de vistas en views/* sin '/' (solo letras)
    protected $view_varname = null; // * Nombre de la variable utilizada en la vista: view($view_subdir.'', ["{$view_varname}" => $result])

    /**
     * Vertifica si $this->model es subclase de Model
     *
     * 
     * @return bool
     **/
    protected function checkModel()
    {
        if (is_a($this->model, '\\App\\Models\\MainModel')) {
            return true;
        } else {
            log_message('warning','Modelo no inicializado correctamente en '.static::class);
            return false;
        }
    }

    /**
     * Verifica variables necesarias para el funcionamiento del controlador
     *
     * @return bool
     **/
    public function verifyVars()
    {
        if ($this->main_route !== null && $this->view_subdir !== null && $this->view_varname !== null) {
            return true;
        } else {
            log_message('warning','verifyVars() error en: '.static::class);
            return false;
        }
    }

    // Métodos para cargar vistas

    /**
     * * Carga la vista de lista
     * @return mixed
     */
    public function index()
    {
		$model = $this->model;
		if($this->checkModel() && $this->verifyVars() && $model->checkPermissions()){
			return view($this->view_subdir.'/list');
		} else {
            log_message('warning','Model check permissions: '.$model->checkPermissions());
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
		if ($this->checkModel() && $this->verifyVars() && $model->checkPermissions()) {
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
		if ($this->checkModel() && $this->verifyVars() && $model->checkPermissions('edit')) {
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
		if ($this->checkModel() && $this->verifyVars() && $model->checkPermissions('create')) {
			return view($this->view_subdir.'/create');
		} else {
			return redirect()->route('home');
		}
    }
    
    // Métodos de recuperación tipo API

	/**
	 * * Consulta todos los registros de una tabla
     * 
     * * Puede consultar solo un registro del id proporcionado
     * * Consulta simple SELECT
     * 
     * 
	 * @param string $id ID del registro
	 * @return string JSON response
	 **/
	public function get($id = null)
	{
		$response = [];
        if($this->checkModel()){
            $model = $this->model;
            if($id === null){
                $response = $model->listAll();
            } else {
                $response = $model->find($id);
            }
        }
		return $this->response->setJSON($response);
	}

    /**
	 * * Inserción de datos mediante HTTP POST
     * * Solicitud POST CSRF
	 *
	 * @return string JSON response
	 **/
	public function insert()
	{
		$response = [];
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
            $response['errors'] = ['Error de sistema'];
            // Añadir log_message
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Actualización de datos mediante HTTP POST
     * * Solicitud POST CSRF
	 *
	 * @return string JSON response
	 **/
	public function update()
	{
		$response = [];
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
            $response['errors'] = ['Error de sistema'];
            // Añadir log_message
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Elimina un array de datos mediante HTTP POST
     * * Solicitud DELETE CSRF
     * * Recibe una estructura de datos {token: token_hash, records: { 0 : {id: ''} }} en $_DELETE
	 *
	 * @return string JSON response
	 **/
	public function delete(){
		$response = [];
        if ($this->checkModel()) {
            $model = $this->model;
            parse_str(file_get_contents('php://input'), $_DELETE);
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
            }  else {
                $response['errors'] = ['Datos Faltantes'];
                // log_message
            }
        } else {
            $response['errors'] = ['Error de sistema'];
            // Añadir log_message
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

	/**
	 * * Actualiza o inserta datos de forma masiva mediante HTTP POST
     * * Solicitud POST CSRF
     * * Recibe una estructura de datos {token: token_hash, records: { 0 : {...} }} en $_POST
	 *
	 * @return string JSON response
	 **/
	public function updateArray()
	{
		$response = [];
        if ($this->checkModel()) {
            $model = $this->model;
            if(isset($_POST['records']) && is_array($_POST['records'])){
                foreach ($_POST['records'] as $record) {
                    if(is_array($record)){
                        if(isset($record['id'])){
                            $result = $model->customSave($record);
                        } else {
                            $result = $model->customInsert($record);
                        }
                        switch ($result) {
                            case 'db_error':
                                $response['errors'] = $model->errors();
                                break;
                            case 'not_allowed':
                                $response['errors'] = ['Acceso Restringido'];
                                break;
                        }
                    } else {
                        $response['errors'] = ['Los datos no pudieron ser actualizados'];
                        log_message('warning',static::class.': Error en el formato JSON a la solicitud POST');
                    }
                }
            } else {
                $response['errors'] = ['Datos Faltantes'];
                // log_message
            }
        } else {
            $response['errors'] = ['Error de sistema'];
            // Añadir log_message
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Elimina un array de datos mediante HTTP POST
     * * Solicitud DELETE CSRF
     * * Recibe una estructura de datos {token: token_hash, records: { 0 : {id: ''} }} en $_DELETE
	 *
	 * @return string JSON response
	 **/
	public function deleteArray(){
		$response = [];
        if ($this->checkModel()) {
            $model = $this->model;
            parse_str(file_get_contents('php://input'), $_DELETE);
            if(isset($_DELETE['records']) && is_array($_DELETE['records'])){
                foreach ($_DELETE['records'] as $record) {
                    if(is_array($record)){
                        if(isset($record['id'])){
                            $result = $model->customDelete($record['id']);
                            switch ($result) {
                                case 'db_error':
                                    $response['errors'] = $model->errors();
                                    break;
                                case 'not_allowed':
                                    $response['errors'] = ['Acceso Restringido'];
                                    break;
                            }
                        } else {
                            $response['errors'] = ['Error. 23'];
                        }
                    } else {
                        $response['errors'] = ['Los datos no pudieron ser actualizados'];
                        log_message('warning',static::class.': Error en el formato JSON a la solicitud POST');
                    }
                }
            }  else {
                $response['errors'] = ['Datos Faltantes'];
                // log_message
            }
        } else {
            $response['errors'] = ['Error de sistema'];
            // Añadir log_message
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Agrega un array de registros de relación m -m
	 * * Solicitud POST CSRF
	 * 
	 * Utiliza insertRelated de MainModel
	 * 
	 * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @return string JSON response
	 **/
	public function postRelated($relationship = '', $main_fk = '', $related_fk = '')
	{
		$response = [];
        if ($this->checkModel()) {
            $model = $this->model;
            if(isset($_POST['records']) && is_array($_POST['records'])){
                foreach ($_POST['records'] as $record) {
                    if(is_array($record)){
                        if(isset($record[$main_fk]) && isset($record[$related_fk])){
							$result = $model->insertRelated($relationship, $main_fk,$related_fk, $record[$main_fk], $record[$related_fk]);
                        } else {
                            $result = 'missing_data';
                            
                        }
                        switch ($result) {
                            case 'db_error':
                                $response['errors'] = $model->db->error()['message'];
                                break;
							case 'missing_data':
                                $response['errors'] = ['Datos faltantes'];
								break;
                            case 'not_allowed':
                                $response['errors'] = ['Acceso Restringido'];
                                break;
                        }
                    } else {
                        $response['errors'] = ['Los datos no pudieron ser actualizados'];
                        log_message('warning',static::class.': Error en el formato JSON a la solicitud POST');
                    }
                }
            }
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}

    /**
	 * * Elimina un array de registros de una relación
     * * Protegido con CSRF DELETE
	 *
     * Utiliza deleteRelated de MainModel
	 * 
	 * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @return string JSON response
	 **/
	public function deleteRelated($relationship = '', $main_fk = '', $related_fk = ''){
		$response = [];
        if ($this->checkModel()) {
            $model = $this->model;
            parse_str(file_get_contents('php://input'), $_DELETE);
            if(isset($_DELETE['records']) && is_array($_DELETE['records'])){
                foreach ($_DELETE['records'] as $record) {
                    if(is_array($record)){
                        if(isset($record[$main_fk]) && isset($record[$related_fk])){
                            $result = $model->deleteRelated($relationship, $main_fk,$related_fk, $record[$main_fk], $record[$related_fk]);
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
                        $response['errors'] = ['Los datos no pudieron ser actualizados'];
                        log_message('warning',static::class.': Error en el formato JSON a la solicitud POST');
                    }
                }
            }
        }
		$response['token'] = csrf_hash();
		return $this->response->setJSON($response);
	}
}