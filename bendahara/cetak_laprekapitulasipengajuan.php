<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php 

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 
$id  = isset($_GET['id']) ? $_GET['id'] : false;


$tanggala=$_POST['tanggala'];
$tanggalb=$_POST['tanggalb'];


?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  
  
</style>
<!-- Setting Margin header/ kop -->
<!-- Setting CSS Tabel data yang akan ditampilkan -->
<style type="text/css">
 .tabel2 {
  border-collapse: collapse;
  margin-left: 5px;
}
.tabel2 th, .tabel2 td {
  padding: 5px 5px;
  border: 1px solid #000;
}


div.tengah {
 position: absolute;
 bottom: 100px;
 right: 330px;
 
}

div.kanan {
 width:300px;
 float:right;
 margin-left:250px;
 margin-top:-235px;
}

div.kiri {
  width:300px;
  float:left;
  margin-left:20px;
  display:inline;
}

</style>
<table>
  <tr>
    <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px" /></th>
    <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>BALAI POM DI BENGKULU </b></font>
    <!-- <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>BALAI POM DI BENGKULU  <br> KELURAHAN JATINEGARA KAUM</b></font> -->
      <br>Jl. Depati Payung Negara KM.13 No. 29, Pekan Sabtu, Kec. Selebar, Kota Bengkulu, Bengkulu 38213<br>Telp : 0811 738 9062</td>
      
    </tr>
  </table>
  <hr>
 <p align="center" style="font-weight:bold; font-size:18px; margin:0;">
  <u>BUKTI PENGAJUAN PERMINTAAN BARANG (BPP)</u>
</p>
<div class="isi" style="margin:0 auto; font-size:12px;">
  <p style="margin:2px 0 3px 0;">
    Periode : <?= tanggal_indo($tanggala); ?> s/d <?= tanggal_indo($tanggalb); ?>
  </p>
  <table class="tabel2" style="margin-top:2px;">
  <thead>
    <tr>
      <td style="text-align: center; width: 30px; font-size: 12px;"><b>No.</b></td>        
      <td style="text-align: center; width: 200px; font-size: 12px;"><b>Nama Barang</b></td>
      <td style="text-align: center; width: 80px; font-size: 12px;"><b>Satuan</b></td>
      <td style="text-align: center; width: 70px; font-size: 12px;"><b>Jumlah</b></td> 
                                   
    </tr>
  </thead>
  <tbody>
    <?php
    include "../fungsi/koneksi.php";
    $query = mysqli_query($koneksi, "
      SELECT p.tgl_pengajuan, p.id_pengajuan, p.unit, p.kode_brg, p.jumlah, p.total, p.status, 
             s.nama_brg, s.satuan 
      FROM pengajuan p 
      INNER JOIN stokbarang s ON p.kode_brg = s.kode_brg 
      WHERE p.status=1 AND (p.tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb')
      ORDER BY p.tgl_pengajuan
    "); 
    $i = 1; 
    while($data = mysqli_fetch_array($query)) {
    ?>
    <tr>
      <td style="text-align: center; font-size: 12px; width: 30px;"><?php echo $i; ?></td>             
      <td style="text-align: left; font-size: 12px; width: 200px;"><?php echo $data['nama_brg']; ?></td>
      <td style="text-align: center; font-size: 12px; width: 80px;"><?php echo $data['satuan']; ?></td>
      <td style="text-align: center; font-size: 12px; width: 70px;"><?php echo $data['jumlah']; ?></td>
     
    </tr>
    <?php $i++; } ?>
  </tbody>
</table>

   <?php 

$query2 = mysqli_query($koneksi, "
  SELECT SUM(jumlah) AS total_jumlah 
  FROM pengajuan 
  WHERE status=1 AND (tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb')
");
$data2 = mysqli_fetch_assoc($query2);


   ?>
  <table class="tabel2">
  <tr>
    <td style="text-align: center; width: 369px;"><b>Sub Total</b></td>  
    <td style="text-align: center; width: 50px;"><b><?= $data2['total_jumlah']; ?></b></td>                                      
  </tr>
</table>

</div>


<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
include '../assets/html2pdf/html2pdf.class.php';
try
{
  $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->writeHTML($content);
  $html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
}
catch(HTML2PDF_exception $e) {
  echo $e;
  exit;
}
?>