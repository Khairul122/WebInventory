<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }
    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/login");
        }
        echo view('barang');
    }
    public function muatData()
    {
        echo json_encode($this->barangModel->where('hapus', 0)->findAll());
    }

    public function tambah()
    {
        $data = [
            "namaBarang" => $this->request->getPost("namaBarang"),
            "stok" => $this->request->getPost("stok"),
            "hapus" => 0
        ];

        $this->barangModel->save($data);

        echo json_encode("");
    }

    public function hapus()
    {
        $data = [
            "hapus" => 1
        ];
        $this->barangModel->update($this->request->getPost("id"), $data);
        echo json_encode("");
    }
}
