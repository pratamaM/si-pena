# SI PENA

Sistem Informasi Permintaan dan Persetujuan Barang (persediaan) - Balai POM di Bengkulu.

Unit (instansi) mengajukan permintaan barang; bendahara mengelola stok, pengajuan,
pemasukan/pengeluaran, laporan, dan mencetak SBBK.

## Peran
| Level       | Folder       | Fungsi                                             |
|-------------|--------------|----------------------------------------------------|
| `instansi`  | `instansi/`  | Buat & pantau permintaan, verifikasi katim, rating |
| `bendahara` | `bendahara/` | Stok, pengajuan, laporan, kelola user              |

## Pasang
1. Buat database MySQL, impor `database/schema.sql` (struktur saja, tanpa data).
2. Jalankan `database/migrations_001_password_hash.sql`.
3. Salin `config.example.php` menjadi `config.php`, isi kredensial DB (dan token Fonnte jika dipakai).
4. Upload ke server PHP (disarankan 7.4+). Buka `index.php`, login dengan NIP.

`config.php` tidak boleh masuk git.

## Keamanan
- Semua halaman dijaga `require_level()` (`fungsi/auth.php`).
- Login memakai prepared statement, token CSRF, pembatasan percobaan, dan sesi aman.
- Password disimpan bcrypt; hash md5 lama di-upgrade otomatis saat login.
- Input `$_GET/$_POST` di-escape global di `fungsi/koneksi.php` (lapis darurat);
  kode baru sebaiknya memakai prepared statement.

## Catatan pengembangan
Berbasis aplikasi "Permintaan dan Persetujuan Material Teknik" (c) 2017 Slamet Riky,
lisensi [GPL-3.0](http://www.gnu.org/licenses/gpl-3.0.html). Turunannya tetap GPL-3.0.
