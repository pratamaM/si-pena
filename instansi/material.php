<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

// Mengambil ID jenis jika ada
$id_jenis = isset($_GET['id_jenis']) ? $_GET['id_jenis'] : '';

// Mengambil data jenis barang jika ID jenis ada
if ($id_jenis) {
    $result = mysqli_query($koneksi, "SELECT jenis_brg FROM jenis_barang WHERE id_jenis='$id_jenis'");
    $data = mysqli_fetch_assoc($result);
    $jenis_brg = $data['jenis_brg'];
} else {
    $jenis_brg = 'Semua Jenis'; // Default value jika tidak ada ID jenis
}

// Menangani aksi edit dan hapus
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_GET['aksi'] == 'edit') {
        header("location:?p=edit-m2&id=$id");
    } else if ($_GET['aksi'] == 'hapus') {
        header("location:?p=hapusmaterial-m3&id=$id");
    }
}

// Query untuk mendapatkan data stok barang
if ($id_jenis) {
    $query = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis='$id_jenis'");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM stokbarang");
}
?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Olah Data Stok <?= htmlspecialchars($jenis_brg); ?></h3>
                </div>                
                <div class="box-body">
                    <!-- <div class="row">
                        <div class="col-md-2">
                            <a href="index.php?p=tambahmaterial-m3&id_jenis=<?= htmlspecialchars($id_jenis); ?>" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tambah Data Stok
                            </a><br>						
                        </div>

                        <div class="col-md-2 pull-right">
                            <a target="_blank" href="cetakstok.php?idjenis=<?= htmlspecialchars($id_jenis); ?>" class="btn btn-success">
                                <i class="fa fa-print"></i> Cetak Data Stok
                            </a><br>
                        </div>
                        <br><br>
                    </div>                         -->
                    <div class="table-responsive">
                        <table class="table text-center" id="material">
                            <thead> 
                                <tr>
                                    <th>No</th>	  
                                    <!-- <th>Kode Barang</th>        				 -->
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Stok</th> 
                                    <th>Keterangan</th>
                                    <?php if ($id_jenis == '1'): ?>
                                    <th>Kadaluarsa</th>
                                    <?php endif; ?>            				
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
$no = 1;
$current_date = new DateTime(); // Get the current date
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) { 
        $exp_date = new DateTime($row['exp']); // Convert the expiration date from the database to a DateTime object
        
        if ($id_jenis == '1') {
            $interval = $current_date->diff($exp_date); // Get the difference between the current date and the expiration date
            $days_to_expiry = $interval->days; // Get the number of days until expiration

            // Determine the keterangan value based on the difference
            if ($current_date > $exp_date) {
                $keterangan = "Kadaluarsa";
                $keterangan_class = "bg-red"; // Red background class
            } elseif ($days_to_expiry <= 60) { // 2 months = 60 days
                $keterangan = "Hampir Kadaluarsa";
                $keterangan_class = "bg-yellow"; // Yellow background class
            } else {
                $keterangan = "-";
                $keterangan_class = ""; // No special class
            }
        } else {
            $keterangan = "-";
            $keterangan_class = ""; // No special class for other id_jenis values
        }
?>
<tr>
    <td> <?= $no; ?> </td>      
    <!-- <td> <?= htmlspecialchars($row['kode_brg']); ?> </td>          					 -->
    <td style="text-align: left;"> <?= htmlspecialchars($row['nama_brg']); ?> </td>
    <td> <?= htmlspecialchars($row['satuan']); ?> </td>
                                         
    <td> <?= htmlspecialchars($row['sisa']); ?> </td>
    <td class="<?= $keterangan_class; ?>"> <?= htmlspecialchars($keterangan); ?> </td>
    <?php if ($id_jenis == '1'): ?>
    <td> <?= htmlspecialchars($row['exp']); ?> </td>
    <?php endif; ?>					
</tr>
<?php 
        $no++; 
    } 
} 
?>
                            </tbody>
                        </table>
                    </div>                	
                </div>
            </div>
        </div>
    </div>
</section>
<script>
  $(function(){
    $("#material").DataTable({
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
        }
    });
  });
</script> 
