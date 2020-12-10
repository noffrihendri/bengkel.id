<?php

namespace App\Models;

use CodeIgniter\Model;

class Mmenus extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'menu_id';
    protected $allowedFields = ['title','link','icon','parent','created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    protected $skipValidation = false;


    public function getmodule($loginrole)
    {
        $sql = " SELECT * FROM `menu` 
        join role_menu on role_menu.id_menu=menu.menu_id 
        join user_role on user_role.role_id=role_menu.id_role 
        where user_role.role_name='$loginrole'
        ";

       
        $query = $this->db->query($sql);

        return $query;
    }
    

}
