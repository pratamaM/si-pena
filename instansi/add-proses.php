<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php
//proses
include "../fungsi/koneksi.php";
if (!isset($_POST['unit']) || empty(trim($_POST['unit']))) {
    // Jika unit kosong atau tidak ada, redirect ke login
    header("Location: https://bpombengkulu.com/si-pena/");
    exit;
}
if(isset($_POST['simpan'])) {

	$unit = $_POST['unit'];
	$instansi = $_POST['instansi'];
	$kode_brg = $_POST['kode_brg'];
	$jumlah = $_POST['jumlah'];		
	$tgl_pemesanan = date('Y-m-d');
	$id_jenis = $_POST['id_jenis'];
	$keperluan = $_POST['keperluan'];

//script validasi data

	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM sementara WHERE kode_brg='$kode_brg'"));
	if ($cek > 0){
		echo "<script>window.alert('Nama Barang Sudah Ada')
		window.location='index.php?p=formpesan'</script>";
	}else {
		$query = "INSERT into sementara (unit, instansi, kode_brg, id_jenis,  jumlah, tgl_permintaan,keperluan ) VALUES 
		('$unit','$instansi', '$kode_brg', '$id_jenis', '$jumlah', '$tgl_pemesanan','$keperluan')

		";
		$hasil = mysqli_query($koneksi, $query);
		if ($hasil) {
			header("location:index.php?p=formpesan");
		} else {
			die("ada kesalahan : " . mysqli_error($koneksi));
		}
	}
} 
?>