<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
 
<?php 
  
    $page = isset($_GET['p']) ? $_GET['p'] : "";

    if ($page == 'formpesan') {
        include_once "formpesan.php";
    } else if ($page=="") {
        include_once "main.php";
    } else if ($page=="datapesanan") {
        include_once "datapesanan.php";
    } else if ($page=="hapus") {
        include_once "hapuspesan.php";
    } else if($page == "cetakpesanan"){
        include_once "cetakpesan.php";
    } else if($page == "detil"){
        include_once "detilpesan.php";
    } else if($page == "material"){
        include_once "material.php";
    } else if ($page=="detilpermintaan") {
    include_once "detilpermintaan.php";
    }else if($page == "verifpesanan"){
        include_once "verifpesanan.php";
    } else if ($page=="editpesanminta") {
    include_once "editpesanminta.php";
} else if ($page=="veriftera") {
    include_once "veriftera.php";
} else if ($page=="verifmikro") {
    include_once "verifmikro.php";
    }else if ($page=="veriftu") {
    include_once "veriftu.php";
} else if ($page=="verifinfokom") {
    include_once "verifinfokom.php";
}  else if ($page=="verifpenindakan") {
    include_once "verifpenindakan.php";
}  else if ($page=="verifpemeriksaan") {
    include_once "verifpemeriksaan.php";
} 
 ?>
 
