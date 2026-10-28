<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
include "../fungsi/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($stmt = $koneksi->prepare("DELETE FROM stokbarang WHERE kode_brg = ?")) {
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            echo '<script language="javascript">
                    alert("Data Berhasil Di Hapus !!!");
                    window.location.href = document.referrer;
                  </script>';
        } else {
            echo 'Gagal menghapus data: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Gagal mempersiapkan statement: ' . $koneksi->error;
    }
}
?>
