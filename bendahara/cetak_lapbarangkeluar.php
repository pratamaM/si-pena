<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php 

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 
$id  = isset($_GET['id']) ? $_GET['id'] : false;


$unit = $_GET['unit'];
$instansi = $_GET['instansi'];
$tgl= $_GET['tgl'];

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
		margin-left: 30px;    
	}
	.tabel2 th, .tabel2 td {
		padding: 5px 5px;
		border: 1px solid #000000;

	}
	p{
		margin-left: 30px;    
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
	<p align="center" style="font-weight: bold; font-size: 18px;"><u>SURAT PERMINTAAN BARANG (SPB)</u></p>
	
	<div class="isi" style="margin: 0 auto;">
		<p style="color: black; text-align: left;">Pengeluaran Permintaan Barang dari Instansi : <?= $instansi; ?><br>Pada tanggal : <b> <?=  tanggal_indo($tgl); ?></b></p>
		<table class="tabel2">
			<thead>
				<tr>
					<td style="text-align: center; width=10px; "><b>No.</b></td>        
					<td style="text-align: center; width=100px; "><b>Kode Barang</b></td>
					<td style="text-align: center; width=150px; "><b>Nama Barang</b></td>
					<td style="text-align: center; width=120px; "><b>Satuan</b></td> 
					<td style="text-align: center; width=120px; "><b>Jumlah</b></td>                                        
				</tr>
			</thead>
			<tbody>
				<?php


				$query = mysqli_query($koneksi, "SELECT permintaan.kode_brg, unit, nama_brg, jumlah, satuan, tgl_permintaan FROM permintaan INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg  WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' "); 
				$i   = 1;
				$total = 0;
				while($data=mysqli_fetch_array($query))
				{
					?>
					<tr>
						<td style="text-align: center; font-size: 12px;"><?php echo $i; ?></td>             
						<td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
						<td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
						<td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>  
						<td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>                            
					</tr>
					<?php
					$i++;
					$total=$total+$data['jumlah'];
				}
				?>
			</tbody>
		</table>
		<?php 

		$query2 = mysqli_query($koneksi, "SELECT * FROM permintaan WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' ");  
		$data2 = mysqli_fetch_assoc($query2);

		?>


	</div>

	<?php 

	$query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$unit' ");
	if ($query2){                
		$data = mysqli_fetch_assoc($query2);

	} else {
		echo 'gagal';
	}
	?>
	<p style="color: black; text-align: left;">Total : <?= $total = $total; ?> Barang</p>
	<div class="kiri">
		<p> </p>
		<p>Diminta Oleh :<br>Admin  </p>
		<p></p>
		<p></p>
		<b><p><u><?= $data['username'] ?></u></p></b>
		<br>
		<br>
		<br>


	</div>

	<div class="tengah">
		<p>Disetujui Oleh :<br>Lurah </p>
		<br>
		<br>
		<br>
		<b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>
	</div>

	<div class="kanan">
		<p></p>
		<p>Dikeluarkan Oleh :<br>Bendahara </p>
		<p></p>
		<p> </p>
		<b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>
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
		$html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
	?>