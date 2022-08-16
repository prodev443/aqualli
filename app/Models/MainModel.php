<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;
use Exception;

class MainModel extends Model
{

    protected $session;
    protected $table = '';
    protected $orWhere = null;
    protected $permissions = [];
    protected $autoUserFK = true;
	protected $beforeInsert = ['setUserForeignKeys'];
    

    public function __construct(?ConnectionInterface &$db = null, ?ValidationInterface $validation = null)
    {
        $this->session = \Config\Services::session();
        $this->setPermissions();
        $this->setWhere();
        parent::__construct($db, $validation);
    }

    protected function setPermissions()
    {
        $userModel = new UserModel();
        if ($this->table != null) {
            $grants = $userModel->getTablePermissions($this->table, $this->session->user_id);
            if (!empty($grants)) {
                $this->permissions = $grants;
            }
        }
    }

    protected function setWhere()
    {
        if (empty($this->permissions)) return;
        if($this->permissions['propietary_only'] == 1 && $this->permissions['assigned_only'] == 1){
            $this->orWhere = "({$this->table}.created_by = {$this->session->user_id} OR {$this->table}.assigned_to = {$this->session->user_id})";
            return;
        }
        if ($this->permissions['propietary_only'] == 1) {
            $this->orWhere = "{$this->table}.created_by = {$this->session->user_id}";
        }
        if ($this->permissions['assigned_only'] == 1) {
            $this->orWhere = "{$this->table}.assigned_to = {$this->session->user_id}";
        }
    }

    public function checkPermissions($type = 'see')
    {

        if (empty($this->permissions)) {
            return false;
        }

        switch ($type) {
            case 'see':
                return ($this->permissions['see'] == 1) ? true : false;
            case 'create':
                return ($this->permissions['create'] == 1) ? true : false;
            case 'edit':
                return ($this->permissions['edit'] == 1) ? true : false;
            case 'delete':
                return ($this->permissions['delete'] == 1) ? true : false;
            default:
                return false;
        }

    }

    public function checkRecordAccess($id = null, $where = null)
    {
        if($id == null) return false;
        $result = parent::where(['id' => $id]);
        if($this->orWhere !== null) $result = $result->where($this->orWhere);
        if($where !== null) $result = $result->where($where);
        $result = $result->first();
        if (!empty($result)) {
            return true;
        } else {
            log_message('notice','Usuario '.session()->get('user_id').' intentó acceder a un registro no autorizado de '.$this->table);
            log_message('notice','Última consulta: '.$this->db->getLastQuery());
            return false;
        }
    }

    /**
     * Verifica si el usuario de la sesión actual
     * tiene acceso a todos los recursos
     *
     * Determina si el usuario tiene permisos en todos
     * los registros, no solo en los que haya creado o
     * haya sido asignado.
     * No verifica el tipo de acceso, ej. ver o editar
     *
     * @return bool
    
     **/
    public function currentUserHasAccessToAll()
    {
        if ($this->permissions['propietary_only'] == 0 && $this->permissions['assigned_only'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica si el usuario en la sesión actual 
     * es propietario del registro
     *
     * @param string $id
     * @return bool
     **/
    public function currentUserIsPropietary($id)
    {
        $curren_user_id = session()->get('user_id');
        $result = $this->where(['created_by' => $curren_user_id])->first();
        if(!empty($result)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Asigna valores automáticamente a los campos created_by y assigned_to
     * * Determina si el array $data[] contiene valores asignados para los campos indicados
     * * Solo debe utilizarse en la inserción o creación de registros, no en la actualización
     *
     * @param Array &$data Arreglo de datos
     **/
    protected function setUserForeignKeys($data){
		if(!isset($data['data']['created_by'])){
			$data['data']['created_by'] = session()->get('user_id');
		}
		if(!isset($data['data']['assigned_to'])){
			$data['data']['assigned_to'] = session()->get('user_id');
		}
		return $data;
	}

    /**
     * Método find heredado de Codeigniter\BaseModel
     *
     * @param array|int|string|null $id One primary key or an array of primary keys
     *
     * @return array|object|null The resureturn type
     * 
     **/
    public function find($id = null)
    {
        if ($this->checkPermissions() && $this->checkRecordAccess($id)){
            return parent::find($id);
        }
        return [];
    }

    /**
     * * Consulta toda la lista de los registros de la tabla
     * * Verifica los permisos del usuario
     * @param null $whereArray Condiciones de consulta
     * 
     * @return array
     */
    public function listAll($whereArray = null)
    {
        $fields = $this->db->getFieldNames($this->table);
        foreach ($fields as $key => $field) {
            $fields[$key] = "{$this->table}.{$field}";
        }
        $this->select(implode(',', $fields));
        if ($this->checkPermissions()) {
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
     * Inserta un registro en la tabla
     *
     * * Devuelve un string 'not_allowed' si el usuario no tiene permisos
     *
     * @param array $data
     *
     * @return string 'success' | 'not_allowed' | 'db_error'
     **/
    public function customInsert($data = null)
    {
        if($this->checkPermissions('create')){
            try {
                if(parent::insert($data) === false){
                    return 'db_error';
                }
                return 'success';
            } catch (Exception $e) {
                $db_error = $this->db->error();
                if($db_error['code'] === 1062){
                    // 1062 es un error de entrada duplicada para un índice.
                    // No se notifica al usuario
                    return 'success';
                } else {
                    log_message('critical', 'Error en la base de datos: '.var_export($db_error, true));
                    return 'db_error';
                }
            }
        } else {
            return 'not_allowed';
        }
    }

    /**
     * Actualiza un registro en la tabla
     *
     * * Devuelve un string 'not_allowed' si el usuario no tiene permisos
     *
     * @param array $id Identificador del registro
     * @param array $data Arreglo de datos para actualizar
     *
     * @return string 'success' | 'not_allowed' | 'db_error'
     **/
    public function customUpdate($id = null, $data = null)
    {
        if($this->checkPermissions('edit')){
            try {
                if(parent::update($id, $data) === false){
                    return 'db_error';
                }
                return 'success';
            } catch (Exception $e) {
                if($this->db->error()['code'] === 1062){
                    // 1062 es un error de entrada duplicada para un índice.
                    // No se notifica al usuario
                    return 'success';
                } else {
                    return 'db_error';
                }
            }
        } else {
            return 'not_allowed';
        }
    }

    /**
     * Método customSave ejecuta save($data) de Codeigniter\BaseModel
     *
     * @param array|object $data Data
     *
     * @return string 'success' | 'not_allowed' | 'db_error'
     **/
    public function customSave($data)
    {
        try {
            if(isset($data['id'])){
                if(!$this->checkPermissions('edit') || !$this->checkRecordAccess($data['id'])) return 'not_allowed';
                return (parent::save($data) === false) ? 'db_error' : 'success';
            } elseif($this->checkPermissions('create')) {
                return (parent::save($data) === false) ? 'db_error' : 'success';
            } else {
                return 'not_allowed';
            }
        } catch (Exception $e) {
            if ($this->db->error()['code'] === 1062) {
                return 'success';
            } else {
                log_message('warning', 'Código de error: '.$e->getCode());
                log_message('warning', 'Mensaje: '.$e->getMessage());
                return 'db_error';
            }
            return 'db_error';
        }             
    }

    /**
     * Método para eliminar un registro
     *
     * @param string $id : id del registro a eliminar
     * @return string
     **/
    public function customDelete($id = null)
    {
        try {
            if ($this->checkPermissions('delete') && $this->checkRecordAccess($id)) {
                return (parent::delete($id) === false) ? 'db_error' : 'success';
            } else {
                return 'not_allowed';
            }
        } catch (Exception $e) {
            return 'db_error';
        }
    }

    // Métodos auxiliares
    /**
	 * Asigna el valor a campos Checkbox tipo TINYINT
	 *
	 * El campo tipo Checkbox en HTML no retorna valor si
	 * no se verifica la casilla, por lo cual se necesita
	 * procesar el valor y asignar la correcta inserción
	 * o actualización
	 *
	 * @return array $data Array de datos para la consulta
	 **/
	protected function setCheckboxes(array $data, $fields = null){
        if($fields !== null && is_array($fields)){
            foreach ($fields as $field) {
                if (isset($data['data'][$field]) && $data['data'][$field] == 1){
                    $data['data'][$field] = 1; 
                } else {
                    $data['data'][$field] = 0;
                }
            }
        } 
        return $data;        
    }

    /**
	 * Consulta para Select2 (JQuery Plugin)
	 *
	 * @param string $fields_array Array de campos para el método select($fields)
	 * @param string $like_field Campo o expresión para where like
	 * @param string $like_type Se refiere a %% de la cláusula de like 'after', 'both', etc
	 * @param string $like_value valor para like
	 * @param string $whereArray Array de condicionales where
	 * @return array
	 **/
	public function select2Get($fields_array = null, $like_field =null, $like_type = 'both', $like_value = null, $whereArray = null)
	{
		$fields = implode(',', $fields_array);
		if ($this->checkPermissions() && ! empty($fields_array)) {
            $this->select($fields);
            if($like_field !== null){
                $this->like($like_field, $like_value, $like_type);
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

    /**
     * * Carga una relación m - m a la consulta del modelo
     *
     * * Agrega un  inner join a una tabla de relaciones
     * * Limitaciones: Se utiliza el campo id como llave primaria para relacionar
     * * Se recomienda indicar los campos de esta forma `table`.`field` en el arreglo de campos
     *
     * @param string $relationship Nombre de la tabla de relaciones
     * @param string $related_table Nombre de la tabla relacionada
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
     * @param array $fields_array arreglo de campos a mostrar (recomendado utilizar)
     **/
    public function loadRelationship($relationship = '', $related_table = '', $main_fk = '', $related_fk = '', $fields_array = [] )
    {
        if(! empty($fields_array)){
		    $fields = implode(',', $fields_array);
            $this->select($fields);
        }
        $on = "`{$this->table}`.`id` = `{$relationship}`.`{$main_fk}`";
		$this->join($relationship, $on);
        $on_related_table = "`{$relationship}`.`{$related_fk}` = `{$related_table}`.`id`";
		$this->join($related_table, $on_related_table);
    }

    /**
	 * * Inserta una relación m - m
	 *
     * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @param string $main_fk_value Valor de la llave foránea de este modelo
	 * @param string $related_fk_value Valor de la llave foránea de la tabla relacionada
	 * @return string success | not_allowed | db_error
	 **/
	public function insertRelated($relationship = '', $main_fk = '', $related_fk = '', $main_fk_value, $related_fk_value)
	{
		if ($this->checkPermissions('edit') && $this->checkRecordAccess($main_fk_value)) {
			$data = [
				"{$main_fk}" => $main_fk_value,
				"{$related_fk}" => $related_fk_value
			];
			try {
				$builder = $this->db->table($relationship);
				$builder->insert($data);
				return 'success';
			} catch (\Throwable $e) {
				if ($this->db->error()['code'] === 1062) {
					return 'success';
				} else {
					return 'db_error';
				}
			}
		} else {
			return 'not_allowed';
		}
	}

    /**
	 * * Inserta una relación m - m
	 *
     * @param string $relationship Nombre de la tabla de relaciones
     * @param string $main_fk Nombre de la llave foránea de este modelo | tabla en la tabla de relaciones
     * @param string $related_fk Nombre de la llave foránea de la tabla relacionada en la tabla de relaciones
	 * @param string $main_fk_value Valor de la llave foránea de este modelo
	 * @param string $related_fk_value Valor de la llave foránea de la tabla relacionada
	 * @return string success | not_allowed | db_error
	 **/
	public function deleteRelated($relationship = '', $main_fk = '', $related_fk = '', $main_fk_value, $related_fk_value)
	{
		if ($this->checkPermissions('edit') && $this->checkRecordAccess($main_fk_value)) {
			$data = [
				"{$main_fk}" => $main_fk_value,
				"{$related_fk}" => $related_fk_value
			];
			try {
				$builder = $this->db->table($relationship);
				$builder->delete($data);
				return 'success';
			} catch (\Throwable $e) {
				if ($this->db->error()['code'] === 1062) {
					return 'success';
				} else {
					return 'db_error';
				}
			}
		} else {
			return 'not_allowed';
		}
	}

    
}
