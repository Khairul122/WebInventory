<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Barang</h4>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">Tambah Data</button>
                <button class="btn btn-primary" onclick="exportPdf()">Export PDF</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tabelBarang">
                        <thead class="text-info">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Mesin 1</th>
                                <th>Jumlah 1</th>
                                <th>Mesin 2</th>
                                <th>Jumlah 2</th>
                                <th>Mesin 3</th>
                                <th>Jumlah 3</th>
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
                        <label for="nama_mesin1" class="col-sm-2 col-form-label">Mesin 1</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="nama_mesin1" name="nama_mesin1"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah1" class="col-sm-2 col-form-label">Jumlah 1</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="jumlah1" name="jumlah1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_mesin2" class="col-sm-2 col-form-label">Mesin 2</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="nama_mesin2" name="nama_mesin2"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah2" class="col-sm-2 col-form-label">Jumlah 2</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="jumlah2" name="jumlah2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_mesin3" class="col-sm-2 col-form-label">Mesin 3</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="nama_mesin3" name="nama_mesin3"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah3" class="col-sm-2 col-form-label">Jumlah 3</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="jumlah3" name="jumlah3">
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
                        <label for="edit_nama_mesin1" class="col-sm-2 col-form-label">Mesin 1</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="edit_nama_mesin1" name="nama_mesin1"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_jumlah1" class="col-sm-2 col-form-label">Jumlah 1</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit_jumlah1" name="jumlah1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_nama_mesin2" class="col-sm-2 col-form-label">Mesin 2</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="edit_nama_mesin2" name="nama_mesin2"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_jumlah2" class="col-sm-2 col-form-label">Jumlah 2</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit_jumlah2" name="jumlah2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_nama_mesin3" class="col-sm-2 col-form-label">Mesin 3</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="edit_nama_mesin3" name="nama_mesin3"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_jumlah3" class="col-sm-2 col-form-label">Jumlah 3</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit_jumlah3" name="jumlah3">
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
<script>
    $(document).ready(function() {
        muatData();
        muatMesin();
    });

    function muatData() {
        $.ajax({
            url: '<?= base_url() ?>/barang/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = '';
                for (let i = 0; i < data.length; i++) {
                    tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].namaBarang + "</td><td>" + data[i].stok + "</td><td>" + data[i].nama_mesin1 + "</td><td>" + data[i].jumlah1 + "</td><td>" + data[i].nama_mesin2 + "</td><td>" + data[i].jumlah2 + "</td><td>" + data[i].nama_mesin3 + "</td><td>" + data[i].jumlah3 + "</td><td><a href='#' id='edit" + data[i].id + "' onclick='tryEdit(" + data[i].id + ", \"" + data[i].namaBarang + "\", \"" + data[i].nama_mesin1 + "\", \"" + data[i].jumlah1 + "\", \"" + data[i].nama_mesin2 + "\", \"" + data[i].jumlah2 + "\", \"" + data[i].nama_mesin3 + "\", \"" + data[i].jumlah3 + "\")' ><i class='fa fa-edit'></i></a> <a href='#' id='hapus" + data[i].id + "' onclick='tryHapus(" + data[i].id + ", \"" + data[i].namaBarang + "\")' ><i class='fa fa-trash'></i></a></td></tr>";
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="10">Data Masih kosong :)</td>';
                }
                $("#tabelBarang tbody").html(tabel);
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
                $("#nama_mesin1").html(options);
                $("#nama_mesin2").html(options);
                $("#nama_mesin3").html(options);
                $("#edit_nama_mesin1").html(options);
                $("#edit_nama_mesin2").html(options);
                $("#edit_nama_mesin3").html(options);
            }
        });
    }

    function tambah() {
        if ($("#namaBarang").val() == "") {
            $("#namaBarang").focus();
        } else if ($("#nama_mesin1").val() == "") {
            $("#nama_mesin1").focus();
        } else if ($("#jumlah1").val() == "") {
            $("#jumlah1").focus();
        } else if ($("#nama_mesin2").val() == "") {
            $("#nama_mesin2").focus();
        } else if ($("#jumlah2").val() == "") {
            $("#jumlah2").focus();
        } else if ($("#nama_mesin3").val() == "") {
            $("#nama_mesin3").focus();
        } else if ($("#jumlah3").val() == "") {
            $("#jumlah3").focus();
        } else {
            var stok = parseInt($("#jumlah1").val()) + parseInt($("#jumlah2").val()) + parseInt($("#jumlah3").val());
            $.ajax({
                type: 'POST',
                data: 'namaBarang=' + $("#namaBarang").val() + '&stok=' + stok + '&nama_mesin1=' + $("#nama_mesin1").val() + '&jumlah1=' + $("#jumlah1").val() + '&nama_mesin2=' + $("#nama_mesin2").val() + '&jumlah2=' + $("#jumlah2").val() + '&nama_mesin3=' + $("#nama_mesin3").val() + '&jumlah3=' + $("#jumlah3").val(),
                url: '<?= base_url() ?>/barang/tambah',
                dataType: 'json',
                success: function(data) {
                    alert('Data berhasil ditambahkan');
                    $("#namaBarang").val("");
                    $("#nama_mesin1").val("");
                    $("#jumlah1").val("");
                    $("#nama_mesin2").val("");
                    $("#jumlah2").val("");
                    $("#nama_mesin3").val("");
                    $("#jumlah3").val("");
                    $("#modalTambah").modal('hide');
                    muatData();
                }
            });
        }
    }

    function tryEdit(id, namaBarang, nama_mesin1, jumlah1, nama_mesin2, jumlah2, nama_mesin3, jumlah3) {
        $("#idEdit").val(id);
        $("#edit_namaBarang").val(namaBarang);
        $("#edit_nama_mesin1").val(nama_mesin1);
        $("#edit_jumlah1").val(jumlah1);
        $("#edit_nama_mesin2").val(nama_mesin2);
        $("#edit_jumlah2").val(jumlah2);
        $("#edit_nama_mesin3").val(nama_mesin3);
        $("#edit_jumlah3").val(jumlah3);
        $("#modalEdit").modal('show');
    }

    function simpanEdit() {
        var stok = parseInt($("#edit_jumlah1").val()) + parseInt($("#edit_jumlah2").val()) + parseInt($("#edit_jumlah3").val());
        $.ajax({
            type: 'POST',
            data: 'id=' + $("#idEdit").val() + '&namaBarang=' + $("#edit_namaBarang").val() + '&stok=' + stok + '&nama_mesin1=' + $("#edit_nama_mesin1").val() + '&jumlah1=' + $("#edit_jumlah1").val() + '&nama_mesin2=' + $("#edit_nama_mesin2").val() + '&jumlah2=' + $("#edit_jumlah2").val() + '&nama_mesin3=' + $("#edit_nama_mesin3").val() + '&jumlah3=' + $("#edit_jumlah3").val(),
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

    function previewPdf() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Data Barang", 14, 10);
        doc.line(14, 12, 196, 12); 
        doc.autoTable({
            head: [['No', 'Nama Barang', 'Stok', 'Mesin 1', 'Jumlah 1', 'Mesin 2', 'Jumlah 2', 'Mesin 3', 'Jumlah 3']],
            body: extractTableData(),
            startY: 15,
            theme: 'grid'
        });
        doc.output('dataurlnewwindow');
    }

    function exportPdf() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Data Barang", 14, 10);
        doc.line(14, 12, 196, 12); 
        doc.autoTable({
            head: [['No', 'Nama Barang', 'Stok', 'Mesin 1', 'Jumlah 1', 'Mesin 2', 'Jumlah 2', 'Mesin 3', 'Jumlah 3']],
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
                if (index < 9) { 
                    row.push($(td).text());
                }
            });
            data.push(row);
        });
        return data;
    }
</script>
<?php $this->endSection() ?>
