<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['simpanpengajuan'])) {

	$unit = $_POST['unit'];
	$kode_brg = $_POST['kode_brg'];
	$id_jenis = $_POST['id_jenis'];
	$jumlah = $_POST['jumlah'];	
	$satuan = $_POST['satuan'];		

	$total = preg_replace('/[Rp.]/', '', $_POST['total']);
	$tgl_pengajuan = date('Y-m-d');

//script validasi data

	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM pengajuan_sementara WHERE kode_brg='$kode_brg'"));
	if ($cek > 0){
		echo "<script>window.alert('Nama Barang Sudah Ada')
		window.location='index.php?p=formpengajuan'</script>";
	}else {
		$query = "INSERT into pengajuan_sementara (unit, kode_brg, id_jenis,  jumlah, satuan, total ,  tgl_pengajuan) VALUES 
		('$unit', '$kode_brg', '$id_jenis', '$jumlah', '$satuan','$total', '$tgl_pengajuan')

		";
		$hasil = mysqli_query($koneksi, $query);
		if ($hasil) {
			header("location:index.php?p=formpengajuan");
		} else {
			die("ada kesalahan : " . mysqli_error($koneksi));
		}
	}
} 
?>