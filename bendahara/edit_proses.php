<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['update'])) {
	
	$kode_brg = $_POST['kode_brg'];
	$nama_brg = $_POST['nama_brg'];
	$id_jenis = $_POST['id_jenis'];
	$satuan = $_POST['satuan'];
	$stok = $_POST['jumlah'];

	

	$query = mysqli_query($koneksi, "UPDATE stokbarang SET nama_brg='$nama_brg', id_jenis='$id_jenis', satuan='$satuan', stok='$stok' WHERE kode_brg ='$kode_brg' ");
	if ($query) {
		echo '<script language="javascript">alert("Data Berhasil Di Ubah !!!"); document.location="index.php?p=tambahmaterial";</script>';
	} else {
		echo 'error' . mysqli_error($koneksi);
	}

}



?>