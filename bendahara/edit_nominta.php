<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['update'])){
	$unit = $_POST['unit'];
	$tgl_pemesanan = $_POST['tgl_permintaan'];
	$id = $_POST['id'];
	$jumlah = $_POST['jumlah'];
	$no_surat= $_POST['no_surat'];
	
	$query = mysqli_query($koneksi, "UPDATE permintaan SET jumlah ='$jumlah', no_surat='$no_surat' WHERE id_permintaan='$id' ");

	if($query) {
		header("location:index.php?p=datapengeluaran");
	} else {
		echo 'gagal';
	}
	
}

?>