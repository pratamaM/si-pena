<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php 

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 
$id  = isset($_GET['id']) ? $_GET['id'] : false;


$unit = $_GET['unit'];
$instansi = $_GET['instansi'];
$tgl= $_GET['tgl'];
$no_surat= $_GET['no_surat'];

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
  margin-left: 0px;
}
.tabel2 th, .tabel2 td {
  padding: 5px 5px;
  border: 1px solid #000;
}
.tabelatas{

  margin-left: 0px;
}
p{

  margin-left: 0px;
}

div.kanan {
 width:300px;
 float:right;
 margin-left:150px;
 margin-top:-220;
 display:inline;
}

div.kiri {
 width:300px;
 float:left;
 margin-left:-10px;
 display:inline;
}
div.tengah {
 width:300px;
 float:left;
 margin-left:195px;
 margin-top:2;
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
  <!-- <table>
<tr>
    <td colspan="2" align="center">
        <div style="text-align: center;">
            <img src="../gambar/jy.png" style="width:100px;height:100px" />
            <div style="font-size: 18px; font-weight: bold; margin-top: 10px;">
                BALAI POM DI BENGKULU
            </div>
            <div style="font-size: 16px; margin-top: 5px;">
                Jl. Depati Payung Negara KM.13 No. 29, Pekan Sabtu, Kec. Selebar, Kota Bengkulu, Bengkulu 38213<br>
                Telp: 0811 738 9062
            </div>
        </div>
    </td>
</tr>
  </table> -->
  <hr>
  <p align="center" style="font-weight: bold; font-size: 18px;">
  <u>SURAT PERMINTAAN BARANG (SPB)</u><br>
  <b>No : <?= $no_surat ?></b>
</p>

  <div class="isi" style="margin: 0 auto;">

   <table class="tabelatas">
    <tr>
      <td style="text-align: left; width=100px;  "><b>Subtansi </b></td>  
      <td style="text-align: left; "><b>: <?= $instansi; ?></b></td>           
    </tr>
    <tr>
      <td style="text-align: left; width=100px;  "><b>Pada tanggal </b></td>   
      <td style="text-align: left; "><b>: <?=  tanggal_indo($tgl); ?></b></td>       
    </tr>

  </table>
  <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; width=10px; "><b>No.</b></td>        
       <td style="text-align: center; width=336px;"><b>Nama Barang</b></td>
        <td style="text-align: center; width=80px;"><b>Satuan</b></td> 
        <td style="text-align: center; width=100px;"><b>Keperluan</b></td>    
        <td style="text-align: center; width=80px;"><b>Jumlah</b></td>  
      </tr>
    </thead>
    <tbody>
      <?php


      $query = mysqli_query($koneksi, "SELECT permintaan.kode_brg, unit, nama_brg, jumlah, satuan, tgl_permintaan, no_surat FROM permintaan INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg  WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' AND no_surat='$no_surat' "); 
      $i   = 1;
      $total = 0;
      while($data=mysqli_fetch_array($query))
      {
        ?>
          <tr>
          <td style="text-align: center; font-size: 12px;width=10px"><?php echo $i; ?></td>             
          <td style="text-align: left; font-size: 12px; width=10px"><?php echo $data['nama_brg']; ?></td>
          <td style="text-align: center; font-size: 12px;width=10px"><?php echo $data['satuan']; ?></td>  
          <td style="text-align: center; font-size: 12px;width=10px"><?php echo $data['keperluan']; ?></td>    
          <td style="text-align: center; font-size: 12px;width=10px"><?php echo $data['jumlah']; ?></td>                    
                     
        </tr>
        <?php
        $i++;
        $total=$total+$data['jumlah'];
      }
      ?>
    </tbody>

  </table>
  <table class="tabel2">
    <tr>
    <td style="text-align: center; width=595px;"><b>Total Barang</b></td>          


      <td style="text-align: center; width=80px;"><b><?= $total = $total; ?></b></td>                                        
    </tr>
  </table>


</div>

<?php 

$query2 = mysqli_query($koneksi, "SELECT id_user,username FROM user WHERE username='$unit' ");
if ($query2){                
  $data = mysqli_fetch_assoc($query2);

} else {
  echo 'gagal';
}
?>

<!-- <div class="kiri">
  <p> </p>
  <p>Diminta Oleh :</p>
  <p></p>
  <p></p>
  <b><p><u><?= $data['username'] ?></u><br>NIK: <?= $data['id_user'] ?></p></b>
  <br>
  <br>
  <br>
</div> -->
<div class="kiri" style="margin-left: 80px; margin-top: 20px;">
  <p style="margin: 0;">Diminta Oleh :</p>
  <p></p>
  <p></p>
  <p></p>
  <p style="margin: 0;"><b><u><?= $data['username'] ?></u><br>NIP: <?= $data['id_user'] ?></b></p>
</div>




<!-- <div class="kanan">
  <p></p>
  <p>Dikeluarkan Oleh :</p>
  <p></p>
  <p> </p>
  <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>
  <br>
  <br>
  <br>

</div> -->

<!-- <div class="tengah">
 <p></p>
 <p>Disetujui Oleh :<br>Lurah </p>
 <p></p>
 <p> </p>
 <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>
 <br>
 <br>
 <br>

</div> -->
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