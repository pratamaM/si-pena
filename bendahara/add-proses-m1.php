<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['simpan'])) {

	$kode_brg = $_POST['kode_brg'];
	$id_jenis = $_POST['id_jenis'];
	$nama_brg = $_POST['nama_brg'];
	$satuan = $_POST['satuan'];	

	$query = "INSERT INTO stokbarang (kode_brg, id_jenis, nama_brg, satuan) VALUES 
	('$kode_brg', '$id_jenis', '$nama_brg', '$satuan')";

	$hasil = mysqli_query($koneksi, $query);
	if ($hasil) {
		echo '<script language="javascript">
				alert("Data Berhasil Disimpan !!!");
				window.location.href = document.referrer;
			  </script>';
	} else {
		die("ada kesalahan : " . mysqli_error($koneksi));
	}

}
?>
