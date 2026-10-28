<?php
/**
 * Sesi + penjaga akses (satu tempat untuk semua halaman).
 * Dipakai lewat: require_once __DIR__ . '/../fungsi/auth.php'; require_level('instansi');
 */

if (session_status() === PHP_SESSION_NONE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_name('SIPENASESS');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/** Tolak akses: 401 untuk AJAX, selain itu redirect ke halaman login. */
function tolak_akses($login = '../index.php')
{
    $ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if ($ajax) {
        http_response_code(401);
        exit('Sesi habis. Silakan login ulang.');
    }
    if (!headers_sent()) {
        header('Location: ' . $login);
    } else {
        echo '<script>location.href=' . json_encode($login) . ';</script>';
    }
    exit;
}

/** Wajib login dengan salah satu level yang diizinkan. */
function require_level($levels, $login = '../index.php')
{
    $levels = (array) $levels;
    $level  = isset($_SESSION['level']) ? $_SESSION['level'] : '';
    if (empty($_SESSION['login']) || !in_array($level, $levels, true)) {
        tolak_akses($login);
    }
}

/** Verifikasi password: hash baru (bcrypt) atau md5 lama (akan di-upgrade). */
function cek_password($plain, $tersimpan, &$perlu_upgrade)
{
    $perlu_upgrade = false;
    $tersimpan = (string) $tersimpan;
    if (preg_match('/^[a-f0-9]{32}$/i', $tersimpan)) {
        $ok = hash_equals(strtolower($tersimpan), md5($plain));
        $perlu_upgrade = $ok;
        return $ok;
    }
    $ok = password_verify($plain, $tersimpan);
    if ($ok && password_needs_rehash($tersimpan, PASSWORD_DEFAULT)) {
        $perlu_upgrade = true;
    }
    return $ok;
}
