<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

/* ===============================
   PAGINATION SETTING
================================ */
$page  = max(1, isset($_GET['page']) ? (int)$_GET['page'] : 1);
$limit = 10;
$offset = ($page - 1) * $limit;

/* ===============================
   SEARCH NO SURAT / NAMA / INSTANSI
================================ */
$search = isset($_GET['search'])
    ? $_GET['search']
    : '';

$where = "status = 1";

if ($search != '') {
    $where .= " AND (
        no_surat LIKE '%$search%'
        OR unit LIKE '%$search%'
        OR instansi LIKE '%$search%'
    )";
}

/* ===============================
   DELETE DATA
================================ */
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $unit = $_GET['unit'];
    $tgl  = $_GET['tgl'];

    mysqli_query($koneksi, "
        DELETE FROM permintaan
        WHERE unit='$unit' AND tgl_permintaan='$tgl'
    ");

    header("location:?p=datapengeluaran");
    exit;
}

/* ===============================
   TOTAL DATA (FOR PAGINATION)
================================ */
$totalQuery = mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT CONCAT(unit,tgl_permintaan,IFNULL(no_surat,''))) AS total
    FROM permintaan
    WHERE $where
");
$totalRows  = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $limit);

/* ===============================
   MAIN QUERY
================================ */
$query = mysqli_query($koneksi, "
    SELECT id_permintaan, unit, instansi, tgl_permintaan, no_surat, delivery_option
    FROM permintaan
    WHERE $where
    GROUP BY 
        unit,
        tgl_permintaan,
        CASE 
            WHEN no_surat IS NOT NULL AND no_surat <> '' THEN no_surat
            ELSE unit
        END
    ORDER BY tgl_permintaan DESC
    LIMIT $limit OFFSET $offset
");
?>

<section class="content">
<div class="row">
<div class="col-sm-12">
<div class="box box-primary">

<div class="box-header with-border">
  <h3 class="box-title">Data Permintaan Barang</h3>
</div>

<div class="box-body">

<!-- SEARCH -->
<div class="row" style="margin-bottom:10px;">
  <div class="col-md-4">
    <form method="get">
      <input type="hidden" name="p" value="datapengeluaran">
      <div class="input-group">
       <input type="text" name="search" class="form-control"
       placeholder="Cari No Surat / Nama / Instansi..."
       value="<?= $search ?>">
        <span class="input-group-btn">
          <button class="btn btn-primary">Cari</button>
        </span>
      </div>
    </form>
  </div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover text-center">
<thead style="background:#f4f4f4">
<tr>
  <th>No</th>
  <th>No Surat</th>
  <th>Tanggal</th>
  <th>Nama</th>
  <th>Instansi</th>
  <th>Detail</th>
  <th>Aksi</th>
  <th>Pengambilan</th>
</tr>
</thead>
<tbody>

<?php
$no = $offset + 1;
if (mysqli_num_rows($query) > 0):
while ($row = mysqli_fetch_assoc($query)):
?>
<tr>
  <td><?= $no++; ?></td>
  <td><b><?= $row['no_surat']; ?></b></td>
  <td><?= tanggal_indo($row['tgl_permintaan']); ?></td>
  <td><?= $row['unit']; ?></td>
  <td><?= $row['instansi']; ?></td>


   <td>
                            <a href="?p=detil_datapengeluaran&unit=<?= $row['unit']; ?>&tgl=<?= $row['tgl_permintaan']; ?>&no_surat=<?= $row['no_surat']; ?>">
                              <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                <button class="btn btn-info">Detail Barang</button>
                              </span>
                            </a>     
                          </td> 
  <td>
    <div class="btn-group">
      <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        Aksi <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="?p=editnominta&id=<?= $row['id_permintaan']; ?>">Edit</a></li>
        <li>
          <a target="_blank"
             href="cetakpesanan.php?username=<?= $_SESSION['username']; ?>
             &tgl=<?= $row['tgl_permintaan']; ?>
             &unit=<?= $row['unit']; ?>
             &instansi=<?= $row['instansi']; ?>
             &no_surat=<?= $row['no_surat']; ?>">
             Cetak SPB
          </a>
        </li>
        <li>
          <a target="_blank"
             href="cetaksbbk.php?username=<?= $_SESSION['username']; ?>
             &tgl=<?= $row['tgl_permintaan']; ?>
             &unit=<?= $row['unit']; ?>
             &instansi=<?= $row['instansi']; ?>
             &no_surat=<?= $row['no_surat']; ?>">
             Cetak SBBK
          </a>
        </li>
        <li class="divider"></li>
        <li>
          <a class="text-red"
             href="?p=datapengeluaran&aksi=hapus
             &unit=<?= $row['unit']; ?>
             &tgl=<?= $row['tgl_permintaan']; ?>"
             onclick="return confirm('Yakin ingin menghapus?')">
             Hapus
          </a>
        </li>
      </ul>
    </div>
  </td>

  <td>
    <?php
    if ($row['delivery_option'] == '') {
        echo '<span class="label label-warning">Belum Memilih</span>';
    } elseif ($row['delivery_option'] == 'diantarkan') {
        echo '<span class="label label-info">Diantarkan</span>';
    } else {
        echo '<span class="label label-success">Diambil di Tempat</span>';
    }
    ?>
  </td>
</tr>
<?php endwhile; else: ?>
<tr>
  <td colspan="8">Belum ada permintaan</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<!-- PAGINATION -->
<div class="text-center">
<ul class="pagination">
<?php if ($page > 1): ?>
<li><a href="?p=datapengeluaran&page=<?= $page-1; ?>&search=<?= urlencode($search); ?>">&laquo; Prev</a></li>
<?php endif; ?>

<?php for ($i=1; $i<=$totalPages; $i++): ?>
<li class="<?= ($i==$page)?'active':''; ?>">
<a href="?p=datapengeluaran&page=<?= $i; ?>&search=<?= urlencode($search); ?>">
    <?= $i; ?>
  </a>
</li>
<?php endfor; ?>

<?php if ($page < $totalPages): ?>
<li><a href="?p=datapengeluaran&page=<?= $page+1; ?>&search=<?= urlencode($search); ?>">Next &raquo;</a></li>
<?php endif; ?>
</ul>
</div>

</div>
</div>
</div>
</div>
</section>
