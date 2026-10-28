<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
ob_start();
include "../fungsi/koneksi.php";
$page = isset($_GET['p']) ? $_GET['p'] : false;

$notif = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Lab.Pangan' AND katim=0 AND status=0");    
$permintaan_count = mysqli_num_rows($notif);

$mikro = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Lab.Mikrobiologi' AND katim=0 AND status=0");    
$permintaan_mikro = mysqli_num_rows($mikro);

$tera = mysqli_query($koneksi, "SELECT DISTINCT(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Lab.Teranokoko' AND katim=0 AND status=0");  
$permintaan_tera= mysqli_num_rows($tera);

$tu = mysqli_query($koneksi, "SELECT DISTINCT(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Tata Usaha' AND katim=0 AND status=0");  
$permintaan_tu= mysqli_num_rows($tu);

$infokom = mysqli_query($koneksi, "SELECT DISTINCT(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Infokom' AND katim=0 AND status=0");  
$permintaan_infokom= mysqli_num_rows($infokom);

$penindakan = mysqli_query($koneksi, "SELECT DISTINCT(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Penindakan' AND katim=0 AND status=0");  
$permintaan_penindakan= mysqli_num_rows($penindakan);

$pemeriksaan = mysqli_query($koneksi, "SELECT DISTINCT(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE instansi='Pemeriksaan' AND katim=0 AND status=0");  
$permintaan_pemeriksaan= mysqli_num_rows($pemeriksaan);

















$nilai = 'nilai'; // Replace 'specific_value' with the actual value you want to check

$query = mysqli_query($koneksi, "SELECT COUNT(id_jenis) AS jumlah FROM jenis_barang");
$data = mysqli_fetch_assoc($query);

// Check for rows with status 1 and rating equal to 'nilai'
$checkRating = mysqli_query($koneksi, "SELECT * FROM permintaan WHERE unit = '$_SESSION[username]' AND status = 1 AND rating = '$nilai' GROUP BY tgl_permintaan");

$showPopup = false;
if (mysqli_num_rows($checkRating) > 0) {
    $showPopup = true;
}

// Check if the rating has been provided
$ratingProvided = isset($_POST['rating']) && in_array($_POST['rating'], ['baik sekali', 'baik', 'cukup', 'buruk', 'buruk sekali']);
$requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;

if ($showPopup && !$ratingProvided) {
    $_SESSION['rating_required'] = true;
}

// Handle form submission
// Handle form submission for rating and suggestion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $rating = $_POST['rating'];
    $saran = isset($_POST['saran']) ? $_POST['saran'] : '';

    if ($requestId > 0 && $rating) {
        // Update the database with the selected rating and suggestion

        $updateQuery = "UPDATE permintaan SET rating = '$rating', saran = '$saran' WHERE id_permintaan = $requestId";
        if (mysqli_query($koneksi, $updateQuery)) {
            $_SESSION['rating_required'] = false;
            header('Location: ' . $_SERVER['PHP_SELF']); // Reload the page to remove the popup
            exit();
        } else {
            echo 'Error updating rating: ' . mysqli_error($koneksi);
        }
    }
}

$ratingProvided = isset($_POST['rating']) && in_array($_POST['rating'], ['baik sekali', 'baik', 'cukup', 'buruk', 'buruk sekali']);

if ($ratingProvided) {
    $rating = $_POST['rating'];

    // Update the database for the specified unit and group by tgl_permintaan
  $updateQuery = "
    UPDATE permintaan 
    JOIN (
        SELECT tgl_permintaan 
        FROM permintaan 
        WHERE unit = '$_SESSION[username]' 
        AND status = 1 
        GROUP BY tgl_permintaan
    ) AS temp ON permintaan.tgl_permintaan = temp.tgl_permintaan
    SET permintaan.rating = '$rating', permintaan.saran = '$saran'
    WHERE permintaan.unit = '$_SESSION[username]' 
    AND permintaan.status = 1 
    AND permintaan.rating = 'nilai'
";

    
    if (mysqli_query($koneksi, $updateQuery)) {
        $_SESSION['rating_required'] = false;
        header('Location: ' . $_SERVER['PHP_SELF']); // Reload the page to remove the popup
        exit();
    } else {
        echo 'Error updating rating: ' . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SI PENA</title>
      <link rel="shortcut icon" href="../gambar/pom.png" type="image/png">
      
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    
    <link href="../assets/bootstrap/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fa/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../assets/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../assets/plugins/morris/morris.css">
    <link rel="stylesheet" href="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="../assets/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="shortcut icon" type="image/icon" href="../pv.png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link href="../assets/bootstrap/css/custom.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fa/css/font-awesome.min.css">
  <!-- Ionicons -->  
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
   <!-- iCheck -->
   <link rel="stylesheet" href="../assets/plugins/iCheck/flat/blue.css">
   <!-- Morris chart -->
   <link rel="stylesheet" href="../assets/plugins/morris/morris.css">
   <!-- jvectormap -->
   <link rel="stylesheet" href="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
   <!-- Date Picker -->
   <link rel="stylesheet" href="../assets/plugins/datepicker/datepicker3.css">
   <!-- Daterange picker -->
   <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
   <!-- bootstrap wysihtml5 - text editor -->
   <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">

   <!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery -->


   <script src="../assets/plugins/jQuery/jquery.min.js"></script>
   
    <style>
    .badge-danger {
    background-color: red;
    color: white;
    padding: 3px 7px;
    border-radius: 50%;
    font-size: 11px;
    margin-left: 50px;
}
        .rating-popup {
            display: <?= $showPopup && !$ratingProvided ? 'block' : 'none' ?>;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 9999;
            text-align: center;
            pointer-events: auto; /* Ensure popup is clickable */
        }
        .rating-stars {
            direction: rtl;
            display: inline-block;
            font-size: 2em;
        }
        .rating-stars input {
            display: none;
        }
        .rating-stars label {
            color: lightgray;
            cursor: pointer;
            display: inline-block;
        }
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: gold;
        }
        .rating-popup button {
            display: block;
            margin-top: 10px;
        }
    </style>
    
    <script src="../assets/plugins/jQuery/jquery.min.js"></script>
</head>
<body class="hold-transition skin-red-light sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
     <div class="logo">

      <span class="logo-lg"><b>SI PENA</b></span>
    </div>
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      
      
    </a>
    

  </nav>
</header>
  <aside class="main-sidebar">    
  <section class="sidebar">      
    <ul class="sidebar-menu">
      <li class="header"><h4 class="text-center"><?=  $_SESSION['username']; ?></h4></li>
      <li class="active treeview">
        <a href="index.php">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>            
        </a>          
      </li>
      
      <!-- <li><a href="index.php?p=user"><i class="fa fa-users"></i> <span>Data User</span></a></li> -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cubes"></i>
          <span>Data Stok Barang</span>
         
        </a>
          <ul class="treeview-menu">
            <li><a href="index.php?p=material&id_jenis=1" ><i class="fa fa-circle-o"></i>REAGENSIA DAN MEDIA MIKROBIOLOGI</a></li>
         <li><a href="index.php?p=material&id_jenis=2" ><i class="fa fa-circle-o"></i>BAHAN BAKAR GENSET</a></li>
         <li><a href="index.php?p=material&id_jenis=3" ><i class="fa fa-circle-o"></i>BAKU PEMBANDING</a></li>
         <li><a href="index.php?p=material&id_jenis=4" ><i class="fa fa-circle-o"></i>SUKU CADANG LABORATORIUM KIMIA</a></li>
         <li><a href="index.php?p=material&id_jenis=5" ><i class="fa fa-circle-o"></i>ALAT TULIS KANTOR</a></li>
         <li><a href="index.php?p=material&id_jenis=6" ><i class="fa fa-circle-o"></i>PERLENGKAPAN RUMAH TANGGA</a></li>
         <li><a href="index.php?p=material&id_jenis=7" ><i class="fa fa-circle-o"></i>OPERASIONAL LABORATORIUM</a></li>
          </ul>
        </li>
        <li><a href="index.php?p=datapesanan"><i class="fa fa-files-o"></i> Data Permintaan Barang</a></li>
      <?php  
if ($_SESSION['jabatan'] == 'KATIM TERA') {
?>
    <li>
        <a href="index.php?p=veriftera">
            <i class="fa fa-circle-o <?= $permintaan_tera > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_tera > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_tera; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>

      <?php  
if ($_SESSION['jabatan'] == 'KATIM PENINDAKAN') {
?>
    <li>
        <a href="index.php?p=verifpenindakan">
            <i class="fa fa-circle-o <?= $permintaan_penindakan > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_penindakan > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_penindakan; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>

      <?php  
if ($_SESSION['jabatan'] == 'KATIM PEMERIKSAAN') {
?>
    <li>
        <a href="index.php?p=verifpemeriksaan">
            <i class="fa fa-circle-o <?= $permintaan_pemeriksaan > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_pemeriksaan > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_pemeriksaan; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>



      <?php  
if ($_SESSION['jabatan'] == 'KTU') {
?>
    <li>
        <a href="index.php?p=veriftu">
            <i class="fa fa-circle-o <?= $permintaan_tu > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_tu > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_tu; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>

      <?php  
if ($_SESSION['jabatan'] == 'KATIM INFOKOM') {
?>
    <li>
        <a href="index.php?p=verifinfokom">
            <i class="fa fa-circle-o <?= $permintaan_infokom > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_infokom > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_infokom; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>



   <?php  
if ($_SESSION['jabatan'] == 'KATIM PANGAN') {
?>
    <li>
        <a href="index.php?p=verifpesanan">
            <i class="fa fa-circle-o <?= $permintaan_count > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_count > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_count; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>

   <?php  
if ($_SESSION['jabatan'] == 'KATIM MIKRO') {
?>
    <li>
        <a href="index.php?p=verifmikro">
            <i class="fa fa-circle-o <?= $permintaan_mikro > 0 ? 'text-red' : '' ?>"></i> Verifikasi KATIM
            <?php if ($permintaan_mikro > 0) { ?>
                <span class="badge badge-danger"><?= $permintaan_mikro; ?></span>
            <?php } ?>
        </a>
    </li>
<?php
}
?>



        <li><a href="index.php?p=cetakpesanan"><i class="fa fa-print"></i> Cetak SPB</a></li>                   
        <li><a href="../logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
      </ul>
    </section>    
  </aside>  
        <div class="content-wrapper">
            <?php include "page.php"; ?>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; Bpom Bengkulu 2024</strong>
        </footer>

        <!-- Rating Popup -->
    <!-- Rating Popup -->
<?php if ($showPopup && !$ratingProvided): ?>
<div class="rating-popup">
    <h3>Anda Belum Memberikan Rating untuk Pelayanan Sebelumnya</h3>
    <form id="ratingForm" method="POST" action="">
        <div class="rating-stars">
            <input type="radio" name="rating" value="baik sekali" id="star5" required>
            <label for="star5">&#9733;</label>
            <input type="radio" name="rating" value="baik" id="star4">
            <label for="star4">&#9733;</label>
            <input type="radio" name="rating" value="cukup" id="star3">
            <label for="star3">&#9733;</label>
            <input type="radio" name="rating" value="buruk" id="star2">
            <label for="star2">&#9733;</label>
            <input type="radio" name="rating" value="buruk sekali" id="star1">
            <label for="star1">&#9733;</label>
        </div>
        <textarea name="saran" placeholder="Masukkan saran Anda di sini..." rows="4" style="width: 100%; margin-top: 10px;" required></textarea>
        <button type="submit" style="margin-top: 10px;">Berikan Rating dan Saran</button>
    </form>
</div>
<?php endif; ?>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <script>
        $(document).ready(function(){
            // Disable page interactions if the popup is shown
            <?php if ($showPopup && !$ratingProvided): ?>
            $('body').css('pointer-events', 'none');
            $('#ratingForm').on('submit', function(e) {
                e.preventDefault();
                $.post('', $(this).serialize(), function() {
                     alert("Rating dan Saran Berhasil dikirim");
                    location.reload(); // Refresh the page to remove the popup
                }).fail(function() {
                    alert("Failed to submit rating. Please try again.");
                });
            });
            <?php endif; ?>
        });
        </script>

<script src="../assets/plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->

<script src="../assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<!-- datepicker -->
<script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/app.min.js"></script>

<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

</body>
