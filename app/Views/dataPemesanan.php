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
                            <?php foreach ($barang as $b) : ?>
                                <option value="<?= $b['id'] ?>"><?= $b['namaBarang'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi">
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
                            <?php if (session()->get('rule') == 0) : ?>
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
                            <?php foreach ($barang as $b) : ?>
                                <option value="<?= $b['id'] ?>"><?= $b['namaBarang'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="edit_tgl_transaksi" name="tgl_transaksi">
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
                            <?php if (session()->get('rule') == 0) : ?>
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
                <h5 class="modal-title" id="modalPreviewLabel">Preview Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPreview">
                    <!-- Fields to preview the transaction -->
                    <div class="form-group">
                        <label for="preview_id_barang">Barang</label>
                        <input type="text" class="form-control" id="preview_id_barang" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_tgl_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="preview_tgl_transaksi" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_nama_costumer">Nama Customer</label>
                        <input type="text" class="form-control" id="preview_nama_costumer" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_tujuan">Tujuan</label>
                        <input type="text" class="form-control" id="preview_tujuan" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_qty">Qty</label>
                        <input type="number" class="form-control" id="preview_qty" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_no_mobil">No Mobil</label>
                        <input type="text" class="form-control" id="preview_no_mobil" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_nama_supir">Nama Supir</label>
                        <input type="text" class="form-control" id="preview_nama_supir" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_no_hp">No HP</label>
                        <input type="text" class="form-control" id="preview_no_hp" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_metode_bayar">Metode Bayar</label>
                        <input type="text" class="form-control" id="preview_metode_bayar" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_shift">Shift</label>
                        <input type="text" class="form-control" id="preview_shift" disabled>
                    </div>
                    <div class="form-group">
                        <label for="preview_status">Status</label>
                        <input type="text" class="form-control" id="preview_status" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function muatData() {
    $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...')
    $.ajax({
        url: '<?= base_url() ?>/dataPemesanan/muatData',
        method: 'post',
        dataType: 'json',
        success: function(data) {
            var tabel = '';
            for (let i = 0; i < data.length; i++) {
                var formattedDate = formatTanggal(data[i].tgl_transaksi);
                tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].namaBarang + "</td><td>" + formattedDate + "</td><td>" + data[i].nama_costumer + "</td><td>" + data[i].tujuan + "</td><td>" + data[i].qty + "</td><td>" + data[i].no_mobil + "</td><td>" + data[i].nama_supir + "</td><td>" + data[i].no_hp + "</td><td>" + data[i].metode_bayar + "</td><td>" + data[i].shift + "</td><td>" + data[i].status + "</td><td><a href='#' onclick='edit(" + data[i].id_transaksi + ")'><i class='fa fa-edit'></i></a> <a href='#' onclick='hapus(" + data[i].id_transaksi + ")'><i class='fa fa-trash'></i></a>";
                <?php if (session()->get('rule') == 0) : ?>
                tabel += " <a href='#' onclick='preview(" + data[i].id_transaksi + ")'><i class='fa fa-eye'></i></a></td></tr>";
                <?php endif; ?>
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
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var locale = 'id-ID';
    var date = new Date(dateString);
    return date.toLocaleDateString(locale, options);
}

function tambah() {
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
        data: { id_transaksi: id },
        dataType: 'json',
        success: function(data) {
            $("#edit_id_transaksi").val(data.id_transaksi);
            $("#edit_id_barang").val(data.id_barang);
            $("#edit_tgl_transaksi").val(data.tgl_transaksi);
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
        url: '<?= base_url() ?>/dataPemesanan/getById',
        method: 'post',
        data: { id_transaksi: id },
        dataType: 'json',
        success: function(data) {
            $("#preview_id_barang").val(data.namaBarang);
            $("#preview_tgl_transaksi").val(data.tgl_transaksi);
            $("#preview_nama_costumer").val(data.nama_costumer);
            $("#preview_tujuan").val(data.tujuan);
            $("#preview_qty").val(data.qty);
            $("#preview_no_mobil").val(data.no_mobil);
            $("#preview_nama_supir").val(data.nama_supir);
            $("#preview_no_hp").val(data.no_hp);
            $("#preview_metode_bayar").val(data.metode_bayar);
            $("#preview_shift").val(data.shift);
            $("#preview_status").val(data.status);
            $('#modalPreview').modal('show');
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
            data: { id_transaksi: id },
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

muatData();
</script>

<?php $this->endSection() ?>
