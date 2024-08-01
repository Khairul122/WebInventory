<?php

namespace App\Controllers;

use App\Models\DataPemesananModel;
use App\Models\BarangModel;

class DataPemesanan extends BaseController
{
    protected $DataPemesananModel;
    protected $BarangModel;

    public function __construct()
    {
        $this->DataPemesananModel = new DataPemesananModel();
        $this->BarangModel = new BarangModel();
    }

    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/login");
        }

        $data['barang'] = $this->BarangModel->where('hapus', 0)->findAll();
        $data['barang'] = $this->DataPemesananModel->getLatestBarang();
        return view('dataPemesanan', $data);
    }

    public function muatData()
    {
        $dataPemesanan = $this->DataPemesananModel->select('transaksi.*, barang.namaBarang')
        ->join('barang', 'barang.id = transaksi.id_barang')
        ->orderBy('transaksi.id_transaksi', 'DESC') // Urutkan berdasarkan kolom 'id' secara descending
        ->findAll();

    echo json_encode($dataPemesanan);
    }

    public function getById()
    {
        $id = $this->request->getPost('id_transaksi');
        $data = $this->DataPemesananModel->select('transaksi.*, barang.namaBarang, barang.stok')
            ->join('barang', 'barang.id = transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id)
            ->first();
        echo json_encode($data);
    }

    public function tambah()
    {
        $data = [
            "tgl_transaksi" => $this->request->getPost("tgl_transaksi"),
            "nama_costumer" => $this->request->getPost("nama_costumer"),
            "tujuan" => $this->request->getPost("tujuan"),
            "qty" => $this->request->getPost("qty"),
            "no_mobil" => $this->request->getPost("no_mobil"),
            "nama_supir" => $this->request->getPost("nama_supir"),
            "no_hp" => $this->request->getPost("no_hp"),
            "metode_bayar" => $this->request->getPost("metode_bayar"),
            "shift" => $this->request->getPost("shift"),
            "status" => $this->request->getPost("status"), // Mengambil status dari form
            "id_barang" => $this->request->getPost("id_barang"),
            "is_checked" => 0 // Default is_checked to 0
        ];

        try {
            $this->DataPemesananModel->save($data);

            if ($data['status'] == 'jalan' || $data['status'] == 'acc') {
                $this->updateStokBarang($data['id_barang'], -$data['qty']);
            }

            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id_transaksi');

        $transaksiSebelumnya = $this->DataPemesananModel->find($id);

        $data = [
            "tgl_transaksi" => $this->request->getPost("tgl_transaksi"),
            "nama_costumer" => $this->request->getPost("nama_costumer"),
            "tujuan" => $this->request->getPost("tujuan"),
            "qty" => $this->request->getPost("qty"),
            "no_mobil" => $this->request->getPost("no_mobil"),
            "nama_supir" => $this->request->getPost("nama_supir"),
            "no_hp" => $this->request->getPost("no_hp"),
            "metode_bayar" => $this->request->getPost("metode_bayar"),
            "shift" => $this->request->getPost("shift"),
            "status" => $this->request->getPost("status"),
            "id_barang" => $this->request->getPost("id_barang")
        ];

        // Tambahkan nama_admin jika status berubah menjadi acc
        if ($data['status'] == 'acc') {
            $data['nama_admin'] = session()->get('nama');
        }

        try {
            $this->DataPemesananModel->update($id, $data);

            // Jika status transaksi sebelumnya adalah 'jalan' atau 'acc' dan status baru adalah 'batal', kembalikan stok
            if (($transaksiSebelumnya['status'] == 'jalan' || $transaksiSebelumnya['status'] == 'acc') && $data['status'] == 'batal') {
                $this->updateStokBarang($data['id_barang'], $transaksiSebelumnya['qty']);
            }
            // Jika status transaksi sebelumnya bukan 'jalan' atau 'acc' dan status baru adalah 'jalan' atau 'acc', kurangi stok
            elseif ($transaksiSebelumnya['status'] != 'jalan' && $transaksiSebelumnya['status'] != 'acc' && ($data['status'] == 'jalan' || $data['status'] == 'acc')) {
                $this->updateStokBarang($data['id_barang'], -$data['qty']);
            }

            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function updateStokBarang($id_barang, $qty)
    {
        $barang = $this->BarangModel->find($id_barang);

        if ($barang) {
            $stokBaru = $barang['stok'] + $qty;

            if ($stokBaru < 0) {
                $stokBaru = 0;
            }

            $this->BarangModel->update($id_barang, ['stok' => $stokBaru]);
        }
    }

    public function hapus()
    {
        $id = $this->request->getPost('id_transaksi');
        try {
            $this->DataPemesananModel->delete($id);
            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateCheck()
    {
        $id = $this->request->getPost('id_transaksi');
        $is_checked = $this->request->getPost('is_checked');

        try {
            $this->DataPemesananModel->update($id, ['is_checked' => $is_checked]);
            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
