<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
session_start(); // Mulai session

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect ke halaman login dengan pesan
    header("Location: https://bpombengkulu.com/si-pena/index.php?pesan=expired");
    exit;
}


include "../fungsi/koneksi.php";
$error = "";
?>

<section class="content">
    <div class="row">
        <!-- Form for Adding Barang -->
        <div class="col-sm-12 col-xs-18">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Form Penambahan Barang</h3>
                </div>
                <form method="post" id="tes" action="simpan_pengajuansementara.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama_brg" class="a col-sm-3 control-label">Usernames</label>
                            <div class="col-sm-3">
                                <input type="text" readonly value="<?= $_SESSION['username']; ?>" class="form-control" name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_brg" class="col-sm-3 control-label">Jenis Barang</label>
                            <div class="col-sm-5">
                                <select id="jenis_brg" required="isikan dulu" class="form-control" name="id_jenis">
                                    <option value="">--Pilih Jenis Barang--</option>
                                    <?php  
                                    $queryJenis = mysqli_query($koneksi, "SELECT * FROM jenis_barang");
                                    if (mysqli_num_rows($queryJenis)) {
                                        while($row = mysqli_fetch_assoc($queryJenis)) {
                                            echo "<option value='{$row['id_jenis']}'>{$row['jenis_brg']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
    <label for="nama_brg" class="col-sm-3 control-label">Nama Barang</label>
    <div class="col-sm-5">
        <select id="nama_brg" required class="form-control" name="kode_brg">
            <option value="">--Pilih Nama Barang--</option>
        </select>
    </div>
</div>

                        <div class="form-group">
                            <label for="stok" class="col-sm-3 control-label">Stok Tersedia</label>
                            <div class="col-sm-2">
                                <input id="stok" disabled value="----" type="text" class="form-control" name="stok">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="satuan" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <input id="satuan" class="form-control" name="satuan" placeholder="Pilih Barang Terlebih Dahulu" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-2">
                                <input id="jumlah" type="number" onkeyup="hitung();" class="form-control" name="jumlah" required>
                            </div>
                            <span class="col-sm-5"> <?php echo $error; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="simpanpengajuan" name="simpanpengajuan" class="btn btn-primary col-sm-offset-3" value="Simpan">
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table for Showing Barang Data -->
        <div class="col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Penambahan Barang</h3>
                </div>

                <!-- Data Table -->
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sekarang  = date("Y-m-d");
                        $queryTampil = mysqli_query($koneksi, "SELECT pengajuan_sementara.jumlah, pengajuan_sementara.satuan, pengajuan_sementara.unit, pengajuan_sementara.id_pengajuan_sementara, stokbarang.nama_brg FROM pengajuan_sementara INNER JOIN stokbarang ON pengajuan_sementara.kode_brg = stokbarang.kode_brg WHERE tgl_pengajuan = '$sekarang' AND pengajuan_sementara.unit='$_SESSION[username]'");
                        $no = 1;
                        if(mysqli_num_rows($queryTampil) != 0) {
                            while($row = mysqli_fetch_assoc($queryTampil)) {
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['nama_brg']; ?></td>
                            <td><?php echo $row['satuan']; ?></td>
                            <td><?php echo $row['jumlah']; ?></td>
                            <td><a href="hapus_pengajuansementara.php?id=<?php echo $row['id_pengajuan_sementara']; ?>" class="btn btn-danger">Hapus</a></td>
                        </tr>
                        <?php 
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada pengajuan barang</td></tr>";
                        }
                        ?>
                        <tr>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT SUM(jumlah) as total_jumlah FROM pengajuan_sementara");
                            if(mysqli_num_rows($query) > 0) {
                                while($row1 = mysqli_fetch_assoc($query)) {
                            ?>
                            <th></th>
                            <th></th>
                            <th>Jumlah Barang :</th>
                            <th><?= $row1['total_jumlah']; ?></th>
                            <?php 
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>

                <div class="box-body">
                    <a class="btn btn-success" href="pesanpengajuan.php">Buat Penambahan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
      $(document).ready(function() {
    // Initialize Select2
    $('#nama_brg').select2({
        placeholder: '--Pilih Nama Barang--',
        allowClear: true
    });

    // Existing code for updating data
    $("#jenis_brg").change(function() {
        var jenis = $(this).val();
        var dataString = 'jenis=' + jenis;
        $.ajax({
            type: "POST",
            url: "getdatapengajuan.php",
            data: dataString,
            success: function(html) {
                $("#nama_brg").html(html).trigger('change'); // Refresh Select2 with new options
            }
        });
    });

    $("#nama_brg").change(function() {
        var kode = $(this).val();
        var dataString = 'kode=' + kode;
        $.ajax({
            type: "POST",
            url: "getkodepengajuan.php",
            data: dataString,
            success: function(html) {
                $("#stok").val(html);
            }
        });

        $.ajax({
            type: "POST",
            url: "getsatuanpengajuan.php",
            data: dataString,
            success: function(html) {
                $("#satuan").val(html);
            }
        });

        $.ajax({
            type: "POST",
            url: "gethargabarang.php",
            data: dataString,
            success: function(html) {
                $("#hargabarang").val(html);
            }
        });
    });

    // Calculate total price based on quantity and price
    $("#jumlah").keyup(function() {
        hitung();
    });

    function hitung() {
        var jumlah = Number(document.getElementById('jumlah').value);
        var getharga = document.getElementById('hargabarang').value;
        var hargab = getharga.split(".").join("").split("Rp").join("");

        var total = jumlah * hargab;
        document.getElementById('total').value = total;
    }
});

</script>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    #search-bar {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    #nama_brg {
        width: 100%;
    }
</style>
