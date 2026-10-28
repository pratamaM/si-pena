<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-18">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Laporan Barang Keluar</h3>
                </div>
                <form method="POST"  class="form-inline">
                    <div class="box-body">

                        <div class="form-group">
                            <label>  Dari Tanggal   </label>
                            <input type="date" id="tanggala" class="form-control" name="tanggala">
                        </div>
                        <div class="form-group">
                            <label>  Sampai Tanggal </label>
                            <input type="date" id="tanggalb" class="form-control" name="tanggalb">
                        </div>
                        <div class="form-group">

                            <input type='submit' name="tampilkan" value="View" class='btn btn-success'>
                            <a href="cetaksemuapengeluaran.php" target="_blank" style="margin:10px;" class="btn btn-success"><i class='fa fa-print'> Cetak</i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm- col-xs-12">
            <div class="box box-info">
                <table class="table table-responsive">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Permintaan</th>
                        <th>Nama</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                    <tbody>   
                        <?php
                        include "../fungsi/koneksi.php";
                        include "../fungsi/fungsi.php";

                        if(isset($_POST["tampilkan"])){
                            $tanggala = $_POST["tanggala"];
                            $tanggalb = $_POST["tanggalb"];



                            $query = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, jumlah, satuan, tgl_keluar FROM pengeluaran INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg WHERE tgl_keluar BETWEEN '$tanggala' and '$tanggalb' "); 

                            $no = 1;    


                            echo "
                            ";
                            if (mysqli_num_rows($query)) 
                                while($data=mysqli_fetch_assoc($query)){?>

                                    <tr>
                                       <td><?php echo $no;?></td>
                                       <td> <?php echo date('d/m/Y', strtotime($data['tgl_keluar']));  ?></td>
                                       <td><?php echo $data['unit'];?></td>
                                       <td><?php echo $data['kode_brg'];?></td>
                                       <td><?php echo $data['nama_brg'];?></td>
                                       <td><?php echo $data['satuan'];?></td>
                                       <td><?php echo $data['jumlah'];?></td>
                                   </tr>
                                   <?php $no++;  ?>

                               <?php  }


                               echo " 
                               ";
                           } ?>
                       </tbody>  
                   </table>  
               </div>
           </div>
       </div>
   </section>