<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title">Daftar Barang</h4>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">Tambah Data</button>
                    <button class="btn btn-primary" onclick="exportPdf()">Export PDF</button>
                </div>
                <div class="bg-white text-center p-3" style="border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <h6 class="text-muted">Stok</h6>
                    <h4 id="jumlahStok">0</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tabelBarang">
                        <thead class="text-info">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Waktu</th>
                                <th>Nama Mesin</th>
                                <th>Qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row">
                        <label for="namaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu" class="col-sm-2 col-form-label">Waktu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control datetimepicker-input" id="waktu" name="waktu" data-toggle="datetimepicker" data-target="#waktu" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_mesin" class="col-sm-2 col-form-label">Nama Mesin</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="nama_mesin" name="nama_mesin"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="qty" class="col-sm-2 col-form-label">Qty</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="qty" name="qty">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info" onclick="tambah()">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <input type="hidden" id="idEdit" name="id">
                    <div class="form-group row">
                        <label for="edit_namaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit_namaBarang" name="namaBarang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_waktu" class="col-sm-2 col-form-label">Waktu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control datetimepicker-input" id="edit_waktu" name="waktu" data-toggle="datetimepicker" data-target="#edit_waktu" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_nama_mesin" class="col-sm-2 col-form-label">Nama Mesin</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="edit_nama_mesin" name="nama_mesin"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_qty" class="col-sm-2 col-form-label">Qty</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit_qty" name="qty">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info" onclick="simpanEdit()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Barang</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="idHapus" name="idHapus">
                <p>Apakah anda yakin ingin menghapus <b id="detailHapus">....</b> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="hapus()" class="btn btn-info">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $(document).ready(function() {
        muatData();
        muatMesin();
        updateJumlahStok();

        $('#waktu').datetimepicker({
            locale: 'id',
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });

        $('#edit_waktu').datetimepicker({
            locale: 'id',
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
    });

    function muatData() {
        $.ajax({
            url: '<?= base_url() ?>/barang/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = '';
                for (let i = 0; i < data.length; i++) {
                    var waktu = moment(data[i].waktu).format('D MMMM YYYY, HH.mm');
                    tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].namaBarang + "</td><td>" + waktu + "</td><td>" + data[i].nama_mesin + "</td><td>" + data[i].qty + "</td><td><a href='#' id='edit" + data[i].id + "' onclick='tryEdit(" + data[i].id + ", \"" + data[i].namaBarang + "\", \"" + data[i].waktu + "\", \"" + data[i].nama_mesin + "\", \"" + data[i].qty + "\")' ><i class='fa fa-edit'></i></a> <a href='#' id='hapus" + data[i].id + "' onclick='tryHapus(" + data[i].id + ", \"" + data[i].namaBarang + "\")' ><i class='fa fa-trash'></i></a></td></tr>";
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="6">Data Masih kosong :)</td>';
                }
                $("#tabelBarang tbody").html(tabel);
                updateJumlahStok();
            }
        });
    }

    function muatMesin() {
        $.ajax({
            url: '<?= base_url() ?>/barang/muatMesin',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Pilih Mesin</option>';
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].nama_mesin + '">' + data[i].nama_mesin + '</option>';
                }
                $("#nama_mesin").html(options);
                $("#edit_nama_mesin").html(options);
            }
        });
    }

    function tambah() {
        if ($("#namaBarang").val() == "") {
            $("#namaBarang").focus();
        } else if ($("#waktu").val() == "") {
            $("#waktu").focus();
        } else if ($("#nama_mesin").val() == "") {
            $("#nama_mesin").focus();
        } else if ($("#qty").val() == "") {
            $("#qty").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'namaBarang=' + $("#namaBarang").val() + '&waktu=' + $("#waktu").val() + '&nama_mesin=' + $("#nama_mesin").val() + '&qty=' + $("#qty").val(),
                url: '<?= base_url() ?>/barang/tambah',
                dataType: 'json',
                success: function(data) {
                    alert('Data berhasil ditambahkan');
                    $("#namaBarang").val("");
                    $("#waktu").val("");
                    $("#nama_mesin").val("");
                    $("#qty").val("");
                    $("#modalTambah").modal('hide');
                    muatData();
                }
            });
        }
    }

    function tryEdit(id, namaBarang, waktu, nama_mesin, qty) {
        $("#idEdit").val(id);
        $("#edit_namaBarang").val(namaBarang);
        $("#edit_waktu").val(waktu);
        $("#edit_nama_mesin").val(nama_mesin);
        $("#edit_qty").val(qty);
        $("#modalEdit").modal('show');
    }

    function simpanEdit() {
        $.ajax({
            type: 'POST',
            data: 'id=' + $("#idEdit").val() + '&namaBarang=' + $("#edit_namaBarang").val() + '&waktu=' + $("#edit_waktu").val() + '&nama_mesin=' + $("#edit_nama_mesin").val() + '&qty=' + $("#edit_qty").val(),
            url: '<?= base_url() ?>/barang/edit',
            dataType: 'json',
            success: function(data) {
                alert('Data berhasil diperbarui');
                $("#modalEdit").modal('hide');
                muatData();
            }
        });
    }

    function tryHapus(id, nama) {
        $("#hapus" + id).html('<i class="fa fa-spinner fa-pulse"></i>')
        $("#idHapus").val(id)
        $("#detailHapus").html(nama + " (" + id + ") ")
        $("#hapus" + id).html('<i class="fa fa-trash"></i>')
        $("#modalHapus").modal('show')
    }

    function hapus() {
        $("#hapus").html('<i class="fa fa-spinner fa-pulse"></i> Memproses..')
        var id = $("#idHapus").val()
        $.ajax({
            url: '<?= base_url() ?>/barang/hapus',
            method: 'post',
            data: "id=" + id,
            dataType: 'json',
            success: function(data) {
                alert('Data berhasil dihapus');
                $("#idHapus").val("")
                $("#detailHapus").html("")
                $("#modalHapus").modal('hide')
                $("#hapus").html('Hapus')
                muatData()
            }
        });
    }

    function updateJumlahStok() {
    $.ajax({
        url: '<?= base_url() ?>/barang/muatData',
        method: 'post',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var stokTerakhir = data[data.length - 1].stok;
                $("#jumlahStok").text(stokTerakhir);
            } else {
                $("#jumlahStok").text('0'); // Jika tidak ada data, tampilkan 0
            }
        }
    });
}


    function previewPdf() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Data Barang", 14, 10);
        doc.line(14, 12, 196, 12);
        doc.autoTable({
            head: [
                ['No', 'Nama Barang', 'Waktu', 'Nama Mesin', 'Qty']
            ],
            body: extractTableData(),
            startY: 15,
            theme: 'grid'
        });
        doc.output('dataurlnewwindow');
    }

    function exportPdf() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Data Barang", 14, 10);
        doc.line(14, 12, 196, 12);
        doc.autoTable({
            head: [
                ['No', 'Nama Barang', 'Waktu', 'Nama Mesin', 'Qty']
            ],
            body: extractTableData(),
            startY: 15,
            theme: 'grid'
        });
        doc.save("Laporan_Barang.pdf");
    }

    function extractTableData() {
        var data = [];
        $("#tabelBarang tbody tr").each(function(index, tr) {
            var row = [];
            $(tr).find('td').each(function(index, td) {
                if (index < 6) {
                    row.push($(td).text());
                }
            });
            data.push(row);
        });
        return data;
    }
</script>
<?php $this->endSection() ?>