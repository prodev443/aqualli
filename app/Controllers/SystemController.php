<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModulesAccessModel;
use App\Models\ModulesModel;
use App\Models\RolesModel;

class SystemController extends BaseController
{
	public function index()
	{
		$data = ['title' => 'Home', 'pagetitle' => 'Dashboard' ];
		return view('system/dashboard', $data);
	}

	/**
	 * Lista los roles disponibles
	 *
	 * @return string
	 **/
	public function listRoles()
	{
		return view('system/list_roles');
	}

	/**
	 * Muestra el detalle de los permisos de un rol
	 *
	 * @param string $role_id
	 * @return type
	 * @throws conditon
	 **/
	public function detailRole($role_id = null)
	{
		$model = new RolesModel();
		$modules = new ModulesModel();
		$data['record'] =  $model->find($role_id);
		$data['modules'] = $modules->select('id,module_tag')->findAll();
		if(empty($data['record'])){
			return redirect()->route('system/roles');
		} else {
			return view('system/detail_role', $data);
		}
	}


	// Métodos de recuperación de datos

	/**
	 * Retorna un objeto con los roles del sistema
	 *
	 * @return string JSON
	 **/
	public function getRoles()
	{
		$model = new RolesModel();
		$result = $model->findAll();
		return $this->response->setJSON($result);
	}


	/**
	 * Retorna un objeto con los módulos del sistema
	 *
	 * @return string JSON
	 **/
	public function getModules()
	{
		$user_is_admin = true;
		$result = [];
		if ($user_is_admin) {
			$model = new ModulesModel();
			$result = $model->findAll();
		}
		return $this->response->setJSON($result);
	}

	/**
	 * Obtiene los permisos de un rol
	 *
	 * Undocumented function long description
	 *
	 * @param Type $var Description
	 * @return type
	 * @throws conditon
	 **/
	public function getPermissions($role_id = null)
	{
		// Colocar método para saber si es admin
		$user_is_admin = true;
		$result = [];
		if($user_is_admin && $role_id !== null){
			$modules_access = new ModulesAccessModel();
			$result = $modules_access->getModulesPermissions(['modules_access.role_id' => $role_id]);
		}

		return $this->response->setJSON($result);
	}

	// Métodos de actualización de datos

	/**
	 * Guarda los permisos de un rol por POST
	 *
	 * Undocumented function long description
	 *
	 * @param Type $var Description
	 * @return type
	 * @throws conditon
	 **/
	public function savePermissions()
	{
		$model = new ModulesAccessModel();
		if ($this->request->getMethod() === 'post') {
            if (is_array($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    try {
						if ($model->save($item) === false) {
							$errors = $model->db->error();
							break;
						}
					} catch (\Exception $e) {
						$errors = $model->db->error();
					}
                }
            }
            $response = array(
                'token' => csrf_hash(),
            );
            if (isset($errors)) {
				if($errors['code'] === 1062){
					$response['errors'] = 'Entrada duplicada';
				} else {
					$response['errors'] = 'Error. Consulte al administrador';
					
				}
            }
            return $this->response->setJSON($response);
        }
	}

	/**
	 * Elimina permisos de un rol
	 * 
	 * @return mixed
	 **/
	public function deletePermissions()
	{
		$model = new ModulesAccessModel();
        if (is_array($_POST['items'])) {
            foreach ($_POST['items'] as $item) {
                if ($model->delete($item['id']) === false) {
                    $errors = $model->errors();
                    break;
                }
            }
        }
        $response = array(
            'token' => csrf_hash(),
        );
        if (isset($errors)) {
            $response['errors'] = array_pop($errors);
        }
        return $this->response->setJSON($response);
	}
}
