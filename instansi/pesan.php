<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  

include "../fungsi/koneksi.php";
$tgl = date('Y-m-d');
$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);

$query = "INSERT INTO permintaan SELECT * FROM sementara WHERE unit='$username'";

              
$query2 = "DELETE FROM sementara WHERE unit='$username'";

if (mysqli_query($koneksi, $query)) {
    // Jika query pertama berhasil, eksekusi query kedua
    if (mysqli_query($koneksi, $query2)) {
        // Jika query kedua berhasil, panggil API
        include '../fungsi/api.php'; // Memanggil API setelah kedua query berhasil
        echo '<script language="javascript">alert("Form Permintaan Barang Berhasil Dikirim !!!"); document.location="index.php?p=datapesanan";</script>';
    } else {
        echo "Gagal menghapus data sementara: " . mysqli_error($koneksi);
    }
} else {
    echo "Gagal memasukkan data ke permintaan: " . mysqli_error($koneksi);
}

?>
