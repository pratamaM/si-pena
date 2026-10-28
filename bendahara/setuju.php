<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tanggal = date('Y-m-d');
    
    // Update status permintaan
    $query1 = mysqli_query($koneksi, "UPDATE permintaan SET status=1 WHERE id_permintaan='$id'");
    
    // Ambil data permintaan
    $query2 = mysqli_query($koneksi, "SELECT * FROM permintaan WHERE id_permintaan='$id'");
    $row = mysqli_fetch_assoc($query2);
    
    // Insert ke tabel pengeluaran
    $query3 = mysqli_query($koneksi, "INSERT INTO pengeluaran (unit, kode_brg, jumlah, tgl_keluar)
        VALUES ('$row[unit]', '$row[kode_brg]', '$row[jumlah]', '$tanggal')");
    
    if ($query3) {
        // Update stok barang secara manual
        $query4 = mysqli_query($koneksi, "UPDATE stokbarang SET keluar = keluar + '{$row['jumlah']}', sisa = stok - keluar 
            WHERE kode_brg = '{$row['kode_brg']}'");

        if ($query4) {
            header("Location: index.php?p=datapermintaan&tgl=$tanggal&unit={$row['unit']}");
        } else {
            echo "Gagal memperbarui stok barang: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal menambahkan pengeluaran: " . mysqli_error($koneksi);
    }
}

?>
