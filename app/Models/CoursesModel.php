<?php

namespace App\Models;

class CoursesModel extends MainModel
{
	protected $DBGroup              = 'default';
	protected $table                = 'courses';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = false;

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
    protected $validationRules = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = ['setUserForeignKeys','setIsActive'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['setIsActive'];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function setIsActive(array $data){
        if (isset($data['data']['is_active'])){
            $data['data']['is_active'] = 1; 
        } else {
            $data['data']['is_active'] = 0;
        }    
        return $data;
    }

}
