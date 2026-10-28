<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";


$query = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE status=0 AND unit = '$_SESSION[username]'" );    
$permintaan_count = mysqli_num_rows($query);  
$deal =mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan, no_surat FROM permintaan WHERE status=1 AND unit = '$_SESSION[username]'");    
 $deals= mysqli_num_rows($deal);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include Chart.js library -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .chart-container {
      width: 80%;
      max-width: 800px;
      margin: 0 auto;
    }

    .small-box {
      position: relative;
      display: block;
      margin-bottom: 20px;
      padding: 15px;
      color: #fff;
      background-color: #3c8dbc;
      border-radius: 5px;
    }

    .small-box .inner {
      padding: 10px 10px 0 10px;
    }

    .small-box .icon {
      position: absolute;
      top: -10px;
      right: 10px;
      z-index: 0;
      font-size: 70px;
      color: rgba(0, 0, 0, 0.15);
    }

    .small-box .small-box-footer {
      display: block;
      padding: 10px;
      background: rgba(0, 0, 0, 0.1);
      color: #fff;
      text-align: center;
      text-decoration: none;
    }

    .small-box .badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #d9534f; /* Red color */
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
     .small-box .sukses {
      position: absolute;
      top: 40px;
      right: 10px;
      background-color: green; /* Red color */
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
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
        <div></div>
        <?php if ($permintaan_count > 0): ?>
          <span class="badge"><?= $permintaan_count ?> Permintaan Belum Disetujui</span>
           <?php endif; ?>
           <?php if ($deals > 0): ?>
           <span class="sukses"><?= $deals ?> Permintaan Disetujui</span>
        <?php endif; ?>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="index.php?p=datapesanan" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-4 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <p><font size="5px"><b>Data Stok Barang</b></font></p>
          <p>Data Stok Barang</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="index.php?p=material" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-4 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <p><font size="5px"><b>Tata Tertib</b></font></p>
          <p>Tata Tertib Permintaan Barang</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="" class="small-box-footer" data-toggle="modal" data-target="#myModal">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
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

  <!-- Row for the chart -->
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
  </div>
  </div> -->

  <!-- Row for the chart -->
 
  </div>
</section>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Tata Tertib Permintaan Barang</b></h4>
      </div>
      <!-- body modal -->
      <div class="modal-body">
        <p>1. Peminta menginput data permintaan barang di form permintaan barang.</p>
        <p>2. Permintaan di konfirmasi oleh Pihak BMN.</p>
        <p>3. Setelah di konfirmasi yang bersangkutan bisa mencetak SPB dan menyerahkan nya ke pihak BMN untuk pengambilan barang.</p>
        <p>4. Saat menyerahkan barang yang diminta yang bersangkutan dan pihak BMN menanda tangani SBBK yang sudah di cetak oleh pihak BMN.</p>
      </div>
      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

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

<script>
  // Data for the chart
  const dates = <?php echo json_encode($dates); ?>;
  const totals = <?php echo json_encode($totals); ?>;

  // Chart.js initialization
  document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('permintaanChart').getContext('2d');
    const permintaanChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
          label: 'Jumlah Permintaan',
          data: totals,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          x: {
            beginAtZero: true
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
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
