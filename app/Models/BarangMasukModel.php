<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table      = 'barangMasuk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idBarang', 'namaBarang', 'penambahanStok', 'stokTerkini', 'satuan', 'keterangan', 'karyawan'];
}
