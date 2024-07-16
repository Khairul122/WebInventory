<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPemesananModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'tgl_transaksi', 
        'nama_costumer', 
        'tujuan', 
        'qty', 
        'no_mobil', 
        'nama_supir', 
        'no_hp', 
        'metode_bayar', 
        'shift', 
        'status',
        'id_barang'
    ];

    public function getAllTransaksi()
    {
        $builder = $this->db->table($this->table);
        $builder->select('transaksi.*, barang.namaBarang');
        $builder->join('barang', 'barang.id = transaksi.id_barang');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
