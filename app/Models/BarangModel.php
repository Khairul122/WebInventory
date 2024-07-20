<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table      = 'barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['namaBarang', 'stok', 'nama_mesin1', 'jumlah1', 'nama_mesin2', 'jumlah2', 'nama_mesin3', 'jumlah3', 'hapus'];
}
