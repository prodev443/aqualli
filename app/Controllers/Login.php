<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RolesModel;

class Login extends BaseController
{
    public function index()
    {
        if (session()->isLoggedIn) {
            return redirect()->to('home');
        }

        return view('system/login');
    }

    public function signin()
    {
        $model = new UserModel();
        $validation = \Config\Services::validation();
        $validation_rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];
        $validation_errors = [
            'email' => [
                'required' => 'Correo electrónico requerido',
                'valid_email' => 'Correo electrónico no válido',
            ],
            'password' => [
                'required' => 'Contraseña requerida',
            ],
        ];
        $validation->setRules($validation_rules, $validation_errors);

        if ($this->request->getMethod() === 'post' && $validation->run($_POST)) {

            $conditions = array(
                'email' => $_POST['email'],
                'is_active' => 1
            );
            
            $user = $model->where($conditions)->first();

            if (!empty($user) && password_verify($_POST['password'], $user['password'])) {
                $roles_model = new RolesModel();
                $role = $roles_model->find($user['role_id']);
                session()->set('isLoggedIn', true);
                session()->set('user_id', $user['id']);
                session()->set('user_first_name', $user['first_name']);
                session()->set('role_id', $user['role_id']);
                session()->set('role', $role['role'] ?? '');
                return redirect('home');
            } else {
                $data = [
                    'failure' => 'Datos incorrectos o usuario inactivo',
                ];
                return view('system/login', $data);
            }

        } else {
            $data = [
                'validation' => $validation,
            ];
            return view('system/login', $data);
        }
    }

    public function signout()
    {
        session_destroy();
        return redirect('login');
    }

    // Borrar este método del controlador y las rutas
    public function getUserPermissions($user_id = null){
        $user = new UserModel();
        return $this->response->setJSON($user->getPermissions($user_id));
    }
}
