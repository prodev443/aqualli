<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends MasterController
{
    public function __construct()
    {
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
        if (isset($_GET['_type']) && $_GET['_type'] === 'query') {
            return $this->response->setJSON($users->listAllLike(null, $_GET['q'] ?? ''));
        }
        if ($users->isAdmin(session()->get('user_id'))) {
            $list = $users->listAll();
        } else {
            $list = $users->listAll(['users.role_id !=' => '1']);
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
        if (!empty($user)) {
            $data = [
                'user' => $user,
            ];
            return view('users/update_password.php', $data);
        } else {
            $data = [
                'message' => 'El usuario solicitado no existe o no se tiene acceso a él',
            ];
            return view('error/record_not_found', $data);
        }
    }

    /**
     * * Inserción de datos mediante HTTP POST
     * * Solicitud POST CSRF
     * * Devuelve el id del registro creado en caso de éxito
     *
     * @return CodeIgniter\HTTP\ResponseInterface
     **/
    public function alternateInsert()
    {
        $response = [];
        $result = $this->model->customInsert($_POST, true);
        switch ($result) {
            case 'db_error':
                return $this->response->setStatusCode(500, 'Error en la base de datos');
            case 'not_allowed':
                return $this->response->setStatusCode(403, 'Acceso restringido');

        }
        $response['token'] = csrf_hash();
		$response['record_id'] = $result; // Se devuelve el id del registro creado
        return $this->response->setJSON($response);
    }

}
