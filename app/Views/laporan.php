<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="col-sm-2">
                        <h2 class="card-title">Laporan Data Pemesanan</h2>
                        <div id="pesanError" class="badge badge-danger"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tanggalMulai" class="badge badge-info">Dari tgl</label>
                            <input type="date" class="form-control input-pill" id="tanggalMulai">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tanggalSelesai" class="badge badge-info">Sampai tgl</label>
                            <input type="date" class="form-control input-pill" id="tanggalSelesai">
                        </div>
                    </div>
                    <div class="col-sm-4 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm" onclick="tampilkan()">Cari</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDF('hari')">Cetak Laporan Harian</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDF('bulan')">Cetak Laporan Bulanan</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDF('tahun')">Cetak Laporan Tahunan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tempatTabel">
                    <!-- Tabel akan ditampilkan di sini -->
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="col-sm-2">
                        <h2 class="card-title">Laporan Data Barang</h2>
                        <div id="pesanErrorBarang" class="badge badge-danger"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tanggalMulaiBarang" class="badge badge-info">Dari tgl</label>
                            <input type="date" class="form-control input-pill" id="tanggalMulaiBarang">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tanggalSelesaiBarang" class="badge badge-info">Sampai tgl</label>
                            <input type="date" class="form-control input-pill" id="tanggalSelesaiBarang">
                        </div>
                    </div>
                    <div class="col-sm-4 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm" onclick="tampilkanBarang()">Cari</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDFBarang('hari')">Cetak Laporan Harian</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDFBarang('bulan')">Cetak Laporan Bulanan</button>
                        <button class="btn btn-success btn-sm ml-2" onclick="cetakPDFBarang('tahun')">Cetak Laporan Tahunan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tempatTabelBarang">
                    <!-- Tabel akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
<script>
    settanggal();

    function settanggal() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $("#tanggalMulai").val(today);
        $("#tanggalSelesai").val(today);
        $("#tanggalMulaiBarang").val(today);
        $("#tanggalSelesaiBarang").val(today);
    }

    function formatTanggal(tanggal) {
        var options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Date(tanggal).toLocaleDateString('id-ID', options);
    }

    function tampilkan() {
        var tanggalMulai = $("#tanggalMulai").val();
        var tanggalSelesai = $("#tanggalSelesai").val();

        if (tanggalMulai > tanggalSelesai) {
            $("#pesanError").html("Tanggal Mulai tidak Boleh Melebihi tanggal Selesai");
        } else {
            $("#pesanError").html("");

            $.ajax({
                url: '<?= base_url() ?>/laporan/dataPemesanan',
                method: 'post',
                data: {
                    tanggalMulai: tanggalMulai,
                    tanggalSelesai: tanggalSelesai
                },
                dataType: 'json',
                success: function(data) {
                    var tabel = '<table id="tabelLaporan" class="display table table-striped table-hover"><thead><tr>';
                    tabel += '<th>NO</th><th>TANGGAL</th><th>NAMA COSTUMER</th><th>TUJUAN</th><th>Qty (Kg)</th><th>NO MOBIL</th><th>NAMA SUPIR</th><th>NO HP</th><th>METODE BAYAR</th><th>SHIFT</th><th>STATUS</th>';
                    tabel += '</tr></thead><tbody>';

                    for (let i = 0; i < data.length; i++) {
                        tabel += '<tr>';
                        tabel += '<td>' + (i + 1) + '</td>';
                        tabel += '<td>' + formatTanggal(data[i].tgl_transaksi) + '</td>';
                        tabel += '<td>' + data[i].nama_costumer + '</td>';
                        tabel += '<td>' + data[i].tujuan + '</td>';
                        tabel += '<td>' + data[i].qty + '</td>';
                        tabel += '<td>' + data[i].no_mobil + '</td>';
                        tabel += '<td>' + data[i].nama_supir + '</td>';
                        tabel += '<td>' + data[i].no_hp + '</td>';
                        tabel += '<td>' + data[i].metode_bayar + '</td>';
                        tabel += '<td>' + data[i].shift + '</td>';
                        tabel += '<td>' + data[i].status + '</td>';
                        tabel += '</tr>';
                    }
                    tabel += '</tbody></table>';
                    $("#tempatTabel").html(tabel);
                    $('#tabelLaporan').DataTable({
                        "pageLength": 10,
                    });
                }
            });
        }
    }

    function tampilkanBarang() {
        var tanggalMulaiBarang = $("#tanggalMulaiBarang").val();
        var tanggalSelesaiBarang = $("#tanggalSelesaiBarang").val();

        if (tanggalMulaiBarang > tanggalSelesaiBarang) {
            $("#pesanErrorBarang").html("Tanggal Mulai tidak Boleh Melebihi tanggal Selesai");
        } else {
            $("#pesanErrorBarang").html("");

            $.ajax({
                url: '<?= base_url() ?>/laporan/dataBarang',
                method: 'post',
                data: {
                    tanggalMulai: tanggalMulaiBarang,
                    tanggalSelesai: tanggalSelesaiBarang
                },
                dataType: 'json',
                success: function(data) {
                    var tabel = '<table id="tabelLaporanBarang" class="display table table-striped table-hover"><thead><tr>';
                    tabel += '<th>NO</th><th>TANGGAL</th><th>NAMA BARANG</th><th>WAKTU</th><th>NAMA MESIN</th><th>QTY</th>';
                    tabel += '</tr></thead><tbody>';

                    for (let i = 0; i < data.length; i++) {
                        tabel += '<tr>';
                        tabel += '<td>' + (i + 1) + '</td>';
                        tabel += '<td>' + formatTanggal(data[i].waktu) + '</td>';
                        tabel += '<td>' + data[i].namaBarang + '</td>';
                        tabel += '<td>' + data[i].waktu + '</td>';
                        tabel += '<td>' + data[i].nama_mesin + '</td>';
                        tabel += '<td>' + data[i].qty + '</td>';
                        tabel += '</tr>';
                    }
                    tabel += '</tbody></table>';
                    $("#tempatTabelBarang").html(tabel);
                    $('#tabelLaporanBarang').DataTable({
                        "pageLength": 10,
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    }



    function cetakPDF(jenis) {
        const {
            jsPDF
        } = window.jspdf;
        var doc = new jsPDF('landscape');

        var tanggalMulai = new Date($("#tanggalMulai").val());
        var tanggalSelesai = new Date($("#tanggalSelesai").val());

        const formatTanggal = (tanggal) => {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return tanggal.toLocaleDateString('id-ID', options);
        };

        doc.text('Laporan Penjualan', doc.internal.pageSize.getWidth() / 2, 16, {
            align: 'center'
        });
        doc.setFontSize(10);

        if (jenis === 'hari') {
            doc.text('Laporan Penjualan Harian', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode ' + formatTanggal(tanggalMulai), doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else if (jenis === 'bulan') {
            var bulanTahun = tanggalMulai.toLocaleString('id-ID', {
                month: 'long',
                year: 'numeric'
            });
            doc.text('Laporan Penjualan Bulanan', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode ' + bulanTahun, doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else if (jenis === 'tahun') {
            var tahun = tanggalMulai.getFullYear();
            doc.text('Laporan Penjualan Tahunan', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode Tahun ' + tahun, doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else {
            doc.text('Periode ' + formatTanggal(tanggalMulai) + ' - ' + formatTanggal(tanggalSelesai), doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        }

        var elem = document.getElementById('tabelLaporan');
        var res = doc.autoTableHtmlToJson(elem);
        doc.autoTable(res.columns, res.data, {
            startY: 32,
            styles: {
                overflow: 'linebreak'
            },
            columnStyles: {
                text: {
                    cellWidth: 'wrap'
                }
            },
            margin: {
                top: 32
            },
        });

        doc.save('Laporan_Penjualan_' + jenis + '.pdf');
    }

    function cetakPDFBarang(jenis) {
        const {
            jsPDF
        } = window.jspdf;
        var doc = new jsPDF('landscape');

        var tanggalMulaiBarang = new Date($("#tanggalMulaiBarang").val());
        var tanggalSelesaiBarang = new Date($("#tanggalSelesaiBarang").val());

        const formatTanggal = (tanggal) => {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return tanggal.toLocaleDateString('id-ID', options);
        };

        doc.text('Laporan Data Barang', doc.internal.pageSize.getWidth() / 2, 16, {
            align: 'center'
        });
        doc.setFontSize(10);

        if (jenis === 'hari') {
            doc.text('Laporan Harian', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode ' + formatTanggal(tanggalMulaiBarang), doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else if (jenis === 'bulan') {
            var bulanTahun = tanggalMulaiBarang.toLocaleString('id-ID', {
                month: 'long',
                year: 'numeric'
            });
            doc.text('Laporan Bulanan', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode ' + bulanTahun, doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else if (jenis === 'tahun') {
            var tahun = tanggalMulaiBarang.getFullYear();
            doc.text('Laporan Tahunan', doc.internal.pageSize.getWidth() / 2, 22, {
                align: 'center'
            });
            doc.text('Periode Tahun ' + tahun, doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        } else {
            doc.text('Periode ' + formatTanggal(tanggalMulaiBarang) + ' - ' + formatTanggal(tanggalSelesaiBarang), doc.internal.pageSize.getWidth() / 2, 28, {
                align: 'center'
            });
        }

        var elem = document.getElementById('tabelLaporanBarang');
        var res = doc.autoTableHtmlToJson(elem);
        doc.autoTable(res.columns, res.data, {
            startY: 32,
            styles: {
                overflow: 'linebreak'
            },
            columnStyles: {
                text: {
                    cellWidth: 'wrap'
                }
            },
            margin: {
                top: 32
            },
        });

        doc.save('Laporan_Barang_' + jenis + '.pdf');
    }
</script>
<?php $this->endSection() ?>