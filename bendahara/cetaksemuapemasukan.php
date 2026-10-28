<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php ob_start();
include "../fungsi/fungsi.php";

?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #3C8DBC; color: #fff; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #3C8DBC; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
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
    border: 1px solid #000000;
  }

  div.kanan {
   position: absolute;
   bottom: 100px;
   right: 50px;

 }

 div.tengah {
   position: absolute;
   bottom: 100px;
   right: 330px;

 }

 div.kiri {
   position: absolute;
   bottom: 100px;
   left: 10px;     
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
<p align="center" style="font-weight: bold; font-size: 18px;"><u>LAPORAN PEMASUKAN BARANG</u></p>
<table class="tabel2">
  <thead>
    <tr>
      <td style="text-align: center; "><b>No.</b></td>
      <td style="text-align: center;  width=80;"><b>Tanggal Masuk</b></td>
      <td style="text-align: center; width=70px;"><b>Kode Barang</b></td>
      <td style="text-align: center; width=140px;"><b>Nama Barang</b></td>
      <td style="text-align: center; width=50px;"><b>Satuan</b></td>
      <td style="text-align: center; width=50px;"><b>Jumlah</b></td> 
      <td style="text-align: center; width=70px;"><b>Total</b></td>
    </tr>
  </thead>
  <tbody>
    <?php

    include "../fungsi/koneksi.php";
    $query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, pengajuan.jumlah,pengajuan.satuan, pengajuan.total, tgl_pengajuan FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  WHERE  status=1 "); 
    $i   = 1;
    $total = 0;
    $totalharga = 0;
    $subtotalharga = 0;
    while($data=mysqli_fetch_array($query))
    {
      ?>
      <tr>
        <td style="text-align: center; width=15px; font-size: 12px;"><?php echo $i; ?></td>
        <td style="text-align: center; width=70px; font-size: 12px;"><?php echo date('d/m/Y', strtotime($data['tgl_pengajuan'])); ?></td>
        <td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
        <td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
        <td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>
        <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
        <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['total']);  ?></td>                   
      </tr>
      <?php
      $i++;
      $total=$total+$data['jumlah'];
     

    }
    ?>
  </tbody>
</table>

<p> <b>  <br> Jumlah Barang : <?= $total = $total; ?> </b></p>

<div class="kiri">
  <p> </p>
  <p>Diminta Oleh :<br>Bendahara  </p>
  <p></p>
  <p></p>
  <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>
  <br>
  <br>
  <br>


</div>



<div class="kanan">
  <p></p>
  <p>Disetujui Oleh :<br>Lurah </p>
  <p></p>
  <p> </p>       
  <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>
  <br>
  <br>
  <br>

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
  $html2pdf->Output('laporan_pengeluaran_barang.pdf');
}
catch(HTML2PDF_exception $e) {
  echo $e;
  exit;
}
?>