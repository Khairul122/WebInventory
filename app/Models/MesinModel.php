<?php

namespace App\Models;

use CodeIgniter\Model;

class MesinModel extends Model
{
    protected $table = 'mesin';
    protected $primaryKey = 'id_mesin';
    protected $allowedFields = ['nama_mesin'];
}
