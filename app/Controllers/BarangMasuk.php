<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;
use App\Models\BarangModel;

class BarangMasuk extends BaseController
{
    public function __construct()
    {
        $this->BarangMasukModel = new BarangMasukModel();
        $this->BarangModel = new BarangModel();
    }
    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/login");
        }
        $data["barang"] = $this->BarangModel->where('hapus', 0)->findAll();
        return view('barangMasuk', $data);
    }
    public function muatData()
    {
        echo json_encode($this->BarangMasukModel->findAll());
    }

    public function barangById(){
        echo json_encode($this->BarangModel->where('id', $this->request->getPost("id"))->first());
    }

    public function tambah()
    {
        $stokTerikini = $this->request->getPost("stokTerkini") + $this->request->getPost("penambahanStok");
        $data = [
            "idBarang" => $this->request->getPost("idBarang"),
            "namaBarang" => $this->request->getPost("namaBarang"),
            "penambahanStok" => $this->request->getPost("penambahanStok"),
            "stokTerkini" => $stokTerikini,
            "satuan" => $this->request->getPost("satuan"),
            "keterangan" => $this->request->getPost("keterangan"),
            "karyawan" => session()->get('nama')
        ];

        $this->BarangMasukModel->save($data);

        $data = [
            "stok" => $stokTerikini
        ];
        $this->BarangModel->update($this->request->getPost("idBarang"), $data);

        echo json_encode("");
    }
}
