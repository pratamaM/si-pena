<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-left">Rekapitulasi Penambahan Barang</h3>
            </div>  


            <div class="col-md-12">
                <form method="POST" action='cetak_laprekapitulasipengajuan.php' target="_blank" class="form-inline">
                    <div class="form-group">
                        <label>  Dari Tanggal   </label>
                        <input type="date" id="tanggala" class="form-control" name="tanggala" required>
                    </div>
                    <div class="form-group">
                        <label>  Sampai Tanggal </label>
                        <input type="date" id="tanggalb" class="form-control" name="tanggalb" required>
                    </div>
                    <div class="form-group">

                        <input type='submit' name="POST" value="Cetak" class='btn btn-success'>
                        

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