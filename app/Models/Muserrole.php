<?php

namespace App\Models;

use CodeIgniter\Model;

class Muserrole extends Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'role_id';
    protected $allowedFields = ['role_name', 'is_active', 'created_by'];
    protected $useTimestamps = true;


    protected $skipValidation = false;

    protected $createdField  = 'created_at';
    protected $updatedField  = false;


}