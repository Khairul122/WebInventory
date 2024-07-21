<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataPemesananModel;
use App\Models\BarangModel;

class Beranda extends BaseController
{
    protected $dataPemesananModel;
    protected $barangModel;

    public function __construct()
    {
        $this->dataPemesananModel = new DataPemesananModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $jumlahPemesanan = $this->dataPemesananModel->countAllResults();
        $jumlahBarang = $this->barangModel->countAllResults();
        $jumlahPemesananAcc = $this->dataPemesananModel->where('status', 'acc')->countAllResults();
        $jumlahPemesananPengajuan = $this->dataPemesananModel->where('status', 'pengajuan')->countAllResults();
        $dataPemesananPengajuan = $this->dataPemesananModel->where('status', 'pengajuan')->orderBy('tgl_transaksi', 'DESC')->findAll();

        $data = [
            'jumlahPemesanan' => $jumlahPemesanan,
            'jumlahBarang' => $jumlahBarang,
            'jumlahPemesananAcc' => $jumlahPemesananAcc,
            'jumlahPemesananPengajuan' => $jumlahPemesananPengajuan,
            'dataPemesananPengajuan' => $dataPemesananPengajuan
        ];

        return view('beranda', $data);
    }
}
