<?php

namespace App\Models;

class TeachersModel extends MainModel
{
    protected $DBGroup = 'default';
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    // Validation
    protected $validationRules = [
        'first_name' => 'required|min_length[3]',
        'last_name' => 'required|min_length[3]',
        'second_last_name' => 'required|min_length[3]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setUserForeignKeys', 'setCheckboxes'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['setCheckboxes'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // Método heredado
    protected function setCheckboxes(array $data, $fields = null)
    {
        $checkbox_fields = ['is_active'];
        return parent::setCheckboxes($data, $checkbox_fields);
    }

    /**
	 * * Consulta las clases de un profesor
     * @param string $id Teacher
     * 
     * @return array
     */
    public function getSchedule(string $id)
    {
        $fields = "groups.id AS groupId,
			groups.`name` AS groupName,
			schedules.title,
			schedules.startTime,
			schedules.daysOfWeek,
			schedules.className,
			courses.id AS courseId,
			courses.`name` AS courseName";
		$this->select($fields);
        $this->join('groups', 'teachers.id = groups.teacher_id', 'left');
        $this->join('schedules', 'groups.id = schedules.group_id', 'left');
        $this->join('courses', 'schedules.course_id = courses.id');
        $this->where('teachers.id', $id);
        $this->where('groups.deleted_at IS NULL');
        $this->where('schedules.deleted_at IS NULL');
        $this->where('courses.deleted_at IS NULL');
		return parent::listAll();
    }
}
