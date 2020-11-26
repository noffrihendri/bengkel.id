<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['username', 'email', 'nomer', 'user_role', 'updated_by', 'created_by', 'is_active', 'category', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    protected $skipValidation = false;


    public function updateuser($data, $arrwhere)
    {
        $query = $this->db->table('user')->update($data, $arrwhere);
        return $query;
    }

    public function getData($arrWhere, $intLimit, $intOffset)
    {
        $builder = $this->db->table('user');
        $builder->select('*,(SELECT role_name from user_role where role_id=user_role)as role_name');
        $builder->where($arrWhere);
        $builder->limit($intLimit, $intOffset);

        return $builder->get();
    }

    public function getuser($arrWhere)
    {
        $builder = $this->db->table('user');
        $builder->select('*,(SELECT role_name from user_role where role_id=user_role)as role_name');
        $builder->where($arrWhere);

        return $builder->get();
    }
}
