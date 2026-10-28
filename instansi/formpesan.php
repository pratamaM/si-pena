<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi'); ?>
<?php  
include "../fungsi/koneksi.php";
$error = "";
if (!isset($_SESSION['username'])) {
    header("Location: https://bpombengkulu.com/si-pena/");
    exit;
}
?>

<section class="content">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Form Permintaan Barang</h3>
                </div>
                <form method="post" id="tes" action="add-proses.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama_brg" class="a col-sm-3 control-label">Nama</label>
                            <div class="col-sm-3">
                                <input type="text" readonly value="<?= $_SESSION['username']; ?>" class="form-control" name="unit">
                            </div>
                        </div>
                        <div class="form-group">
    <label for="instansi" class="col-sm-3 control-label">Subtansi</label>
    <div class="col-sm-5">
        <select id="instansi" class="form-control" name="instansi" required>
            <option value="">-- Pilih Subtansi --</option>
            <option value="Penindakan">Penindakan</option>
            <option value="Pemeriksaan">Pemeriksaan</option>
            <option value="Lab.Pangan">Lab.Pangan</option>
            <option value="Lab.Teranokoko">Lab.Teranokoko</option>
            <option value="Lab.Mikrobiologi">Lab.Mikrobiologi</option>
            <option value="Infokom">Infokom</option>
            <option value="Tata Usaha">Tata Usaha</option>
        </select>
    </div>
    <span class="col-sm-7"> <?php echo $error; ?></span>
</div>

                        <div class="form-group">
                            <label for="jenis_brg" class="col-sm-3 control-label">Jenis Barang</label>
                            <div class="col-sm-5">
                                <select id="jenis_brg" required class="form-control" name="id_jenis">
                                    <option value="">--Pilih Jenis Barang--</option>
                                    <?php
                                    $queryJenis = mysqli_query($koneksi, "SELECT * FROM jenis_barang");
                                    if (mysqli_num_rows($queryJenis)) {
                                        while($row = mysqli_fetch_assoc($queryJenis)): ?>
                                            <option value="<?= $row['id_jenis']; ?>"><?= $row['jenis_brg']; ?></option>
                                        <?php endwhile; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_brg" class="col-sm-3 control-label">Nama Barang</label>
                            <div class="col-sm-5">
                                <select id="nama_brg" required class="form-control" name="kode_brg">
                                    <option value="">--Pilih Nama Barang--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stok" class="col-sm-3 control-label">Stok Tersedia</label>
                            <div class="col-sm-2">
                                <input id="stok" disabled value="----" type="text" class="form-control" name="stok">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-2">
                                <input id="jumlah" type="number" min="1" class="form-control" name="jumlah" required>
                            </div>
                            <span class="col-sm-7" id="jumlah-error"> <?php echo $error; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="keperluan" class="col-sm-3 control-label">Keperluan</label>
                            <div class="col-sm-5">
                                <input id="keperluan" type="text" class="form-control" name="keperluan" required>
                            </div>
                            <span class="col-sm-7"> <?php echo $error; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="simpan" name="simpan" class="btn btn-primary col-sm-offset-3" value="Simpan">
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Hari Ini</h3>
                </div>

                   <table class="table table-responsive">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keperluan</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <?php 
                        $sekarang  = date("Y-m-d");
                        $queryTampil = mysqli_query($koneksi, "SELECT sementara.unit, sementara.keperluan, sementara.id_sementara, stokbarang.nama_brg, stokbarang.satuan, jumlah FROM sementara INNER JOIN stokbarang ON sementara.kode_brg  = stokbarang.kode_brg WHERE tgl_permintaan = '$sekarang' AND sementara.unit='$_SESSION[username]' ");
                        $no = 1;
                        if(mysqli_num_rows($queryTampil) > 0) {
                            while($row = mysqli_fetch_assoc($queryTampil)):
                        ?>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $row['nama_brg']; ?></td>
                        <td><?php echo $row['jumlah']; ?> </td>
                        <td><?php echo $row['satuan'] ?></td>
                        <td><?php echo $row['keperluan'] ?></td>
                        <td><a href="hapusps.php?id=<?php echo $row['id_sementara']; ?>" class="btn btn-danger">Hapus</a></td>
                    </tr>
                    <?php $no++; endwhile; } else { echo "<tr><td colspan='6'>Tidak ada permintaan barang hari ini</td></tr>"; } ?>
                </table>    
                <div class="box-body">
    <a class="btn btn-success" href="pesan.php?username=<?php echo urlencode($_SESSION['username']); ?>">Minta Barang</a>
</div>

            </div>
        </div>
    </div>
</section>

<!-- Include Select2 CSS and JS -->


<script>
    $(document).ready(function(){
        // Initialize Select2 on the nama_brg dropdown
        $('#nama_brg').select2({
            placeholder: '--Pilih Nama Barang--',
            allowClear: true
        });

        // Event saat jenis barang dipilih
        $("#jenis_brg").change(function(){
            var jenis = $(this).val();
            var dataString = 'jenis='+jenis;

            $.ajax({
                type: "POST",
                url: "getdata.php",
                data: dataString,
                success: function(html) {
                    console.log("Response from server:", html); // Debugging log
                    $("#nama_brg").html(html);
                    $('#nama_brg').select2({
                        placeholder: '--Pilih Nama Barang--',
                        allowClear: true
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " " + error); // Debugging log
                    alert("Terjadi kesalahan saat memuat data Nama Barang.");
                }
            });
        });

        // Populate stock field when a nama_brg is selected
        $("#nama_brg").change(function(){
            var kode = $(this).val();
            var dataString = 'kode='+kode;
            $.ajax({
                type: "POST",
                url: "getkode.php",
                data: dataString,
                success: function(html) {
                    $("#stok").val(html);
                    checkStock(); // Check stock after fetching data
                }
            });
        });

        // Initial stock check on page load
        checkStock(); 

        // Bind checkStock to jumlah input field
        $("#jumlah").keyup(checkStock);

        // Form submission prevention
        $("form").on("submit", function(e) {
            var stok = parseInt(document.getElementById('stok').value) || 0;
            var jumlah = parseInt(document.getElementById('jumlah').value) || 0;

            if (jumlah > stok) {
                alert('Jumlah permintaan melebihi stok tersedia!');
                e.preventDefault(); // Prevent form submission
            }
        });
    });

    // Function to check stock availability
    function checkStock() {
        var stok = parseInt(document.getElementById('stok').value) || 0;
        var jumlah = parseInt(document.getElementById('jumlah').value) || 0;
        var submitButton = document.getElementById('simpan');
        var errorMessage = document.getElementById('jumlah-error');

        
        if (stok==0) {
            errorMessage.textContent = 'Stok tidak tersedia untuk barang ini.';
            errorMessage.style.color = 'red';
            submitButton.disabled = true;
            return;
        }

        if (jumlah > stok) {
            errorMessage.textContent = 'Jumlah permintaan melebihi stok tersedia!';
            errorMessage.style.color = 'red';
            submitButton.disabled = true;
        } else {
            errorMessage.textContent = ''; // Clear error message
            submitButton.disabled = false;
        }
    }
</script>
