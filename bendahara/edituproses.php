<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['update'])) {
	$id = $_POST['id'];
	
	$username = $_POST['username'];
	$jabatan = $_POST['jabatan'];
	
	
	$level = $_POST['level'];	
	
	$query = mysqli_query($koneksi, "UPDATE user SET username='$username', jabatan='$jabatan', level='$level' WHERE id_user ='$id' ");
	
	if ($query) {
		echo '<script language="javascript">alert("Data Berhasil Di Ubah !!!"); document.location="index.php?p=user";</script>';
	} else {
		echo 'error' . mysqli_error($koneksi);
	}

}



?>