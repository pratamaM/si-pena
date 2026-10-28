<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php 
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 

// Ambil variabel GET dengan aman
$id        = isset($_GET['id']) ? $_GET['id'] : '';
$unit      = isset($_GET['unit']) ? $_GET['unit'] : '';
$instansi  = isset($_GET['instansi']) ? $_GET['instansi'] : '';
$tgl       = isset($_GET['tgl']) ? $_GET['tgl'] : '';
$no_surat  = isset($_GET['no_surat']) ? $_GET['no_surat'] : '';

// Jika parameter penting tidak ada → hentikan
if ($unit == '' || $tgl == '' || $no_surat == '') {
    die("Parameter tidak lengkap!");
}
?>

<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}

  .tabel2 {
    border-collapse: collapse;
    width: 100%;
    table-layout: fixed; /* penting supaya wrap */
  }

  .tabel2 th, .tabel2 td {
    padding: 5px;
    border: 1px solid #000;
    word-wrap: break-word;
    font-size: 12px;
    text-align: center;
  }

  /* Lebar kolom */
  .col-no       { width: 35px; }
  .col-nama     { width: 180px; } /* diperkecil */
  .col-satuan   { width: 70px; }
  .col-keperluan{ width: 250px; }
  .col-jumlah   { width: 60px; }


thead { display: table-header-group; }
tfoot { display: table-footer-group; }

.col-no       { width: 8%; }
.col-nama     { width: 40%; }
.col-satuan   { width: 12%; }
.col-keperluan{ width: 20%; }
.col-jumlah   { width: 10%; }

table, tr, td { page-break-inside: auto; }

.kiri {
    width: 300px;
    float: left;
    margin-left: 80px;
    margin-top: 20px;
}
</style>

<div style="position: absolute; right: 0; top: 0; font-weight: bold; font-size: 12px;">
  POM-14.01/CFM.01/SOP.01/IK.2B.04/F.02
</div>

<table>
<tr>
    <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px" /></th>
    <td align="center" style="width: 520px;">
        <font style="font-size: 18px;"><b>BALAI POM DI BENGKULU</b></font><br>
        Jl. Depati Payung Negara KM.13 No. 29, Pekan Sabtu, Kota Bengkulu<br>
        Telp : 0811 738 9062
    </td>
</tr>
</table>

<hr>

<p align="center" style="font-weight: bold; font-size: 18px;">
  <u>SURAT PERMINTAAN BARANG (SPB)</u><br>
  <b>No : <?= $no_surat ?></b>
</p>

<table>
<tr>
    <td><b>Subtansi</b></td>
    <td><b>: <?= $instansi ?></b></td>
</tr>
<tr>
    <td><b>Pada tanggal</b></td>
    <td><b>: <?= tanggal_indo($tgl) ?></b></td>
</tr>
</table>

<table class="tabel2">
<thead>
<tr>
    <th class="col-no"><b>No.</b></th>
    <th class="col-nama"><b>Nama Barang</b></th>
    <th class="col-satuan"><b>Satuan</b></th>
    <th class="col-keperluan"><b>Keperluan</b></th>
    <th class="col-jumlah"><b>Jumlah</b></th>
</tr>
</thead>
<tbody>
<?php

$query = mysqli_query($koneksi, 
"SELECT permintaan.kode_brg, nama_brg, jumlah, keperluan, satuan 
 FROM permintaan 
 INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg 
 WHERE unit='$unit' AND status=1 AND tgl_permintaan='$tgl' AND no_surat='$no_surat' ");

$i = 1;
$total = 0;

if (mysqli_num_rows($query) == 0) {
    echo "<tr><td colspan='5'><b>Tidak ada data permintaan.</b></td></tr>";
}

while($data = mysqli_fetch_assoc($query)) {
?>
 <tr>
        <td class="col-no"><?= $i; ?></td>
        <td class="col-nama" style="text-align:left;"><?= $data['nama_brg']; ?></td>
        <td class="col-satuan"><?= $data['satuan']; ?></td>
        <td class="col-keperluan"><?= $data['keperluan']; ?></td>
        <td class="col-jumlah"><?= $data['jumlah']; ?></td>
      </tr>
<?php
$i++;
$total += $data['jumlah'];
}
?>
</tbody>
</table>

<table class="tabel2">
<tr>
    <td style="text-align:center;"><b>Total Barang</b></td>
    <td style="text-align:center;"><b><?= $total ?></b></td>
</tr>
</table>

<?php 
$q2 = mysqli_query($koneksi, "SELECT id_user, username FROM user WHERE username='$unit'");
$dataUser = mysqli_fetch_assoc($q2);
?>

<div class="kiri">
  <p>Diminta Oleh :</p><br><br><br>
  <p><b><u><?= $dataUser['username'] ?></u><br>NIK: <?= $dataUser['id_user'] ?></b></p>
</div>

<?php
$content = ob_get_clean();
require '../assets/html2pdf/html2pdf.class.php';

try {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
