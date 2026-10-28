<?php
/**
 * Koneksi database + bootstrap.
 * Kredensial dibaca dari config.php (tidak ikut git). Lihat config.example.php.
 */
require_once __DIR__ . '/auth.php';

// Halaman parsial memanggil file ini berulang; cukup sekali per request.
if (defined('SIPENA_BOOT')) {
    return;
}
define('SIPENA_BOOT', true);

mysqli_report(MYSQLI_REPORT_OFF); // perilaku sama di PHP 7.4 dan 8.x
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '0');

$cfgFile = __DIR__ . '/../config.php';
if (!is_file($cfgFile)) {
    http_response_code(500);
    exit('Konfigurasi belum dibuat. Salin config.example.php menjadi config.php lalu isi.');
}
$config = require $cfgFile;

$koneksi = @mysqli_connect(
    $config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']
);
if (!$koneksi) {
    error_log('SI PENA: koneksi database gagal - ' . mysqli_connect_error());
    http_response_code(500);
    exit('Koneksi database gagal.');
}
mysqli_set_charset($koneksi, 'utf8mb4');

/**
 * Lapis pengaman input: semua string $_GET/$_POST di-escape untuk SQL.
 * Salinan asli ada di $RAW_GET / $RAW_POST (pakai untuk password dan
 * untuk query yang sudah memakai prepared statement).
 */
if (!function_exists('sipena_escape_array')) {
    function sipena_escape_array($data, $db)
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = sipena_escape_array($v, $db);
            } elseif (is_string($v)) {
                $data[$k] = mysqli_real_escape_string($db, $v);
            }
        }
        return $data;
    }
}
$RAW_GET  = $_GET;
$RAW_POST = $_POST;
$_GET     = sipena_escape_array($_GET, $koneksi);
$_POST    = sipena_escape_array($_POST, $koneksi);
$_REQUEST = array_merge($_GET, $_POST);
