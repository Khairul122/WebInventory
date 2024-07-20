<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\MesinModel;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->mesinModel = new MesinModel();
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

    public function muatMesin()
    {
        echo json_encode($this->mesinModel->findAll());
    }

    public function tambah()
    {
        $data = [
            "namaBarang" => $this->request->getPost("namaBarang"),
            "stok" => $this->request->getPost("stok"),
            "nama_mesin1" => $this->request->getPost("nama_mesin1"),
            "jumlah1" => $this->request->getPost("jumlah1"),
            "nama_mesin2" => $this->request->getPost("nama_mesin2"),
            "jumlah2" => $this->request->getPost("jumlah2"),
            "nama_mesin3" => $this->request->getPost("nama_mesin3"),
            "jumlah3" => $this->request->getPost("jumlah3"),
            "hapus" => 0
        ];

        $this->barangModel->save($data);

        echo json_encode("");
    }

    public function edit()
    {
        $data = [
            "namaBarang" => $this->request->getPost("namaBarang"),
            "stok" => $this->request->getPost("stok"),
            "nama_mesin1" => $this->request->getPost("nama_mesin1"),
            "jumlah1" => $this->request->getPost("jumlah1"),
            "nama_mesin2" => $this->request->getPost("nama_mesin2"),
            "jumlah2" => $this->request->getPost("jumlah2"),
            "nama_mesin3" => $this->request->getPost("nama_mesin3"),
            "jumlah3" => $this->request->getPost("jumlah3"),
        ];

        $this->barangModel->update($this->request->getPost("id"), $data);

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
