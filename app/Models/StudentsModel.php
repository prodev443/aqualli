<?php

namespace App\Models;

use CodeIgniter\Throttle\ThrottlerInterface;

class StudentsModel extends MainModel
{
	protected $DBGroup              = 'default';
	protected $table                = 'students';
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
	// Validation
    protected $validationRules = [
        'first_name' => 'required|min_length[3]',
        'last_name' => 'required|min_length[3]',
        'second_last_name' => 'required|min_length[3]',
    ];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = ['setUserForeignKeys','setCheckboxes'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['setCheckboxes'];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
	
}
