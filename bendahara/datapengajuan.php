<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

// Cek apakah parameter aksi dan tgl ada
if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    $tgl = $_GET['tgl']; // Sanitasi input
    echo htmlspecialchars($tgl); // Menampilkan tanggal

    if ($_GET['aksi'] == 'detil') {
        header("Location: ?p=detil&tgl=$tgl");
        exit(); // Pastikan script berhenti setelah redirect
    } 
}

// Query untuk mendapatkan data dengan status terbaru
$query = mysqli_query($koneksi, "
    SELECT unit, tgl_pengajuan, status
    FROM pengajuan
    WHERE unit = '" . mysqli_real_escape_string($koneksi, $_SESSION['username']) . "'
    AND (tgl_pengajuan, id_pengajuan) IN (
        SELECT tgl_pengajuan, MAX(id_pengajuan)
        FROM pengajuan
        WHERE unit = '" . mysqli_real_escape_string($koneksi, $_SESSION['username']) . "'
        GROUP BY tgl_pengajuan
    )
");

// Periksa apakah query berhasil
if (!$query) {
    // Tampilkan pesan kesalahan jika query gagal
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="text-center">Data Penambahan Barang</h3>
        </div>                
        <div class="box-body">
          <a href="index.php?p=formpengajuan" style="margin:10px 15px;" class="btn btn-success">
            <i class='fa fa-plus'></i> Form Penambahan Barang
          </a>
          <div class="table-responsive">
            <table class="table text-center">
              <thead> 
                <tr>
                  <th>No</th>                                                                                             
                  <th>Tanggal Penambahan</th>
                  <th>User</th>
                  <th>Aksi</th>
                  <!-- <th>Cetak</th> -->
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($query)) {
                  while ($row = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                      <td><?= $no; ?></td>                                      
                      <td><?= tanggal_indo($row['tgl_pengajuan']); ?></td> 
                      <td><?= htmlspecialchars($row['unit']); ?></td>
                      <td>
                        <?php 
                        // Tampilkan status terbaru
                        $status = isset($row['status']) ? $row['status'] : null;
                        if ($status == 1): ?>
                          <span data-placement='top' data-toggle='tooltip' title='Status sudah 1, tidak bisa diinput'>
                            <button class="btn btn-info" disabled>Input Barang Masuk</button>
                          </span>
                        <?php else: ?>
                          <a href="?p=detilpengajuan&unit=<?= htmlspecialchars($row['unit']); ?>&tgl=<?= htmlspecialchars($row['tgl_pengajuan']); ?>">
                            <span data-placement='top' data-toggle='tooltip' title='Input Barang Masuk'>
                              <button class="btn btn-info">Input Barang Masuk</button>
                            </span>
                          </a>
                        <?php endif; ?>
                      </td>
                      <!-- <td>
                        <a target="_blank" href="cetakpengajuan.php?&tgl=<?= htmlspecialchars($row['tgl_pengajuan']); ?>&unit=<?= htmlspecialchars($row['unit']); ?>">
                          <span data-placement='top' data-toggle='tooltip' title='Cetak'>
                            <button class="btn btn-success">
                              <i class="fa fa-print"></i> Cetak Penambahan Barang
                            </button>
                          </span>
                        </a>
                      </td> -->
                    </tr>    
                    <?php 
                    $no++;
                  endwhile; 
                } else {
                  echo "<tr><td colspan='5'>Tidak ada permintaan material teknik.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>                  
        </div>
      </div>
    </div>
  </div>
</section>
