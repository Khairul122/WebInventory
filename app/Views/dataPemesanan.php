<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Transaksi</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalTambah">Tambah Transaksi</button>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table class="table">
                    <thead class="text-info">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Tanggal</th>
                            <th>Nama Customer</th>
                            <th>Tujuan</th>
                            <th>Qty (Kg)</th>
                            <th>No Mobil</th>
                            <th>Nama Supir</th>
                            <th>No HP</th>
                            <th>Metode Bayar</th>
                            <th>Shift</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelTransaksi">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select class="form-control" id="id_barang" name="id_barang">
                            <?php if ($barang) : ?>
                                <option value="<?= $barang['id'] ?>" data-stok="<?= $barang['stok'] ?>"><?= $barang['namaBarang'] ?> - Stok: <?= $barang['stok'] ?></option>
                            <?php else : ?>
                                <option value="">Barang tidak tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_transaksi">Tanggal Transaksi</label>
                        <input type="text" class="form-control datetimepicker" id="tgl_transaksi" name="tgl_transaksi">
                    </div>
                    <div class="form-group">
                        <label for="nama_costumer">Nama Customer</label>
                        <input type="text" class="form-control" id="nama_costumer" name="nama_costumer">
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" name="tujuan">
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="no_mobil">No Mobil</label>
                        <input type="text" class="form-control" id="no_mobil" name="no_mobil">
                    </div>
                    <div class="form-group">
                        <label for="nama_supir">Nama Supir</label>
                        <input type="text" class="form-control" id="nama_supir" name="nama_supir">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp">
                    </div>
                    <div class="form-group">
                        <label for="metode_bayar">Metode Bayar</label>
                        <select class="form-control" id="metode_bayar" name="metode_bayar">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <select class="form-control" id="shift" name="shift">
                            <option value="pagi">Pagi</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pengajuan">Pengajuan</option>
                            <option value="antrian">Antrian</option>
                            <option value="jalan">Jalan</option>
                            <option value="batal">Batal</option>
                            <?php if (session()->get('rule') == 1) : ?>
                                <option value="acc">ACC</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </form>
                <div class="text-center">
                    <button class="btn btn-info" onclick="tambah()" id="tambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <input type="hidden" id="edit_id_transaksi" name="id_transaksi">
                    <div class="form-group">
                        <label for="edit_id_barang">Barang</label>
                        <select class="form-control" id="edit_id_barang" name="id_barang">
                            <?php if ($barang) : ?>
                                <option value="<?= $barang['id'] ?>"><?= $barang['namaBarang'] ?> - Stok: <?= $barang['stok'] ?></option>
                            <?php else : ?>
                                <option value="">Barang tidak tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_transaksi">Tanggal Transaksi</label>
                        <input type="text" class="form-control datetimepicker" id="edit_tgl_transaksi" name="tgl_transaksi">
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_costumer">Nama Customer</label>
                        <input type="text" class="form-control" id="edit_nama_costumer" name="nama_costumer">
                    </div>
                    <div class="form-group">
                        <label for="edit_tujuan">Tujuan</label>
                        <input type="text" class="form-control" id="edit_tujuan" name="tujuan">
                    </div>
                    <div class="form-group">
                        <label for="edit_qty">Qty</label>
                        <input type="number" class="form-control" id="edit_qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="edit_no_mobil">No Mobil</label>
                        <input type="text" class="form-control" id="edit_no_mobil" name="no_mobil">
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_supir">Nama Supir</label>
                        <input type="text" class="form-control" id="edit_nama_supir" name="nama_supir">
                    </div>
                    <div class="form-group">
                        <label for="edit_no_hp">No HP</label>
                        <input type="text" class="form-control" id="edit_no_hp" name="no_hp">
                    </div>
                    <div class="form-group">
                        <label for="edit_metode_bayar">Metode Bayar</label>
                        <select class="form-control" id="edit_metode_bayar" name="metode_bayar">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_shift">Shift</label>
                        <select class="form-control" id="edit_shift" name="shift">
                            <option value="pagi">Pagi</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status">
                            <option value="pengajuan">Pengajuan</option>
                            <option value="antrian">Antrian</option>
                            <option value="jalan">Jalan</option>
                            <option value="batal">Batal</option>
                            <?php if (session()->get('rule') == 1) : ?>
                                <option value="acc">ACC</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="updateData()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Data -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewLabel">Preview DO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pdfPreview" style="width: 100%; height: 500px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Datetimepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- PDFObject -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.21/jspdf.plugin.autotable.min.js"></script>

<script>
    $(document).ready(function() {
        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d H:i:s',
            step: 1
        });

        muatData();
    });

    var sessionRule = <?= session()->get('rule') ?>;

    function muatData() {
        $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...')
        $.ajax({
            url: '<?= base_url() ?>/dataPemesanan/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = '';
                for (let i = 0; i < data.length; i++) {
                    var formattedDateTime = formatTanggal(data[i].tgl_transaksi);
                    tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].namaBarang + "</td><td>" + formattedDateTime + "</td><td>" + data[i].nama_costumer + "</td><td>" + data[i].tujuan + "</td><td>" + data[i].qty + "</td><td>" + data[i].no_mobil + "</td><td>" + data[i].nama_supir + "</td><td>" + data[i].no_hp + "</td><td>" + data[i].metode_bayar + "</td><td>" + data[i].shift + "</td><td>" + data[i].status + "</td><td>";
                    tabel += "<a href='#' onclick='edit(" + data[i].id_transaksi + ")'><i class='fa fa-edit'></i></a> ";
                    tabel += "<a href='#' onclick='hapus(" + data[i].id_transaksi + ")'><i class='fa fa-trash'></i></a> ";
                    if (sessionRule == 0 && data[i].status == 'acc') {
                        tabel += "<a href='#' onclick='preview(" + data[i].id_transaksi + ")'><i class='fa fa-print'></i></a> ";
                    }
                    tabel += "</td></tr>";
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="13">Data Masih kosong :)</td>';
                }
                $("#tabelTransaksi").html(tabel);
                $("#tambah").html('Tambah');
            },
            error: function() {
                $("#tambah").html('Tambah');
                alert('Gagal memuat data, coba lagi.');
            }
        });
    }

    function formatTanggal(dateString) {
        var date = new Date(dateString);
        var options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options).replace(' pukul', ',');
    }

    function tambah() {
        var selectedBarang = $('#id_barang').find(':selected');
        var stokTersedia = parseInt(selectedBarang.data('stok'));
        var qtyDipesan = parseInt($("#qty").val());

        if (qtyDipesan > stokTersedia) {
            alert("Data pemesanan melebihi data pada stok!");
            return;
        }

        if ($("#tgl_transaksi").val() == "" || $("#nama_costumer").val() == "" || $("#tujuan").val() == "" || $("#qty").val() == "" || $("#no_mobil").val() == "" || $("#nama_supir").val() == "" || $("#no_hp").val() == "" || $("#metode_bayar").val() == "" || $("#shift").val() == "" || $("#status").val() == "") {
            alert("Semua field harus diisi!");
        } else {
            $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...');
            $.ajax({
                type: 'POST',
                data: {
                    tgl_transaksi: $("#tgl_transaksi").val(),
                    nama_costumer: $("#nama_costumer").val(),
                    tujuan: $("#tujuan").val(),
                    qty: $("#qty").val(),
                    no_mobil: $("#no_mobil").val(),
                    nama_supir: $("#nama_supir").val(),
                    no_hp: $("#no_hp").val(),
                    metode_bayar: $("#metode_bayar").val(),
                    shift: $("#shift").val(),
                    status: $("#status").val(),
                    id_barang: $("#id_barang").val()
                },
                url: '<?= base_url() ?>/dataPemesanan/tambah',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Data berhasil ditambahkan!');
                        $("#formTambah")[0].reset();
                        muatData();
                    } else {
                        alert('Gagal menambahkan data: ' + response.message);
                    }
                    $("#tambah").html('Tambah');
                },
                error: function() {
                    $("#tambah").html('Tambah');
                    alert('Gagal menambahkan data, coba lagi.');
                }
            });
        }
    }


    function edit(id) {
        $.ajax({
            url: '<?= base_url() ?>/dataPemesanan/getById',
            method: 'post',
            data: {
                id_transaksi: id
            },
            dataType: 'json',
            success: function(data) {
                $("#edit_id_transaksi").val(data.id_transaksi);
                $("#edit_id_barang").val(data.id_barang);
                $("#edit_tgl_transaksi").val(data.tgl_transaksi.replace(" ", "T"));
                $("#edit_nama_costumer").val(data.nama_costumer);
                $("#edit_tujuan").val(data.tujuan);
                $("#edit_qty").val(data.qty);
                $("#edit_no_mobil").val(data.no_mobil);
                $("#edit_nama_supir").val(data.nama_supir);
                $("#edit_no_hp").val(data.no_hp);
                $("#edit_metode_bayar").val(data.metode_bayar);
                $("#edit_shift").val(data.shift);
                $("#edit_status").val(data.status);
                $('#modalEdit').modal('show');
            },
            error: function() {
                alert('Gagal mengambil data, coba lagi.');
            }
        });
    }

    function preview(id) {
        $.ajax({
            url: `<?= base_url() ?>/dataPemesanan/getById`,
            method: 'post',
            data: {
                id_transaksi: id
            },
            dataType: 'json',
            success: function(data) {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                const img = new Image();
                img.src = '<?= base_url() ?>/public/images/logo-ads.jpg';
                img.onload = function() {
                    doc.addImage(img, 'JPEG', 20, 10, 20, 20);
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(16);
                    doc.text("PT. ANDALAS DOLOMIT SEJAHTERA", 105, 40, null, null, 'center');

                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(10);
                    const lineHeight = 5;
                    const address = [
                        "Jln Rambutan Komplek Ruko Royal Mansion Blok B No.2 RT 006, RW 001",
                        "Kel. Sidomulyo Timur",
                        "Kec. Marpoyan Damai Kota Pekanbaru, Riau (28125)"
                    ];
                    let startY = 50;
                    address.forEach((line) => {
                        doc.text(line, 20, startY);
                        startY += lineHeight;
                    });

                    doc.text("No. Sj : 0", 160, 50);
                    doc.text("No. PO : 0", 160, 60);

                    doc.setFontSize(12);
                    doc.setFont("helvetica", "bold");
                    doc.text("SURAT PERMINTAAN PENGELUARAN BARANG", 105, 80, null, null, 'center');
                    doc.setFont("helvetica", "normal");

                    doc.autoTable({
                        startY: 90,
                        head: [
                            ['No', 'Jenis Barang', 'Qty', 'Unit', 'Total Unit', 'Remark']
                        ],
                        body: [
                            ['1', data.namaBarang, data.qty, 'KG', data.stok, 'OK']
                        ],
                        theme: 'grid',
                        styles: {
                            fontSize: 10,
                            cellPadding: 1,
                            halign: 'center',
                            valign: 'middle',
                            lineWidth: 0.1,
                            lineColor: [0, 0, 0]
                        },
                        headStyles: {
                            fillColor: [255, 255, 255],
                            textColor: [0, 0, 0],
                            fontStyle: 'bold',
                            lineWidth: 0.1,
                            lineColor: [0, 0, 0]
                        },
                        tableLineColor: [0, 0, 0],
                        tableLineWidth: 0.1,
                        margin: {
                            left: 20,
                            right: 20
                        },
                        tableWidth: 'auto'
                    });

                    const now = new Date();
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const formattedDate = now.toLocaleDateString('id-ID', options);

                    let tableEndY = doc.autoTable.previous.finalY + 10;
                    const leftPadding = 1;

                    doc.text("Nama Pembeli", 20 + leftPadding, tableEndY);
                    doc.text(`: ${data.nama_costumer}`, 60 + leftPadding, tableEndY);
                    tableEndY += lineHeight;
                    doc.text("Tujuan", 20 + leftPadding, tableEndY);
                    doc.text(`: ${data.tujuan}`, 60 + leftPadding, tableEndY);
                    tableEndY += lineHeight;
                    doc.text("Angkutan", 20 + leftPadding, tableEndY);
                    doc.text(`: ${data.nama_supir}`, 60 + leftPadding, tableEndY);
                    tableEndY += lineHeight;
                    doc.text("No Polisi", 20 + leftPadding, tableEndY);
                    doc.text(`: ${data.no_mobil}`, 60 + leftPadding, tableEndY);
                    tableEndY += lineHeight;
                    doc.text("No HP Supir", 20 + leftPadding, tableEndY);
                    doc.text(`: ${data.no_hp}`, 60 + leftPadding, tableEndY);

                    const signatureData = [
                        ['Dibuat Oleh', 'Disetujui Oleh'],
                        [`Nama : ${data.nama_admin || ''}\nTanggal : ${formattedDate}`, `Nama : DIREKTUR\nTanggal : ${formattedDate}`]
                    ];

                    doc.autoTable({
                        startY: tableEndY + 20,
                        head: [signatureData[0]],
                        body: [signatureData[1]],
                        theme: 'grid',
                        styles: {
                            fontSize: 10,
                            cellPadding: {
                                top: 3,
                                right: 5,
                                bottom: 3,
                                left: 5
                            },
                            valign: 'top',
                            lineColor: [0, 0, 0],
                            lineWidth: 0.1,
                            minCellHeight: 10,
                        },
                        headStyles: {
                            fontStyle: 'bold',
                            halign: 'left',
                            fillColor: [255, 255, 255],
                            textColor: [0, 0, 0],
                        },
                        bodyStyles: {
                            halign: 'left',
                            cellPadding: {
                                top: 5,
                                right: 5,
                                bottom: 35,
                                left: 5
                            },
                        },
                        columnStyles: {
                            0: {
                                cellWidth: 60,
                                halign: 'left'
                            },
                            1: {
                                cellWidth: 60,
                                halign: 'left'
                            },
                        },
                        margin: {
                            left: 20
                        },
                    });

                    const signatureImg = new Image();
                    signatureImg.src = '<?= base_url() ?>/public/images/ttd.png';
                    signatureImg.onload = function() {
                        doc.addImage(signatureImg, 'PNG', 100, tableEndY + 35, 50, 50);

                        const pdfBlob = doc.output('blob');
                        const pdfUrl = URL.createObjectURL(pdfBlob);

                        PDFObject.embed(pdfUrl, "#pdfPreview");
                        $('#modalPreview').modal('show');
                    };
                };
            },
            error: function() {
                alert('Gagal mengambil data, coba lagi.');
            }
        });
    }


    function updateData() {
        var data = $("#formEdit").serialize();
        $.ajax({
            url: '<?= base_url() ?>/dataPemesanan/update',
            method: 'post',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $('#modalEdit').modal('hide');
                    muatData();
                    alert('Data berhasil diperbarui!');
                } else {
                    alert('Gagal mengupdate data: ' + response.message);
                }
            },
            error: function() {
                alert('Gagal mengupdate data, coba lagi.');
            }
        });
    }

    function hapus(id) {
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: '<?= base_url() ?>/dataPemesanan/hapus',
                method: 'post',
                data: {
                    id_transaksi: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Data berhasil dihapus!');
                        muatData();
                    } else {
                        alert('Gagal menghapus data: ' + response.message);
                    }
                },
                error: function() {
                    alert('Gagal menghapus data, coba lagi.');
                }
            });
        }
    }
</script>

<?php $this->endSection() ?>