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
        echo json_encode($this->barangModel->findAll());
    }

    public function muatMesin()
    {
        echo json_encode($this->mesinModel->findAll());
    }

    public function tambah()
    {
        $waktu = $this->request->getPost("waktu");

        $data = [
            "namaBarang" => $this->request->getPost("namaBarang"),
            "waktu" => $waktu,
            "nama_mesin" => $this->request->getPost("nama_mesin"),
            "qty" => $this->request->getPost("qty"),
            "stok" => 0,  // Inisialisasi stok dengan 0, akan diperbarui nanti
        ];

        try {
            $this->barangModel->save($data);
            $insertedId = $this->barangModel->insertID();
            $this->updateStok($insertedId);
            echo json_encode("Data berhasil ditambahkan");
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            echo json_encode("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    public function edit()
    {
        $id = $this->request->getPost("id");
        $waktu = $this->request->getPost("waktu");

        $data = [
            "namaBarang" => $this->request->getPost("namaBarang"),
            "waktu" => $waktu,
            "nama_mesin" => $this->request->getPost("nama_mesin"),
            "qty" => $this->request->getPost("qty"),
        ];

        try {
            $this->barangModel->update($id, $data);
            $this->updateStok($id);
            echo json_encode("Data berhasil diperbarui");
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            echo json_encode("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    public function hapus()
    {
        $id = $this->request->getPost("id");
        try {
            $this->barangModel->delete($id);
            $this->updateStok();
            echo json_encode("Data berhasil dihapus");
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            echo json_encode("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    private function updateStok($id = null)
    {
        if ($id) {
            $barang = $this->barangModel->find($id);
            if ($barang) {
                // Mendapatkan stok terakhir yang tersimpan di database
                $lastBarang = $this->barangModel->orderBy('id', 'DESC')->where('id <', $id)->first();
                $lastStok = $lastBarang ? $lastBarang['stok'] : 0;

                // Menambahkan qty baru ke stok terakhir
                $newStok = $lastStok + $barang['qty'];
                $this->barangModel->update($id, ['stok' => $newStok]);
            }
        }
    }
}
?>
