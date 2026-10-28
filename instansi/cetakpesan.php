<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
        //die($id = $_GET['id']);
  $tgl = $_GET['tgl'];
  echo $tgl;

  if ($_GET['aksi'] == 'detil') {
    header("location:?p=detil&tgl=$tgl");
  } 
}

$query = mysqli_query($koneksi, "SELECT unit, instansi, tgl_permintaan, count(kode_brg),no_surat FROM permintaan WHERE unit= '$_SESSION[username]' AND status=1  GROUP BY no_surat  ");   

?>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-sm-12">
     <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="text-center">CETAK SURAT PERMINTAAN BARANG (SPB)
        </h3>
      </div>                
      <div class="box-body">
        <div class="table-responsive">
          <table class="table text-center">
            <thead  > 
              <tr>
                <th>No</th>                                                                                             
                <th>Tanggal Permintaan</th>
                <th>No Surat Permintaan</th>    
                <th>Jumlah Permintaan</th>  
                                            
                <th>Aksi</th>
                
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php 
                $no =1 ;
                if (mysqli_num_rows($query)) {
                  while($row=mysqli_fetch_assoc($query)):

                   ?>
                   <td> <?= $no; ?> </td>                                      
                   <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>  
                   <td> <?= $row['no_surat']; ?> </td>  
                   <td> <?= $row['count(kode_brg)']; ?> </td>    
                   
                   <td>        
                    <a target="_blank" href="cetakpesanan.php?&tgl=<?= $row['tgl_permintaan']; ?>&unit=<?= $row['unit']; ?>&instansi=<?= $row['instansi']; ?>&no_surat=<?= $row['no_surat']; ?>"><span data-placement='top' data-toggle='tooltip' title='Cetak SPB'><button class="btn btn-success"><i class="fa fa-print"> Cetak SPB</i></button></span></a>                  
                  </td>
                </tr>        

                <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Belum ada SPB yang akan dicetak</td></tr>";} ?>

              </tbody>
            </table>
          </div>                  
        </div>
      </div>
    </div>
  </div>


</section>

