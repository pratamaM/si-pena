<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-left">Cetak Laporan Barang Keluar</h3>
            </div>  


            <div class="col-md-12">
                <form method="POST" action='cetak_lap_barangkeluar.php' target="_blank" class="form-inline">
                    <div class="form-group">
                        <label>  Dari Tanggal   </label>
                        <input type="date" id="tanggala" class="form-control" name="tanggala">
                    </div>
                    <div class="form-group">
                        <label>  Sampai Tanggal </label>
                        <input type="date" id="tanggalb" class="form-control" name="tanggalb">
                    </div>
                    <div class="form-group">

                        <input type='submit' name="POST" value="Cetak" class='btn btn-success'>
                        <a href="cetaksemuapengeluaran.php" target="_blank" style="margin:10px;" class="btn btn-success"><i class='fa fa-print'> Cetak Semua Laporan</i></a>

                    </div>
                </form>
            </div>
            <div class="box-body"> 
                <div class="table-responsive">
                    <table id="datapesanan" class="table text-center">
                        <thead  > 
                            <tr>
                                <th>No</th> 
                                <th>Tanggal Permintaan</th>
                                <th>Instansi</th>
                                <th>Aksi</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tbody>
                        </table>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>