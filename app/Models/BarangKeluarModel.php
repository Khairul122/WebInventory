<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table      = 'barangKeluar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idBarang', 'namaBarang', 'penguranganStok', 'stokTerkini', 'satuan', 'keterangan', 'karyawan'];
}