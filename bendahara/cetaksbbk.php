<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

// Start session
ob_start();

$id  = isset($_GET['id']) ? $_GET['id'] : false;
$unit = $_GET['unit'];
$instansi = $_GET['instansi'];
$tgl = $_GET['tgl'];
$no_surat = $_GET['no_surat'];

// Get current login user info
$currentUser = $_SESSION['username'];
$queryUser = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='$currentUser'");
if ($queryUser) {
    $userData = mysqli_fetch_assoc($queryUser);
    $currentUserID = $userData['id_user'];
} else {
    $currentUserID = 'Unknown';
}
?>

<!-- HEADER STYLE -->
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

</style>

<div style="position: absolute; right: 0; top: 0; font-weight: bold; font-size: 12px;">
  POM-14.01/CFM.01/SOP.01/IK.2B.04/F.02
</div>

<table>
  <tr>
    <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px" /></th>
    <td align="center" style="width: 520px;">
      <font style="font-size: 18px"><b>BALAI POM DI BENGKULU</b></font><br>
      Jl. Depati Payung Negara KM.13 No. 29, Pekan Sabtu, Kota Bengkulu, Bengkulu 38213<br>
      Telp : 0811 738 9062
    </td>
  </tr>
</table>

<hr>

<p align="center" style="font-weight: bold; font-size: 18px;">
  <u>SURAT BUKTI BARANG KELUAR (SBBK)</u><br>
</p>

<!-- DATA SURAT -->
<table style="width: 100%; margin-bottom: 10px;">
  <tr>
    <td><b>Nomor</b></td>
    <td>: <?= $no_surat; ?></td>
  </tr>
  <tr>
    <td><b>Subtansi</b></td>
    <td>: <?= $instansi; ?></td>
  </tr>
</table>

<!-- TABEL BARANG -->
<table class="tabel2">
  <thead>
    <tr>
      <th class="col-no">No</th>
      <th class="col-nama">Nama Barang</th>
      <th class="col-satuan">Satuan</th>
      <th class="col-keperluan">Keperluan</th>
      <th class="col-jumlah">Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = mysqli_query($koneksi, "SELECT permintaan.kode_brg, unit, nama_brg, jumlah, keperluan, satuan, tgl_permintaan, no_surat 
                                     FROM permintaan 
                                     INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg 
                                     WHERE unit='$unit' AND status=1 AND tgl_permintaan='$tgl' AND no_surat='$no_surat'");

    $i = 1;
    while($data = mysqli_fetch_array($query)) { ?>
      <tr>
        <td class="col-no"><?= $i; ?></td>
        <td class="col-nama" style="text-align:left;"><?= $data['nama_brg']; ?></td>
        <td class="col-satuan"><?= $data['satuan']; ?></td>
        <td class="col-keperluan"><?= $data['keperluan']; ?></td>
        <td class="col-jumlah"><?= $data['jumlah']; ?></td>
      </tr>
    <?php $i++; } ?>
  </tbody>
</table>

<br>

<b>Diserahkan Pada Tanggal: <?= tanggal_indo($tgl) ?></b>
<br><br>

<?php 
$query2 = mysqli_query($koneksi, "SELECT id_user, username FROM user WHERE username='$unit' ");
$penerima = mysqli_fetch_assoc($query2);
?>

<!-- TANDA TANGAN RAPI -->

<table style="width:100%; margin-top:10px;">
    <tr>
        <td style="width:50%; text-align:center;">
            <b>Diterima Oleh :</b><br><br><br><br><br>
            <u><?= $penerima['username'] ?></u><br>
            NIP: <?= $penerima['id_user'] ?>
        </td>

        <td style="width:50%; text-align:center;">
            <b>Diserahkan Oleh :</b><br><br><br><br><br>
            <u><?= $_SESSION['username'] ?></u><br>
            NIP: <?= $currentUserID ?>
        </td>
    </tr>
</table>


<?php
$content = ob_get_clean();
include '../assets/html2pdf/html2pdf.class.php';

try {
  $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->writeHTML($content);
  $html2pdf->Output('sbbk.pdf');
} catch (HTML2PDF_exception $e) {
  echo $e;
  exit;
}
?>
