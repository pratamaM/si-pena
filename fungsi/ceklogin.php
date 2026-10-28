<?php
// Kalau sudah login, arahkan ke dashboard sesuai level.
if (!empty($_SESSION['login'])) {
    if ($_SESSION['level'] === 'instansi') {
        header('Location: instansi/index.php');
        exit;
    } elseif ($_SESSION['level'] === 'bendahara') {
        header('Location: bendahara/index.php');
        exit;
    }
}
