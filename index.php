<?php
include "fungsi/koneksi.php";
include "fungsi/ceklogin.php";

function sipena_alert_login($pesan)
{
    return "<div class='row' style='margin-top: 15px;'><div class='col-md-12'>"
        . "<div class='box box-solid bg-red'><div class='box-header'>"
        . "<h3 class='box-title'>Login Gagal!</h3></div><div class='box-body'><p>"
        . htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8')
        . "</p></div></div></div></div>";
}

// Token CSRF untuk form login
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf'];

$err = "";

if (isset($_POST['login'])) {
    $id_user  = trim(isset($RAW_POST['id_user']) ? $RAW_POST['id_user'] : '');
    $password = isset($RAW_POST['password']) ? (string) $RAW_POST['password'] : '';
    $token    = isset($RAW_POST['csrf']) ? $RAW_POST['csrf'] : '';
    $sekarang = time();

    if (!hash_equals($csrf, (string) $token)) {
        $err = sipena_alert_login('Sesi form tidak valid. Muat ulang halaman lalu coba lagi.');
    } elseif (!empty($_SESSION['login_kunci']) && $_SESSION['login_kunci'] > $sekarang) {
        $err = sipena_alert_login('Terlalu banyak percobaan. Coba lagi dalam '
            . ($_SESSION['login_kunci'] - $sekarang) . ' detik.');
    } else {
        $stmt = mysqli_prepare($koneksi,
            "SELECT id_user, username, password, level, jabatan FROM user WHERE id_user = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $id_user);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $row   = $hasil ? mysqli_fetch_assoc($hasil) : null;
        mysqli_stmt_close($stmt);

        $upgrade = false;
        $valid   = $row && cek_password($password, $row['password'], $upgrade);

        if (!$valid) {
            $_SESSION['login_gagal'] = (isset($_SESSION['login_gagal']) ? $_SESSION['login_gagal'] : 0) + 1;
            if ($_SESSION['login_gagal'] >= 5) {
                $_SESSION['login_kunci'] = $sekarang + 60;
                $_SESSION['login_gagal'] = 0;
            }
            usleep(400000);
            $err = sipena_alert_login('NIP atau password yang anda masukan salah.');
        } elseif ($row['level'] !== 'instansi' && $row['level'] !== 'bendahara') {
            $err = sipena_alert_login('Level pengguna tidak dikenali.');
        } else {
            // Upgrade md5 lama -> bcrypt, hanya jika kolom password sudah cukup lebar
            if ($upgrade) {
                $q = mysqli_query($koneksi, "SELECT CHARACTER_MAXIMUM_LENGTH AS n FROM information_schema.COLUMNS
                    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'user' AND COLUMN_NAME = 'password'");
                $kol = $q ? mysqli_fetch_assoc($q) : null;
                if ($kol && (int) $kol['n'] >= 60) {
                    $baru = password_hash($password, PASSWORD_DEFAULT);
                    $up = mysqli_prepare($koneksi, "UPDATE user SET password = ? WHERE id_user = ?");
                    mysqli_stmt_bind_param($up, 'ss', $baru, $row['id_user']);
                    mysqli_stmt_execute($up);
                    mysqli_stmt_close($up);
                }
            }
            session_regenerate_id(true);
            $_SESSION['login']    = true;
            $_SESSION['id_user']  = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['jabatan']  = $row['jabatan'];
            $_SESSION['level']    = $row['level'];
            unset($_SESSION['login_gagal'], $_SESSION['login_kunci']);
            header('Location: ' . $row['level'] . '/index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI PENA</title>
    <link rel="shortcut icon" href="gambar/pom.png" type="image/png">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/custom.css" rel="stylesheet">
    <link href="assets/dist/css/AdminLTE.min.css" rel="stylesheet">
    <link href="assets/plugins/iCheck/square/blue.css" rel="stylesheet">
    <link href="assets/fa/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS for background and layout -->
    <style>
    body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #2c3e50;
        min-height: 100vh;
    }

    .login-container {
    position: relative;
    width: 100%;
    height: 100vh; /* Full height of the viewport */
    background: url('gambar/login.jpeg') no-repeat center center;
    background-size: cover; /* Make sure the image covers the entire container */
}
   .left-section {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /* Center the login form */
    background-color: rgba(255, 255, 255, 0.8); /* Optional: add a slight background color to make text more readable */
    padding: 20px;
    border-radius: 8px;
}

.login-box {
    background: rgba(255, 255, 255, 0.8); /* Optional: if you want the login box to have a background */
    border-radius: 8px;
    padding: 20px;
}

.modal {
    z-index: 1050; /* Ensure modal appears on top */
}
    @keyframes zoomFadeIn {
    0% {
        opacity: 0;
        transform: scale(0.8); /* Mulai dari ukuran 80% */
    }
    100% {
        opacity: 1;
        transform: scale(1); /* Menuju ukuran 100% */
    }
}
    /* .right-section {
        width: 50%;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    } */

    .right-section img {
        width: 100%;
        height: auto;
        object-fit: cover;
        animation: zoomFadeIn 1.5s ease-in-out;
    }

    .login-box {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-box-body h3 {
        color: #357ABD;
        font-weight: bold;
    }

    .title {
        text-align: center;
        margin-bottom: 20px;
    }

    .title h1 {
        font-size: 42px;
        font-weight: bold;
        margin-bottom: 10px;
        color: black;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        animation: zoomFadeIn 1.5s ease-in-out;
    }

    .title h2 {
        font-size: 20px;
        color: black;
        font-weight: 500;
        letter-spacing: 1px;
        margin-bottom: 20px;
        animation: zoomFadeIn 1.5s ease-in-out;
    }

    .btn-primary {
        background-color: #357ABD;
        border: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-primary:hover {
        background-color: #285a8e;
        transform: scale(1.1);
    }

    .form-control {
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #357ABD;
        box-shadow: 0px 0px 10px rgba(53, 122, 189, 0.4);
    }

    img {
        display: block;
        margin: 0 auto 20px;
        width: 100px;
        height: 100px;
    }

    #particles-js {
        position: absolute;
        width: 50%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
    }

    /* Smooth modal fade-in animation */
    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, -25%);
        transform: translate(0, -25%);
        -webkit-transition: transform 0.3s ease-out;
        transition: transform 0.3s ease-out;
    }

    .modal.in .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }
</style>

</head>

<body>

    <!-- Particle Background -->


    <!-- Split Screen Layout -->
    <div class="login-container">
    <!-- <div id="particles-js"></div> -->
  
        <!-- Left Section: Login Form -->
        <div class="left-section">
            
        <div class="title">
                        <h1>SI PENA</h1>
                        <h2>Sistem Informasi Persediaan Bengkulu Punya</h2>
                    </div>
            <div class="login-box">
                <div class="login-box-body">
                    <!-- Title and Subtitle -->
                    
                    <h3 class="text-center">Balai POM di Bengkulu</h3>
                    <img src="gambar/pom.png" alt="POM Logo">
                    <form method="post">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="NIP" name="id_user" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="submit" class="btn btn-primary btn-block btn-flat pull-right"
                                    value="Login" name="login" />
                            </div>
                        </div>
                    </form>
                    <?= $err ?>
                </div>
            </div>
         
        </div>
       
        <!-- Right Section: Empty (can add more content if needed) -->
       
   

   <div id="welcomeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Selamat Datang!</h4>
                </div>
                <div class="modal-body">
                    <p>Selamat datang di SI PENA Sistem Informasi Persediaan Bengkulu Punyaa</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="assets/plugins/jQuery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Particle.js Library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- Initialize Particle Background -->
    <!-- <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    </script> -->
 <script type="text/javascript">
        $(document).ready(function() {
            // Cek apakah pop-up sudah pernah ditampilkan dalam session ini
            if (!sessionStorage.getItem('welcomeShown')) {
                // Tampilkan modal pop-up
                $('#welcomeModal').modal('show');
                // Tandai bahwa pop-up sudah ditampilkan
                sessionStorage.setItem('welcomeShown', 'true');
            }
        });
    </script>
</body>

</html>
