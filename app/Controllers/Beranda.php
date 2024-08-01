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
        $jumlahPemesananOnProses = $this->dataPemesananModel->where('status', 'on proses')->countAllResults();
        $jumlahPemesananBatal = $this->dataPemesananModel->where('status', 'batal')->countAllResults();
        $dataPemesananPengajuan = $this->dataPemesananModel->where('status', 'pengajuan')->orderBy('tgl_transaksi', 'DESC')->findAll();

        $data = [
            'jumlahPemesananPengajuan' => $jumlahPemesananPengajuan,
            'jumlahPemesananOnProses' => $jumlahPemesananOnProses,
            'jumlahPemesananBatal' => $jumlahPemesananBatal,
            'jumlahPemesananAcc' => $jumlahPemesananAcc,
            'dataPemesananPengajuan' => $dataPemesananPengajuan
        ];

        return view('beranda', $data);
    }
}
