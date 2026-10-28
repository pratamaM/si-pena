<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
include "../fungsi/koneksi.php";

if(isset($_GET['id'])){
	$id=$_GET['id'];

	$query = mysqli_query($koneksi,"delete from stokbarang where kode_brg='$id'");
	if ($query) {
		echo '<script language="javascript">alert("Data Berhasil Di Hapus !!!"); document.location="index.php?p=material-m2&id_jenis=2";</script>';
	} else {
		echo 'gagal';
	}
	
}
?>