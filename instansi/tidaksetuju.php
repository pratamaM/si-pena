<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  

include "../fungsi/koneksi.php";

if (isset($_GET['id']) && isset($_GET['tgl']) && isset($_GET['unit'])) {
	$id = $_GET['id'];
	$tgl = $_GET['tgl'];
	$unit = $_GET['unit'];

	$query = mysqli_query($koneksi, "UPDATE permintaan SET katim=2 WHERE id_permintaan='$id' ");

	if($query) {
	  header("Location: index.php?p=datapermintaan&tgl=$tanggal&unit={$row['unit']}");
	} else {
		echo "error : " . mysqli_error($koneksi);
	}
}


?>