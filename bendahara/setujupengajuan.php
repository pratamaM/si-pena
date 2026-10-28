<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
include "../fungsi/koneksi.php";

if (isset($_POST['selected_ids'])) {
    $selected_ids = array_map('intval', (array) $_POST['selected_ids']);
    $ids = implode(",", $selected_ids);

    // First, update the status in the pengajuan table
    $query = "UPDATE pengajuan SET status = 1 WHERE id_pengajuan IN ($ids)";
    
    if (mysqli_query($koneksi, $query)) {
        // Now, update the stok and sisa for each item in stokbarang
        foreach ($selected_ids as $id) {
            // Fetch the jumlah and kode_brg for the selected pengajuan item
            $result = mysqli_query($koneksi, "SELECT jumlah, kode_brg FROM pengajuan WHERE id_pengajuan = '$id'");
            $row = mysqli_fetch_assoc($result);
            $jumlah = $row['jumlah'];
            $kode_brg = $row['kode_brg'];

            // Update stok and sisa in stokbarang table
            $updateStok = "UPDATE stokbarang SET stok = stok + $jumlah, sisa = sisa + $jumlah WHERE kode_brg = '$kode_brg'";
            mysqli_query($koneksi, $updateStok);
        }

        echo "<script>alert('Barang berhasil dimasukkan ke stok.'); window.location.href = 'index.php?p=datapengajuan';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memproses data.'); window.location.href = 'index.php?p=datapengajuan';</script>";
    }
} else {
    echo "<script>alert('Tidak ada barang yang dipilih.'); window.location.href = 'index.php?p=datapengajuan';</script>";
}
?>
