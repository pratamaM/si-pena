<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  

include "../fungsi/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tanggal = date('Y-m-d');
    
    // Update status permintaan
    $query1 = mysqli_query($koneksi, "UPDATE permintaan SET katim=1 WHERE id_permintaan='$id'");
    
   if ($query1) {
//   $unit = urlencode($_GET['unit']);
//         $tgl = urlencode($_GET['tgl']);
//         $no_surat = urlencode($_GET['no_surat']);
//         header("Location: index.php?p=detilpermintaan&unit=$unit&tgl=$tgl&no_surat=$no_surat");
 echo '<script>window.history.back();</script>';
        exit();
    } else {
        echo "Failed to update status.";
    }
}

?>
