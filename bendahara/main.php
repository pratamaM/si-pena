<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php 
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$query = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE status=0 ");    
$permintaan_count = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include Bootstrap and Chart.js library -->

  <style>
    .chart-container {
      width: 80%;
      max-width: 800px;
      margin: 0 auto;
    }
    .X{
      width: 16%;
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <p><font size="5px"><b>Data Permintaan</b></font></p>
            <p>Olah Data Permintaan Barang </p>
          </div>
          <?php if ($permintaan_count > 0): ?>
            <span class="badge bg-red"><?= $permintaan_count ?> Permintaan</span>
          <?php endif; ?>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="index.php?p=datapermintaan" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <p><font size="5px"><b>Data Penambahan</b></font></p>
            <p>Olah Data Penambahan Barang </p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="index.php?p=datapengajuan" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <p><font size="5px"><b>Data Stok</b></font></p>
            <p>Olah Data Stok Barang</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="index.php?p=material" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <div id="bootstrap-section">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <div class="row">
    <div class="col-lg-12">
    <!-- <img src="../gambar/pkkn.png">
    <img src="../gambar/akhlak.jpeg"  class="X" > -->
    </div>
      </div>
    <!-- Bootstrap Carousel Section -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item ">
          <img src="https://bpombengkulu.com/si-pena/gambar/2.png" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item active">
          <img src="https://bpombengkulu.com/si-pena/gambar/1.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
          <img src="https://bpombengkulu.com/si-pena/gambar/3.png" class="d-block w-100" alt="Slide 3">
        </div>
      </div>
      <!-- Carousel Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>

      <!-- Thumbnail Indicators -->
      <div class="carousel-indicators d-flex flex-wrap">
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="ratio ratio-4x3 active" style="background-image: url('/assets/img/carousel/Wadah+Pengaduan+Biro+SDM.jpeg')" aria-current="true"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" class="ratio ratio-4x3" style="background-image: url('/assets/img/carousel/BIRO+SUMBER+DAYA+MANUSIA+tolak+gratifikasi+dalam+bentuk+apapun.png')"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" class="ratio ratio-4x3" style="background-image: url('/assets/img/carousel/WHISTLE+BLOWING+SYSTEM+%281%29.png')"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="3" class="ratio ratio-4x3" style="background-image: url('/assets/img/carousel/Slider+SIASN+Simphoni_1142x250+px-01+%281%29.jpg')"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="4" class="ratio ratio-4x3" style="background-image: url('/assets/img/carousel/Slider+SIASN.jpg')"></button>
      </div>
    </div>
  </div>
    <!-- Chart Section -->
    <!-- <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Permintaan Barang</h3>
          </div>
          <div class="box-body">
            <div class="chart-container">
              <canvas id="permintaanChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    
   


  </section>

  <!-- PHP Script for fetching data for the chart -->
  <?php
  // Fetch data for the chart
  $query = "SELECT tgl_permintaan, SUM(jumlah) as total_jumlah FROM permintaan GROUP BY tgl_permintaan";
  $result = mysqli_query($koneksi, $query);

  $dates = [];
  $totals = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['tgl_permintaan'];
    $totals[] = $row['total_jumlah'];
  }

  mysqli_close($koneksi);
  ?>

  <!-- Chart.js Script -->
  <script>
    // Data for the chart
    const dates = <?php echo json_encode($dates); ?>;
    const totals = <?php echo json_encode($totals); ?>;

    // Create chart
    const ctx = document.getElementById('permintaanChart').getContext('2d');
    const permintaanChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: dates,
        datasets: [{
          label: 'Total Jumlah Permintaan',
          data: totals,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
  .badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 0.5em 0.6em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
  }
  .bg-red {
    background-color: #d9534f;
  }
  .small-box {
    position: relative;
  }
</style>
</body>
</html>
