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
        return view('dataPemesanan', $data);
    }

    public function muatData()
    {
        $dataPemesanan = $this->DataPemesananModel->select('transaksi.*, barang.namaBarang')
            ->join('barang', 'barang.id = transaksi.id_barang')
            ->findAll();

        echo json_encode($dataPemesanan);
    }

    public function getById()
    {
        $id = $this->request->getPost('id_transaksi');
        $data = $this->DataPemesananModel->select('transaksi.*, barang.namaBarang')
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
            "status" => $this->request->getPost("status"),
            "id_barang" => $this->request->getPost("id_barang")
        ];

        if (session()->get('rule') == 0) {
            $data['status'] = 'acc';
        }

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

        try {
            $this->DataPemesananModel->update($id, $data);

            if ($transaksiSebelumnya['status'] == 'jalan' && $data['status'] != 'jalan') {
                $this->updateStokBarang($data['id_barang'], $transaksiSebelumnya['qty']);
            } elseif ($transaksiSebelumnya['status'] != 'jalan' && $data['status'] == 'jalan' || $data['status'] == 'acc') {
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
}
