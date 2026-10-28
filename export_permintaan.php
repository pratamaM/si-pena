<?php
include "fungsi/koneksi.php";
require_level(array('bendahara'), 'index.php');

// Header agar langsung download sebagai Excel (CSV)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_permintaan.xls");

// Query hanya kolom yang diminta
$query = mysqli_query($koneksi, "
    SELECT 
        unit,
        kode_brg,
        keperluan,
        tgl_permintaan,
        rating,
        saran
    FROM permintaan
    ORDER BY tgl_permintaan DESC
");

// Judul kolom
echo "UNIT\tKODE BARANG\tKEPERLUAN\tTANGGAL PERMINTAAN\tRATING\tSARAN\n";

// Isi data
while ($row = mysqli_fetch_assoc($query)) {
    echo
        $row['unit'] . "\t" .
        $row['kode_brg'] . "\t" .
        str_replace(array("\r", "\n"), ' ', $row['keperluan']) . "\t" .
        $row['tgl_permintaan'] . "\t" .
        $row['rating'] . "\t" .
        str_replace(array("\r", "\n"), ' ', $row['saran']) . "\n";
}
?>
