<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Mesin</h4>
            </div>
            <div class="card-body">
                <form id="formTambah">
                    <div class="form-group row">
                        <label for="namaMesin" class="col-sm-2 col-form-label">Nama Mesin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaMesin" name="namaMesin">
                        </div>
                    </div>
                </form>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-info" onclick="tambah()" id="tambah">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Mesin</h4>
                <button class="btn btn-primary" onclick="exportPdf()">Export PDF</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tabelMesin">
                        <thead class="text-info">
                            <tr>
                                <th>No</th>
                                <th>Nama Mesin</th>
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

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mesin</h5>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <input type="hidden" id="idEdit" name="id_mesin">
                    <div class="form-group row">
                        <label for="editNamaMesin" class="col-sm-2 col-form-label">Nama Mesin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="editNamaMesin" name="nama_mesin">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="simpanEdit()" class="btn btn-info">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Mesin</h5>
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
    muatData();

    function muatData() {
        $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...')
        $.ajax({
            url: '<?= base_url() ?>/mesin/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = '';
                for (let i = 0; i < data.length; i++) {
                    tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].nama_mesin + "</td><td><a href='#' id='edit" + data[i].id_mesin + "' onclick='tryEdit(" + data[i].id_mesin + ", \"" + data[i].nama_mesin + "\")' ><i class='fa fa-edit'></i></a> <a href='#' id='hapus" + data[i].id_mesin + "' onclick='tryHapus(" + data[i].id_mesin + ", \"" + data[i].nama_mesin + "\")' ><i class='fa fa-trash'></i></a></td></tr>";
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="3">Data Masih kosong :)</td>';
                }
                $("#tabelMesin tbody").html(tabel);
                $("#tambah").html('Tambah');
            }
        });
    }

    function tambah() {
        if ($("#namaMesin").val() == "") {
            $("#namaMesin").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'namaMesin=' + $("#namaMesin").val(),
                url: '<?= base_url() ?>/mesin/tambah',
                dataType: 'json',
                success: function(data) {
                    alert('Data berhasil ditambahkan');
                    $("#namaMesin").val("");
                    muatData();
                }
            });
        }
    }

    function tryEdit(id, nama) {
        $("#edit" + id).html('<i class="fa fa-spinner fa-pulse"></i>')
        $("#idEdit").val(id)
        $("#editNamaMesin").val(nama)
        $("#edit" + id).html('<i class="fa fa-edit"></i>')
        $("#modalEdit").modal('show')
    }

    function simpanEdit() {
        $.ajax({
            type: 'POST',
            data: 'id_mesin=' + $("#idEdit").val() + '&nama_mesin=' + $("#editNamaMesin").val(),
            url: '<?= base_url() ?>/mesin/edit',
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
            url: '<?= base_url() ?>/mesin/hapus',
            method: 'post',
            data: "id_mesin=" + id,
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
        doc.text("Laporan Data Mesin", 14, 10);
        doc.line(14, 12, 196, 12); 
        doc.autoTable({
            head: [['No', 'Nama Mesin']],
            body: extractTableData(),
            startY: 15,
            theme: 'grid'
        });
        doc.output('dataurlnewwindow');
    }

    function exportPdf() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Data Mesin", 14, 10);
        doc.line(14, 12, 196, 12); 
        doc.autoTable({
            head: [['No', 'Nama Mesin']],
            body: extractTableData(),
            startY: 15,
            theme: 'grid'
        });
        doc.save("Laporan_Mesin.pdf");
    }

    function extractTableData() {
        var data = [];
        $("#tabelMesin tbody tr").each(function(index, tr) {
            var row = [];
            $(tr).find('td').each(function(index, td) {
                if (index < 2) { 
                    row.push($(td).text());
                }
            });
            data.push(row);
        });
        return data;
    }
</script>
<?php $this->endSection() ?>
