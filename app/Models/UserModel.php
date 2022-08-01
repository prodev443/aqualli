<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends MainModel{
    protected $table      = 'users';
    protected $allowedFields = ['email','password','phone','role_id','is_active','created_by','assigned_to'];
    protected $primaryKey = 'id';
    protected $DBGroup = 'default';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'email' => 'required|is_unique[users.email,id,{id}]',
        'password' => 'required',
        'passconf' => 'required|matches[password]',
        'role_id' => 'required',
    ];
    protected $validationMessages = [
        'password' => [
            'required' => 'Falta contraseña',
            'min_lenght' => 'Contraseña de 10 caracteres como mínimo',
        ],
        'passconf' => [
            'required' => 'Falta confirmación de contraseña',
            'matches' => 'Las contraseñas no coinciden',
        ],
        'role_id' => [
            'required' => 'Falta rol',
        ],
        'email' => [
            'required' => 'Falta correo electrónico',
            'is_unique' => 'Dirección de correo en uso.',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = ['hashPassword','setIsActive','setUserForeignKeys'];
    protected $beforeUpdate = ['hashPassword','setIsActive'];

    protected function hashPassword(array $data){
        if (!isset($data['data']['password'])){
            return $data;
        } 
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    
        return $data;        
    }

    protected function setIsActive(array $data){
        if (isset($data['data']['is_active'])){
            $data['data']['is_active'] = 1; 
        } else {
            $data['data']['is_active'] = 0;
        }    
        return $data;        
    }

    public function getPermissions($user_id = null){
        $fields = 'modules.id,modules.module,modules_access.see,modules_access.create,modules_access.edit,modules_access.delete,modules_access.propietary_only,modules_access.assigned_only';
        $this->select($fields);
        $this->join('roles','users.role_id = roles.id');
        $this->join('modules_access','modules_access.role_id = roles.id');
        $this->join('modules','modules.id = modules_access.module_id');
        $this->where(['users.id' => $user_id]);
        return $this->findAll();
    }

    /**
     * Obtiene los permisos del ususario sobre una tabla o módulo específico
     *
     * @param string $table Tabla
     * @param string $user_id ID del usuario
     * @return array
     **/
    public function getTablePermissions($table = '', $user_id = '')
    {
        $fields = 'modules_access.see,modules_access.create,modules_access.edit,modules_access.delete,modules_access.propietary_only,modules_access.assigned_only';
        $this->select($fields);
        $this->join('roles','users.role_id = roles.id');
        $this->join('modules_access','modules_access.role_id = roles.id');
        $this->join('modules','modules.id = modules_access.module_id');
        $this->where(['users.id' => $user_id, 'modules.module' => $table]);
        return $this->first();
    }

    /**
     * Verifica si un usuario es administrador
     *
     * @param string $user_id ID del usuario
     * @return bool
     **/
    public function isAdmin($user_id = '')
    {
        $fields = 'users.email';
        $this->select($fields);
        $this->join('roles','users.role_id = roles.id');
        $this->where(['users.id' => $user_id, 'roles.role' => 'admin']);
        if(!empty($this->first())){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtiene una lista de los usuarios en el sistema y campos relacionados
     * @param bool $filterAdmins Indica si se deben filtrar los administradores
     * @return array
     **/
    public function getUsers($filterAdmins = true)
    {
        $fields = 'users.id,users.email,users.`phone`,users.is_active,roles.description AS role';
        $this->select($fields);
        $this->join('roles','roles.id = users.role_id');
        if($filterAdmins){
            $this->where(['users.role_id !=' =>'1']);
        }
        return $this->findAll();
    }

    // Métodos heredados de MainModel
    protected function setPermissions()
    {
        $fields = 'modules_access.see,modules_access.create,modules_access.edit,modules_access.delete,modules_access.propietary_only,modules_access.assigned_only';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select($fields);
        $builder->join('roles','users.role_id = roles.id');
        $builder->join('modules_access','modules_access.role_id = roles.id');
        $builder->join('modules','modules.id = modules_access.module_id');
        $builder->where(['users.id' => $this->session->user_id, 'modules.module' => $this->table]);
        $result = $builder->limit(1)->get()->getResultArray();
        // log_message('debug','User::setPermissions: $result: '.var_export($result, true));
        if ($this->table != null) {
            $grants = $result[0] ?? [];
            if (!empty($grants)) {
                $this->permissions = $grants;
            }
        }
    }

    public function listAll($whereArray = null)
    {
        if ($this->checkPermissions()) {
            $fields = 'users.id,users.email,users.`phone`,users.is_active,roles.description AS role';
            $this->select($fields);
            $this->join('roles','roles.id = users.role_id');
            if($whereArray !== null){
                if($this->orWhere !== null)
                    return $this->where($this->orWhere)->where($whereArray)->findAll();
                else
                    return $this->where($whereArray)->findAll();
            }
            else {
                if($this->orWhere !== null)
                    return $this->where($this->orWhere)->findAll();
                else
                    return $this->findAll();
            }
        } else {
            return [];
        }
    }

    /**
     * Funciona igual que $this->listAll
     * Proporciona parámetro para añadir consulta 'where like'
     */
    public function listAllLike($whereArray = null, $like = null)
    {
        if ($this->checkPermissions()) {
            $fields = 'users.id,users.email,users.`phone`,users.is_active,roles.description AS role';
            $this->select($fields);
            $this->join('roles','roles.id = users.role_id');
            if($like !== null){
                $this->like('CONCAT(users.first_name,\' \',users.last_name)', $like, 'after');
            }
            if($whereArray !== null){
                if($this->orWhere !== null)
                    return $this->where($this->orWhere)->where($whereArray)->findAll();
                else
                    return $this->where($whereArray)->findAll();
            }
            else {
                if($this->orWhere !== null)
                    return $this->where($this->orWhere)->findAll();
                else
                    return $this->findAll();
            }
        } else {
            return [];
        }
    }
}