<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

// Check if 'aksi' and 'tgl' are set and valid
if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];
    echo htmlspecialchars($tgl);

    if ($_GET['aksi'] == 'detil') {
        header("Location: ?p=detil&tgl=$tgl");
        exit(); // Ensure script stops execution after redirection
    } 
}

// Query to get data from permintaan
$query = mysqli_query($koneksi, "SELECT tgl_permintaan, count(kode_brg) AS jumlah_permintaan, status, delivery_option FROM permintaan WHERE unit = '".mysqli_real_escape_string($koneksi, $_SESSION['username'])."' GROUP BY tgl_permintaan");

// Variable to track if any delivery_option is still "tidak ada"
$showSubmitButton = false;
?>

<!-- Include Bootstrap CDN for styling -->

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Barang</h3>
                </div>                
                <div class="box-body">
                    <a href="index.php?p=formpesan" style="margin:10px 15px;" class="btn btn-success"><i class='fa fa-plus'> Form Permintaan Barang</i></a>
                    <div class="table-responsive">
                        <form action="proses_pilihan.php" method="POST">
                            <table class="table text-center">
                                <thead> 
                                    <tr>
                                        <th>No</th>                                                    
                                        <th>Tanggal Permintaan</th>
                                        <th>Jumlah Permintaan</th>
                                        <th>Tanggapan</th>                                      
                                        <th>Pilihan Pengambilan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    if (mysqli_num_rows($query)) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            // Check if delivery_option is still empty
                                              
                                            if ($row['delivery_option'] == '') {
                                                $showSubmitButton = true;
                                            }
                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>                                                        
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>  
                                        <td> <?= $row['jumlah_permintaan']; ?> </td>    
                                        <td>
                                          
                                        <?php
                                       if ($row['status'] == 0){
                                        echo '<span class=text-warning>Menunggu Persetujuan</span>';
                                    } elseif ($row['status'] == 1) {
                                        echo '<span class=text-primary>Telah Disetujui</span>';
                                    } else {
                                        echo '<span class=text-danger>Tidak Disetujui</span>';
                                    }
                                    ?> 
                                        </td>
                                        <td>
                                    
                                            <?php if ( $row['delivery_option'] == ''): ?>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                        <input type="radio" name="delivery_option[<?= htmlspecialchars($row['tgl_permintaan']); ?>]" value="diantarkan" autocomplete="off" checked> Diantarkan
                                                    </label>
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="delivery_option[<?= htmlspecialchars($row['tgl_permintaan']); ?>]" value="diambil" autocomplete="off"> Diambil di tempat
                                                    </label>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: green;">   <?= $row['delivery_option'] == 'diantarkan' ? 'Diantarkan' : 'Diambil di tempat'; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?p=datapesanan&aksi=detil&tgl=<?= htmlspecialchars($row['tgl_permintaan']); ?>"><span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'><button type="button" class="btn btn-info">Detail Permintaan</button></span></a>
                                        </td>
                                    </tr>    
                                    <?php 
                                        $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>Tidak ada Data.</td></tr>";
                                    } 
                                    ?>
                                </tbody>
                            </table>

                            <?php if ($showSubmitButton): ?>
                                <button type="submit" class="btn btn-success">Kirim Pilihan</button>
                            <?php endif; ?>
                        </form>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.btn-group-toggle .btn').on('click', function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
