<?php

namespace App\Models;

use CodeIgniter\Model;

class Mrolemenu extends Model
{
    protected $table = 'role_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_role', 'id_menu', 'created_by'];
    protected $useTimestamps = true;


    protected $skipValidation = false;

    protected $updatedField  = false;

    protected $createdField  = 'created_at';
}
