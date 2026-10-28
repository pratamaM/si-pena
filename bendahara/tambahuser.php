<?php require_once __DIR__ . '/../fungsi/auth.php'; require_level('bendahara'); ?>
<?php  

include_once "../fungsi/koneksi.php";

if (isset($_POST['simpan'])) {
    $id_user  = trim(isset($RAW_POST['id_user']) ? $RAW_POST['id_user'] : '');
    $username = trim($RAW_POST['username']);
    $password = password_hash($RAW_POST['password'], PASSWORD_DEFAULT);
    $level    = $RAW_POST['level'];
    $jabatan  = trim($RAW_POST['jabatan']);

    if (!in_array($level, array('bendahara', 'instansi'), true) || !ctype_digit($id_user)) {
        echo '<script>alert("NIP harus angka dan level wajib dipilih.");</script>';
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO user (id_user, username, password, level, jabatan) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssss', $id_user, $username, $password, $level, $jabatan);
        if (mysqli_stmt_execute($stmt)) {
            echo '<script language="javascript">alert("Data Berhasil Disimpan !!!"); document.location="index.php?p=user";</script>';
        } else {
            echo '<script>alert("Gagal menyimpan. NIP mungkin sudah terdaftar.");</script>';
        }
        mysqli_stmt_close($stmt);
    }
}

?>

<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Tambah Data User</h3>
                </div>
                <form method="post"  action="" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="id_user" class="col-sm-offset-1 col-sm-3 control-label">NIP</label>
                            <div class="col-sm-4">
                                <input required type="text" inputmode="numeric" pattern="[0-9]+" class="form-control" name="id_user">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="paswword"class="col-sm-offset-1 col-sm-3 control-label">Password</label>
                            <div class="col-sm-4">
                                <input required type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="jabatan" class="col-sm-offset-1 col-sm-3 control-label">jabatan</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="jabatan">
                            </div>
                        </div>                       
                        <div class="form-group">
                            <label id="tes"for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Level</label>
                            <div class="col-sm-4">
                                <select required name="level" class="form-control">
                                    <option >--Pilih Level--</option>
                                    <option value="bendahara">Bendahara</option>
                                    <option value="instansi">Instansi</option>
                                    
                                </select>
                            </div>
                        </div>                         
                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4 " value="Simpan" > 
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">                                                                              
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


