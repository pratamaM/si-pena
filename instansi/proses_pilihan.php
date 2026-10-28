<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php
include "../fungsi/koneksi.php";

// Get the delivery_option array from the form submission
if (isset($_POST['delivery_option'])) {
    foreach ($_POST['delivery_option'] as $tgl_permintaan => $delivery_option) {
        // Update the database for each request's delivery option
        $query = mysqli_query($koneksi, "UPDATE permintaan SET delivery_option = '$delivery_option' WHERE tgl_permintaan = '$tgl_permintaan' AND unit = '$_SESSION[username]'");
    }

    if ($query) {
        echo "Pilihan pengiriman berhasil disimpan!";
        header("location:index.php?p=datapesanan");
    } else {
        echo "Terjadi kesalahan saat menyimpan pilihan.";
    }
}
