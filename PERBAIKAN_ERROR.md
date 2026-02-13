# PERBAIKAN ERROR - MDN Website

## Tanggal: 11 Februari 2026

### Error yang Diperbaiki:

#### 1. Error di admin/offices.php (Line 80)
**Error Message:**
```
Warning: Undefined array key "image" in /home/apaco318/public_html/mdn.apacoba.xyz/admin/offices.php on line 80
```

**Penyebab:**
- Kolom 'image' dalam array $office tidak selalu tersedia atau bernilai NULL
- PHP 8+ lebih strict dalam menangani undefined array keys

**Solusi:**
- Menambahkan pengecekan `isset()` dan `!empty()` sebelum mengakses array key
- Menggunakan conditional yang lebih aman:
```php
<?php if (isset($office['image']) && !empty($office['image'])): ?>
    <img src="<?= UPLOAD_URL . $office['image'] ?>">
<?php else: ?>
    <div>No Image</div>
<?php endif; ?>
```

#### 2. Error di index.php (Line 379, 381, 383) - Menu Layanan
**Error Message:**
```
Warning: Undefined array key "title" in /home/apaco318/public_html/mdn.apacoba.xyz/index.php on line 379
Deprecated: htmlspecialchars(): Passing null to parameter #1 ($string) of type string is deprecated
```

**Catatan:**
- Error ini tidak ditemukan di versi index.php saat ini karena konten layanan di-hardcode
- Jika ada versi yang menggunakan database dinamis untuk layanan, error ini bisa terjadi

**Solusi Preventif:**
- Menambahkan helper functions di config.php:
  - `array_get($array, $key, $default)` - untuk safely get array value
  - `escape_array_get($array, $key, $default)` - untuk get dan escape array value

#### 3. Masalah Gambar Tidak Bisa Diload
**Penyebab:**
- BASE_URL menggunakan hardcoded localhost
- Tidak sesuai dengan domain production (mdn.apacoba.xyz)

**Solusi:**
- Mengubah BASE_URL menjadi auto-detect berdasarkan HTTP_HOST
- Menambahkan .htaccess untuk mengatur akses ke folder uploads
- Membuat .htaccess di folder uploads untuk security

### File yang Dimodifikasi:

1. **config.php**
   - BASE_URL sekarang auto-detect (tidak hardcoded)
   - Menambahkan helper functions untuk menghindari undefined array key errors
   - Lebih flexible untuk berbagai environment (localhost, staging, production)

2. **admin/offices.php**
   - Perbaikan pengecekan kolom 'image' pada line 80
   - Menggunakan isset() dan !empty() untuk validasi

3. **.htaccess** (New)
   - Konfigurasi Apache untuk website
   - Security headers
   - Compression dan caching
   - Melindungi file sensitif

4. **uploads/.htaccess** (New)
   - Melindungi folder uploads dari eksekusi PHP
   - Mengizinkan hanya file tertentu (images, documents)
   - Mencegah directory listing

### Cara Menggunakan:

1. **Upload semua file ke server**
   ```
   - Extract perbaikan_3.zip
   - Upload ke folder root website
   ```

2. **Pastikan permissions folder uploads**
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/*
   ```

3. **Cek konfigurasi BASE_URL**
   - BASE_URL sekarang auto-detect
   - Jika masih ada masalah, periksa di config.php line 27-38

4. **Test upload gambar**
   - Login ke admin panel
   - Coba upload gambar di menu Kantor
   - Pastikan gambar muncul dengan benar

### Catatan Penting:

1. **PHP Version:**
   - Kode telah disesuaikan untuk PHP 8.0+
   - Menggunakan strict type checking

2. **Database:**
   - Pastikan tabel 'offices' memiliki kolom 'image'
   - Run query berikut jika kolom belum ada:
   ```sql
   ALTER TABLE offices ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER working_hours;
   ```

3. **Security:**
   - File .htaccess telah dikonfigurasi untuk keamanan
   - Folder uploads dilindungi dari eksekusi PHP
   - Pastikan mod_rewrite Apache aktif

### Testing:

1. **Test Admin Panel:**
   - Buka: http://mdn.apacoba.xyz/admin/
   - Login dengan credentials
   - Buka menu "Manajemen Kantor"
   - Upload gambar dan simpan
   - Pastikan tidak ada error

2. **Test Frontend:**
   - Buka: http://mdn.apacoba.xyz/
   - Scroll ke section "Layanan"
   - Pastikan semua content muncul

3. **Test Image Loading:**
   - Periksa browser console (F12)
   - Pastikan tidak ada 404 error untuk images
   - Periksa Network tab untuk memastikan images loaded

### Troubleshooting:

**Jika gambar masih tidak muncul:**
1. Periksa permissions folder uploads (harus 755)
2. Periksa BASE_URL di config.php
3. Periksa .htaccess file ada dan readable
4. Periksa error_log Apache untuk detail error

**Jika masih ada undefined array key error:**
1. Gunakan helper function array_get() atau escape_array_get()
2. Tambahkan isset() check sebelum akses array
3. Set default value untuk array yang mungkin kosong

### Contact Support:
Jika masih ada masalah, hubungi developer dengan informasi:
- Error message lengkap
- PHP version
- Apache version
- Screenshot error jika memungkinkan
