<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\UserModel;

class UsersController extends MasterController
{
	public function __construct() {
		$this->model = new UserModel();
    	$this->main_route = 'users';
    	$this->view_subdir = 'users';
    	$this->view_varname = 'user';
	}

	// Métodos de recuperación de datos por GET

	/**
	 * Obtiene un objeto JSON con la lista de usuarios
	 *
	 * @return string JSON response
	 **/
	public function listJSON()
	{
		$users = new UserModel();
		$list = [];
		// ['users.role_id !=' =>'1'] : condición para filtrar los administradores (id rol administrador es 1)
		// request desde plugin select2
        if(isset($_GET['_type']) && $_GET['_type'] === 'query'){
            return $this->response->setJSON($users->listAllLike(null, $_GET['q'] ?? ''));
        }
		if($users->isAdmin(session()->get('user_id'))){
			$list = $users->listAll();
		} else {
			$list = $users->listAll(['users.role_id !=' =>'1']);
		}
		return $this->response->setJSON($list);
	}

	/**
	 * * Muestra una ventana emergente de actualización de la contraseña
	 *
	 * @param string $id ID del usuario
	 * @return string view()
	 **/
	public function showPasswordUpdatePopup(string $id)
	{
		$model = $this->model;
		$user = $model->find($id);
		if (! empty($user)) {
			$data = [
				'user' => $user
			];
			return view('users/update_password.php', $data);
		} else {
			$data = [
				'message' => 'El usuario solicitado no existe o no se tiene acceso a él'
			];
			return view('error/record_not_found', $data);
		}
	}

}
