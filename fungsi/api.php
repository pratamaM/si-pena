<?php
/**
 * Notifikasi WhatsApp via Fonnte. Token & nomor tujuan dari config.php.
 * Jika belum dikonfigurasi, notifikasi dilewati (tidak error).
 */
global $config;
if (!empty($config['fonnte_token']) && !empty($config['notif_target'])) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL            => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => array(
            'target'  => $config['notif_target'],
            'message' => "Notif SI PENA :\nAda Permintaan Barang yang Masuk",
        ),
        CURLOPT_HTTPHEADER     => array('Authorization: ' . $config['fonnte_token']),
    ));
    curl_exec($curl);
    if (curl_errno($curl)) {
        error_log('SI PENA: notifikasi WA gagal - ' . curl_error($curl));
    }
    curl_close($curl);
}
