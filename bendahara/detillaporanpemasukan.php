<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>

<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['tgl']) && isset($_GET['unit'])) {
    $tgl = $_GET['tgl'];
    $unit = $_GET['unit'];
    

    $query = mysqli_query($koneksi, "SELECT pengajuan.tgl_pengajuan, pengajuan.id_pengajuan, pengajuan.unit, pengajuan.kode_brg, pengajuan.jumlah, pengajuan.status, stokbarang.nama_brg, stokbarang.satuan FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg WHERE status=1 ORDER BY tgl_pengajuan DESC "); 
    
}
?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-center">Data Pemasukan Barang  <?php echo $unit; ?></h3>
            </div>    
            <div class="box-body"> 
             <div class="table-responsive">
                <a href="index.php?p=laporanpemasukan" style="margin:10px;" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>  
            </div>

            <table class="table table-bordered table-hover text-center" id="datapesanan">
                <thead  > 
                    <tr>
                        <th>No</th> 
                        <th>Tanggal Penambahan</th>
                        <th>User</th>                                                                
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>                                                           
                        <th>Status</th> 

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
                             <td> <?= tanggal_indo($row['tgl_pengajuan']); ?> </td>                                      
                             <td> <?= $row['unit']; ?> </td>
                             <td> <?= $row['nama_brg']; ?> </td> 
                             <td> <?= $row['satuan']; ?> </td>                                       
                             <td> <?= $row['jumlah']; ?> </td>                                    

                             <td > <?php
                             if ($row['status'] == 0){
                                echo '<span class=text-warning>Barang Belum Tersimpan</span>';
                            } elseif ($row['status'] == 1) {
                                echo '<span class=text-primary>Tersimpan Ke Stok Barang</span>';
                            } else {
                                echo '<span class=text-danger>Tidak Disetujui</span>';
                            }
                            ?> 
                        </td>   

                    </tr>


                    <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Tidak ada.</td></tr>";} ?>
                </tbody>

            </table>
        </div>                  
    </div>
</div>
</div>
</div>



</section>


