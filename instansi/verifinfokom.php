<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$query = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan,no_surat FROM permintaan WHERE instansi='Infokom' AND katim=0 AND status=0");    
?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-center">Permintaan Barang</h3>
            </div>                

            <div class="box-body"> 
                <div class="table-responsive">
                    <table id="datapesanan" class="table text-center">
                        <thead  > 
                            <tr>
                                <th>No</th> 
                                <th>Tanggal Permintaan</th>
                                <th>Nama</th>
                                <th>Intansi</th>
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
                                     <td> <?= $row['unit']; ?> </td>   
                                     <td> <?= $row['instansi']; ?> </td> 
                                  
                                     <td>
                                        <a href="?p=detilpermintaan&unit=<?= $row['unit'];?>&tgl=<?= $row['tgl_permintaan']; ?>&no_surat=<?= $row['no_surat']; ?>"><span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'><button    class="btn btn-info">Detail Permintaan</button></span></a>       
                                        
                                    </td>                                                                                            
                                </tr>
                                <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Tidak Ada Permintaan yang Perlu verifikasi KATIM.</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>