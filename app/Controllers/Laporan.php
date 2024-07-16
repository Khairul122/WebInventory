<?php

namespace App\Controllers;

use App\Models\DataPemesananModel;

class Laporan extends BaseController
{
    protected $dataPemesananModel;

    public function __construct()
    {
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
}
