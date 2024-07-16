<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Barang Masuk</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">id Barang</label>
                        <div class="col-sm-10">
                            <input class="form-control" list="barang" name="idBarang" id="idBarang" oninput="barangTerpilih()">
                            <datalist id="barang">
                                <?php
                                    foreach($barang as $dataBarang){
                                        echo ' <option value="'.$dataBarang["id"].'">'.$dataBarang["namaBarang"].'</option>';
                                    }
                                ?>
                            </datalist>
                            <i id="notifikasi" class="badge badge-danger"></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Penambahan Stok</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="penambahanStok" name="penambahanStok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Stok Terkini</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stokTerkini" name="stokTerkini" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="satuan" name="satuan" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                </form>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-info" onclick="tambah()" id="tambah">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Antrian</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class=" text-info">
                        <th>
                            ID
                        </th>
                        <th>
                            Nama Barang
                        </th>
                        <th>
                            Penambahan
                        </th>
                        <th>
                            Stok Terkini
                        </th>
                        <th>
                            Satuan
                        </th>
                        <th>
                            Keterangan
                        </th>
                    </thead>
                    <tbody id="tabelPenambahanStok">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mbd-example-modal-lg" id="modalBayar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bayar</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="idAntrian" name="idHapus">
                <p>Pilih jasa yang telah dilakukan untuk motor <b id="detailBayar">....</b>.</p>
                <h5>Total Biaya : <b id="totalHarga">Rp. 0</b></h5>
                <hr>
                <div id="tempatJasa">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="bayar" onclick="prosesPembayaran()" class="btn btn-info" disabled>Bayar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#tambah").disabled = true;
    muatData()

    function muatData() {
        $("#tambah").html('<i class="fa fa-spinner fa-pulse"></i> Memproses...')
        $.ajax({
            url: '<?= base_url() ?>/barangMasuk/muatData',
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var tabel = ''
                var i = 0
                for (let b = data.length-1; b >= 0; b--) {
                    i++
                    tabel += "<tr><td>" + data[b].idBarang + "</td><td>" + data[b].namaBarang + "</td><td>" + data[b].penambahanStok + "</td><td>"+data[b].stokTerkini+"</td><td>"+data[b].satuan+"</td><td>"+data[b].keterangan+"</td></tr>"
                    if (i>4) {
                        break;
                    }
                }
                if (!tabel) {
                    tabel = '<td class="text-center" colspan="6">Penambahan Barang Masih kosong :)</td>'
                }
                $("#tabelPenambahanStok").html(tabel)

                $("#tambah").html('Daftar')
            }
        });
    }

    function barangTerpilih(){
        var idBarangTerpilih = $("#idBarang").val()
        var barang =  document.getElementById("barang");
        for (let i = 0; i < barang.options.length; i++) {
            if (idBarangTerpilih==barang.options[i].value) {
                $.ajax({
                    url: '<?= base_url() ?>/barangMasuk/barangById',
                    method: 'post',
                    data: "id="+idBarangTerpilih,
                    dataType: 'json',
                    success: function(data) {
                        $("#namaBarang").val(data.namaBarang)
                        $("#stokTerkini").val(data.stok)
                        $("#satuan").val(data.satuan)
                        $("#tambah").disabled = false;
                    }
                });
                $("#notifikasi").html("")
                break
            }else{
                $("#tambah").disabled = true;
                $("#namaBarang").val("")
                $("#stokTerkini").val("")
                $("#satuan").val("")
                $("#notifikasi").html("Barang tidak ditemukan")
            }
            
        }
    }

    function tambah() {
        if ($("#penambahanStok").val() == 0 || $("#penambahanStok").val() == "") {
            $("#penambahanStok").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'idBarang=' + $("#idBarang").val() + '&namaBarang=' + $("#namaBarang").val() + '&penambahanStok=' + $("#penambahanStok").val() + '&stokTerkini=' + $("#stokTerkini").val() + '&satuan=' + $("#satuan").val() + '&keterangan=' + $("#keterangan").val(),
                url: '<?= base_url() ?>/barangMasuk/tambah',
                dataType: 'json',
                success: function(data) {
                    $("#tambah").disabled = true;
                    $("#namaBarang").val("")
                    $("#stokTerkini").val("")
                    $("#satuan").val("")
                    $("#idBarang").val("")
                    $("#penambahanStok").val("")
                    $("#keterangan").val("")

                    muatData();
                }
            });
        }
    }
</script>
<?php $this->endSection() ?>