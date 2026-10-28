<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  
include "../fungsi/koneksi.php";

// Mendapatkan ID jenis dari URL
$id_jenis = isset($_GET['id_jenis']) ? (int)$_GET['id_jenis'] : 1;

// Ambil kode_brg PALING BARU dari SEMUA DATA
$query = mysqli_query($koneksi, "
    SELECT kode_brg
    FROM stokbarang
    ORDER BY
        CAST(SUBSTRING_INDEX(kode_brg, '.', 1) AS UNSIGNED) DESC,
        CAST(SUBSTRING_INDEX(kode_brg, '.', -1) AS UNSIGNED) DESC
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);

if ($data && isset($data['kode_brg'])) {
    $explode = explode(".", $data['kode_brg']);
    $angkaDepan    = (int)$explode[0]; // contoh: 112
    $angkaBelakang = isset($explode[1]) ? (int)$explode[1] : 0;

    $angkaBelakang++; // +1

    $kode_otomatis = $angkaDepan . "." . str_pad($angkaBelakang, 3, "0", STR_PAD_LEFT);
} else {
    // Jika tabel masih kosong
    $kode_otomatis = "1.001";
}

// Ambil jenis barang
$queryJenis = mysqli_query($koneksi, "SELECT * FROM jenis_barang WHERE id_jenis='$id_jenis'");
$rowJenis = mysqli_fetch_assoc($queryJenis);

?>

<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Tambah Data Stok Barang</h3>
                </div>
                <form method="post" action="add-proses-m1.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Kode Barang</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?= htmlspecialchars($kode_otomatis); ?>" class="form-control" name="kode_brg" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_brg" class="col-sm-offset-1 col-sm-3 control-label">Jenis Barang</label>
                            <div class="col-sm-4">
                                <input type="text" id="jenis_brg" class="form-control" name="id_jenis" 
                                       value="<?= isset($rowJenis['jenis_brg']) ? htmlspecialchars($rowJenis['jenis_brg']) : '' ?>" 
                                       readonly>
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <label for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Nama Barang</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_brg">
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-offset-1 col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="satuan">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4" value="Simpan">
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">             
                            <a href="index.php?p=material-m1&id_jenis=1" style="margin:10px;" class="btn btn-success">
                                <i class='fa fa-backward'></i> Kembali
                            </a>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('.tanggal').datepicker({
            format:"yyyy-mm-dd",
            autoclose:true
        });
    });

    // var rupiah = document.getElementById("hargabarang");
    // rupiah.addEventListener("keyup", function(e) {
    //     rupiah.value = currencyIdr(this.value, "Rp. ");
    // });

    function currencyIdr(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split  = number_string.split(","),
        sisa   = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : "");
    }
</script>
