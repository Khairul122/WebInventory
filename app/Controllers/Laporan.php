<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\DataPemesananModel;

class Laporan extends BaseController
{
    protected $barangModel;
    protected $dataPemesananModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->dataPemesananModel = new DataPemesananModel();
    }

    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/login");
        }
        return view('laporan');
    }

    public function dataPemesanan()
    {
        $tanggalMulai = $this->request->getPost('tanggalMulai') . " 00:00:00";
        $tanggalSelesai = $this->request->getPost('tanggalSelesai') . " 23:59:59";

        $transaksi = $this->dataPemesananModel->where(['tgl_transaksi >=' => $tanggalMulai, 'tgl_transaksi <=' => $tanggalSelesai])->findAll();

        echo json_encode($transaksi);
    }

    public function dataBarang()
    {
        $tanggalMulai = $this->request->getPost('tanggalMulai') . " 00:00:00";
        $tanggalSelesai = $this->request->getPost('tanggalSelesai') . " 23:59:59";
    
        try {
            // Periksa query untuk memastikan bahwa kolom waktu digunakan dengan benar
            $barang = $this->barangModel->where(['waktu >=' => $tanggalMulai, 'waktu <=' => $tanggalSelesai])->findAll();
    
            echo json_encode($barang);
        } catch (\Exception $e) {
            // Debugging: Print the exception message
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
