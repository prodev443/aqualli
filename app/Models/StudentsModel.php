<?php

namespace App\Models;

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
	protected $beforeInsert         = ['setUserForeignKeys',];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	/**
	 * Obtiene una lista de los cursos del alumno
	 *
	 * @param string $student_id
	 * @return array
	 **/
	public function getCourses(string $student_id)
	{
		$db = db_connect();
		$result = $db->query('SELECT
			students.id AS student_id,
			courses.id AS course_id,
			courses.`code` AS course_code,
			courses.`name` AS course_name,
			scores.id AS score_id,
			scores.score
		FROM
			students
			INNER JOIN groups ON students.group_id = groups.id
			INNER JOIN schedules ON schedules.group_id = groups.id
			INNER JOIN courses ON courses.id = schedules.course_id
			LEFT JOIN scores ON  students.id = scores.student_id AND courses.id = scores.course_id
		WHERE
			students.deleted_at IS NULL 
			AND groups.deleted_at IS NULL 
			AND schedules.deleted_at IS NULL 
			AND courses.deleted_at IS NULL 
			AND students.id = ?
		GROUP BY courses.id',
		[$student_id])->getResultArray();
		return $result;
	}
	
}
