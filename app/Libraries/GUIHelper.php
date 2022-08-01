<?php
namespace App\Libraries;

use App\Models\UserModel;

class GUIHelper {

    public function genSidebar(){
        $session = \Config\Services::session();
        $user = new UserModel();
        $permissions = $user->getPermissions($session->user_id);
        $is_admin = $user->isAdmin(session()->get('user_id'));
        $modules = array();
        foreach ($permissions as $right) {
            if ($right['see'] === '1') {
                array_push($modules, $right['module']);
            }
        }
        $data = [
            'modulesAllowed' => $modules,
            'is_admin' => $is_admin
        ];
        return view('application/sidebar', $data);
    }

    public function genTopbar(){
        return view('application/topbar');
    }

    public function genPageTitle($params = []){
        $data = [];
        $data = ['title' => $params['title']];
        $data = ['pagetitle' => $params['pagetitle']];
        return view('application/page-title', $data);
    }

    public function genRightSidebar()
    {
        return view('application/right-sidebar');
    }

    public function genFooter()
    {
        return view('application/footer');
    }
}