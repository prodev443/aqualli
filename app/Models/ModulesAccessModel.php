<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulesAccessModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'modules_access';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['role_id','module_id','see','create','edit','delete','propietary_only','assigned_only'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = '';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	/**
	 * Lista los permisos en cada módulo conforme a una condición dada
	 *
	 * @param array $conditions Condiciones where
	 * @return array
	 **/
	public function getModulesPermissions($conditions = [])
	{
		$fields = 'modules_access.id,modules_access.see,modules_access.create,modules_access.edit,modules_access.delete,modules_access.propietary_only,modules_access.assigned_only,modules.module_tag';
		$this->select($fields);
		$this->join('modules','modules_access.module_id = modules.id')->where($conditions);
		return $this->findAll();
	}

	/**
	 * Retorna los modulos permitidos (para ver) al usuario
	 *
	 * @param string $user_id ID del usuario
	 * @return array
	 * @throws conditon
	 **/
	public function getAllowedModules($user_id = null)
	{
		$allowed = array();

        if($user_id != null){
            $db = db_connect();
            $query = 'SELECT
            modules.module
            FROM
            users
            LEFT JOIN modules_access ON users.role_id = modules_access.role_id
            INNER JOIN modules ON modules_access.module_id = modules.id
            WHERE
            users.id = ?';
            foreach ($db->query($query, [$user_id])->getResult() as $row) {
                array_push($allowed, $row->module);
            }
        }

        return $allowed;
	}
}
