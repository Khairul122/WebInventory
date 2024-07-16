<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Barang</h4>
            </div>
            <div class="card-body">
                <form id="formTambah">
                    <div class="form-group row">
                        <label for="namaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="stok" name="stok">
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
                <h4 class="card-title">Daftar Barang</h4>
                <!-- <button class="btn btn-success" onclick="previewPdf()">Preview PDF</button> -->
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
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
    muatData();

    function muatData() {
        $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...')
        $.ajax({
            url: '<?= base_url() ?>/barang/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = '';
                for (let i = 0; i < data.length; i++) {
                    tabel += "<tr><td>" + (i + 1) + "</td><td>" + data[i].namaBarang + "</td><td>" + data[i].stok + "</td><td><a href='#' id='hapus" + data[i].id + "' onclick='tryHapus(" + data[i].id + ", \"" +data[i].namaBarang + "\")' ><i class='fa fa-trash'></i></a></td></tr>";
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="4">Data Masih kosong :)</td>';
                }
                $("#tabelBarang tbody").html(tabel);
                $("#tambah").html('Tambah');
            }
        });
    }

    function tambah() {
        if ($("#namaBarang").val() == "") {
            $("#namaBarang").focus();
        } else if ($("#stok").val() == "") {
            $("#stok").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'namaBarang=' + $("#namaBarang").val() + '&stok=' + $("#stok").val(),
                url: '<?= base_url() ?>/barang/tambah',
                dataType: 'json',
                success: function(data) {
                    $("#namaBarang").val("");
                    $("#stok").val("");
                    muatData();
                }
            });
        }
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
            head: [['No', 'Nama Barang', 'Stok']],
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
            head: [['No', 'Nama Barang', 'Stok']],
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
                if (index < 3) { 
                    row.push($(td).text());
                }
            });
            data.push(row);
        });
        return data;
    }
</script>
<?php $this->endSection() ?>
