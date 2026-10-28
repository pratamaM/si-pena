<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
 
<?php 

$page = isset($_GET['p']) ? $_GET['p'] : "";

if ($page == 'formpesan') {
    include_once "formpesan.php";
} else if ($page=="") {
    include_once "main.php";
}  else if ($page=="material") {
    include_once "material.php";
}  else if ($page=="material-m1") {
    include_once "material-m1.php";
}  else if ($page=="material-m2") {
    include_once "material-m2.php";
}  else if ($page=="material-m3") {
    include_once "material-m3.php";
} else if ($page=="tambahmaterial") {
    include_once "tambahmaterial.php";
} else if ($page=="tambahmaterial-m1") {
    include_once "tambahmaterial-m1.php";
} else if ($page=="tambahmaterial-m2") {
    include_once "tambahmaterial-m2.php";
 } else if ($page=="tambahmaterial-m3") {
    include_once "tambahmaterial-m3.php";
} else if ($page=="user") {
    include_once "user.php";
}  else if ($page=="edit") {
    include_once "editmaterial.php";
}  else if ($page=="edit-m1") {
    include_once "edit-m1.php";
}  else if ($page=="edit-m2") {
    include_once "edit-m2.php";
}  else if ($page=="edit-m3") {
    include_once "edit-m3.php";
} else if ($page=="hapusmaterial-m1") {
    include_once "hapusmaterial-m1.php";
} else if ($page=="hapusmaterial-m2") {
    include_once "hapusmaterial-m2.php";
} else if ($page=="hapusmaterial-m3") {
    include_once "hapusmaterial-m3.php";
} else if ($page=="hapususer") {
    include_once "hapususer.php";
} else if ($page=="edituser") {
    include_once "edituser.php";
} else if ($page=="tambahuser") {
    include_once "tambahuser.php";
} else if ($page=="cetakstok") {
    include_once "halcetak.php";
} else if ($page=="editpesanminta") {
    include_once "editpesanminta.php";
} 
else if ($page=="editnominta") {
    include_once "editnominta.php";
} else if ($page=="tidaksetuju") {
    include_once "tidaksetuju.php";
} else if ($page=="cetakpesanan") {
    include_once "cetakpesanan.php";
}  else if ($page=="formpengajuan") {
  include_once "formpengajuan.php";
} else if ($page=="tidaksetujupengajuan") {
    include_once "tidaksetujupengajuan.php";
} else if ($page=="lap_keluar") {
    include_once "lap_keluar.php";
} else if ($page=="lap_masuk") {
    include_once "lap_masuk.php";
} else if ($page=="datapermintaan") {
    include_once "datapermintaan.php";
}  else if ($page=="detilpermintaan") {
    include_once "detilpermintaan.php";
}  else if ($page=="datapengeluaran") {
    include_once "datapengeluaran.php";
}  else if ($page=="laporanpengeluaran") {
    include_once "laporanpengeluaran.php";
} else if ($page=="detil_datapengeluaran") {
    include_once "detil_datapengeluaran.php";
}  else if ($page=="laporanpengeluaran2") {
    include_once "laporanpengeluaran2.php";
}  else if ($page=="laporanpengeluaran3") {
    include_once "laporanpengeluaran3.php";
}   else if ($page=="laporanpemasukan") {
    include_once "laporanpemasukan.php";
}  else if($page == "detillaporanpemasukan"){
    include_once "detillaporanpemasukan.php";
}  else if ($page=="laporanpemasukan2") {
    include_once "laporanpemasukan2.php";
}   else if ($page=="datapemasukan") {
    include_once "datapemasukan.php";
} else if ($page=="detilpengajuan") {
    include_once "detilpengajuan.php";
}  else if ($page=="datapengajuan") {
    include_once "datapengajuan.php";
}else if ($page=="rekapitulasipermintaan") {
    include_once "rekapitulasipermintaan.php";
}else if ($page=="rekapitulasipengajuan") {
    include_once "rekapitulasipengajuan.php";
}else if ($page=="detil_lap_permintaan") {
    include_once "detil_lap_permintaan.php";
}else if ($page=="detil_lap_pengajuan") {
    include_once "detil_lap_pengajuan.php";
}
?>

