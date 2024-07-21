<?php $this->extend('template') ?>

<?php $this->section('content') ?>

<?php
function formatTanggal($tanggal)
{
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $tanggal = explode('-', $tanggal);
    return $tanggal[2] . ' ' . $bulanIndo[(int)$tanggal[1]] . ' ' . $tanggal[0];
}

usort($dataPemesananPengajuan, function($a, $b) {
    return $b['id'] - $a['id'];
});
?>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Jumlah Pemesanan</h5>
                <h3 class="card-text"><?= $jumlahPemesanan ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Jumlah Barang</h5>
                <h3 class="card-text"><?= $jumlahBarang ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Jumlah Pemesanan ACC</h5>
                <h3 class="card-text"><?= $jumlahPemesananAcc ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Jumlah Pemesanan Pengajuan</h5>
                <h3 class="card-text"><?= $jumlahPemesananPengajuan ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">Data Pemesanan Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Customer</th>
                                <th>Tujuan</th>
                                <th>Qty (Kg)</th>
                                <th>No Mobil</th>
                                <th>Nama Supir</th>
                                <th>No HP</th>
                                <th>Metode Bayar</th>
                                <th>Shift</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataPemesananPengajuan as $index => $pemesanan) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= formatTanggal($pemesanan['tgl_transaksi']) ?></td>
                                    <td><?= $pemesanan['nama_costumer'] ?></td>
                                    <td><?= $pemesanan['tujuan'] ?></td>
                                    <td><?= $pemesanan['qty'] ?></td>
                                    <td><?= $pemesanan['no_mobil'] ?></td>
                                    <td><?= $pemesanan['nama_supir'] ?></td>
                                    <td><?= $pemesanan['no_hp'] ?></td>
                                    <td><?= $pemesanan['metode_bayar'] ?></td>
                                    <td><?= $pemesanan['shift'] ?></td>
                                    <td><?= $pemesanan['status'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
