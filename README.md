# MDN - Masjid Digital Network
## Sistem Admin Dashboard & Landing Page

### 📋 Deskripsi
Sistem admin dashboard lengkap untuk mengelola website MDN (Masjid Digital Network) dengan fitur-fitur:
- ✅ Dashboard statistik dan monitoring
- ✅ Manajemen slider gambar untuk semua halaman (kecuali layanan)
- ✅ Manajemen konten landing page (Hero, About, Features, Contact)
- ✅ Manajemen layanan (dapat ditambah/edit/hapus oleh admin)
- ✅ Manajemen kantor (2 kantor: pusat & cabang)
- ✅ Manajemen admin (khusus super admin)
- ✅ Log aktivitas admin
- ✅ Galeri foto
- ✅ FAQ management
- ✅ Inbox pesan dari contact form

---

## 🚀 Instalasi

### 1. Persiapan Server
**Requirements:**
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx dengan mod_rewrite
- Extension PHP: PDO, GD, mbstring, json

### 2. Upload Files
1. Extract file `mdn-admin-system.zip`
2. Upload semua file ke root directory website Anda
3. Pastikan struktur folder seperti ini:
```
/
├── admin/              # Admin dashboard
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── includes/
│   │   ├── header.php
│   │   └── footer.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── sliders.php
│   ├── services.php
│   ├── offices.php
│   ├── admins.php
│   └── ... (file lainnya)
├── css/                # Landing page CSS
├── js/                 # Landing page JS
├── uploads/            # Upload folder
│   ├── sliders/
│   ├── services/
│   ├── offices/
│   └── admins/
├── config.php          # Konfigurasi database
├── database.sql        # Database schema
├── index.php           # Landing page
└── README.md           # File ini
```

### 3. Setup Database

**Langkah 1: Buat Database**
```sql
CREATE DATABASE apaco318_MDN CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Langkah 2: Import Database Schema**
- Buka phpMyAdmin atau MySQL client
- Pilih database `apaco318_MDN`
- Import file `database.sql`
- Atau via command line:
```bash
mysql -u username -p apaco318_MDN < database.sql
```

**Langkah 3: Verifikasi**
Database akan membuat tabel-tabel berikut:
- `admins` - Data admin
- `site_settings` - Pengaturan website
- `sliders` - Slider gambar
- `features` - Fitur produk
- `services` - Layanan yang ditawarkan
- `offices` - Data kantor
- `testimonials` - Testimoni
- `contact_messages` - Pesan dari form kontak
- `activity_logs` - Log aktivitas admin
- `galleries` - Galeri foto
- `faqs` - FAQ

### 4. Konfigurasi

**Edit file `config.php`:**
```php
// Database Configuration
define('DB_HOST', 'localhost');           // Host database Anda
define('DB_NAME', 'apaco318_MDN');        // Nama database
define('DB_USER', 'apaco318_admin');      // Username database
define('DB_PASS', 'adminlagi123@#');      // Password database

// Base URL
define('BASE_URL', 'http://yourdomain.com/');  // URL website Anda
define('ADMIN_URL', BASE_URL . 'admin/');       // URL admin
```

### 5. Set Permissions

Set permission untuk folder uploads:
```bash
chmod 755 uploads/
chmod 755 uploads/sliders/
chmod 755 uploads/services/
chmod 755 uploads/offices/
chmod 755 uploads/admins/
chmod 755 uploads/gallery/
```

---

## 🔐 Login Admin

### Default Credentials

**Super Admin:**
- Username: `superadmin`
- Password: `admin123`
- Email: `superadmin@mdn.id`

**Admin:**
- Username: `admin`
- Password: `admin123`
- Email: `admin@mdn.id`

**⚠️ PENTING:** Segera ganti password default setelah login pertama!

### URL Login
```
http://yourdomain.com/admin/login.php
```

---

## 📱 Fitur-Fitur Admin

### 1. Dashboard
- Statistik real-time (slider, layanan, kantor, pesan)
- Pesan terbaru dari contact form
- Log aktivitas admin (khusus super admin)
- Quick actions untuk akses cepat

### 2. Landing Page Management (Super Admin Only)

#### Hero Section
- Edit judul utama (2 baris)
- Edit subtitle dan deskripsi
- Edit 3 statistik (angka + label)
- Atur call-to-action buttons

#### Slider Gambar
- Tambah/edit/hapus slider
- Upload gambar (max 5MB)
- Atur urutan tampilan
- Pilih section: Hero, About, Features, Contact
- Set slider aktif/non-aktif
- **Note:** Slider TIDAK ditampilkan di section Layanan

#### About Section
- Edit judul dan subtitle
- Edit deskripsi lengkap
- Edit visi dan misi

#### Features
- Tambah/edit/hapus fitur
- Icon emoji
- Deskripsi fitur
- Atur urutan

#### Contact & Social Media
- Edit email, phone, WhatsApp
- Edit alamat
- Edit link social media (Facebook, Instagram, Twitter, YouTube, LinkedIn)

### 3. Konten Management (Semua Admin)

#### Layanan
- Tambah layanan baru
- Edit layanan existing
- Upload gambar layanan
- Atur harga & fitur
- Set featured service
- Hapus layanan
- Atur urutan tampilan

#### Kantor (2 Kantor)
**Kantor Pusat:**
- Nama kantor
- Alamat lengkap
- Kota & provinsi
- Kode pos
- Telepon & email
- Koordinat map (latitude/longitude)
- Jam operasional (JSON format)
- Upload foto kantor

**Kantor Cabang:**
- Same as above

#### Galeri
- Upload foto galeri
- Kategorisasi (event, facility, activity, other)
- Judul & deskripsi
- Atur urutan

#### FAQ
- Tambah pertanyaan & jawaban
- Kategorisasi
- Atur urutan

### 4. Inbox Pesan
- Lihat semua pesan dari contact form
- Status: New, Read, Replied, Archived
- Balas pesan
- Filter by status
- Delete pesan

### 5. Admin Management (Super Admin Only)
- Tambah admin baru
- Edit admin existing
- Atur role (Super Admin / Admin)
- Upload avatar admin
- Aktifkan/nonaktifkan admin
- Lihat last login
- **Note:** Super admin memiliki akses penuh, Admin regular tidak bisa mengelola admin lain

### 6. Activity Logs (Super Admin Only)
- Lihat semua aktivitas admin
- Filter by admin, action, table
- IP address & user agent tracking
- Export logs

---

## 🎨 Customization

### Mengganti Logo
1. Buat logo SVG atau PNG
2. Edit file `admin/includes/header.php` pada bagian logo
3. Atau upload via Media Management (upcoming feature)

### Mengganti Warna
Edit file `admin/assets/css/admin.css`:
```css
:root {
    --primary: #1a5f3f;        /* Warna utama */
    --primary-dark: #0d3d28;   /* Warna gelap */
    --secondary: #d4af37;       /* Warna sekunder */
    /* ... */
}
```

### Menambah Menu Baru
Edit file `admin/includes/header.php`:
```php
<li class="nav-item">
    <a href="menu-baru.php" class="nav-link">
        <span class="nav-icon">🔥</span>
        <span class="nav-text">Menu Baru</span>
    </a>
</li>
```

---

## 📄 Struktur Database

### Tabel Utama

**admins**
- Menyimpan data admin
- Role: super_admin atau admin
- Password di-hash dengan bcrypt

**site_settings**
- Menyimpan semua pengaturan website
- Key-value pairs
- Update via Hero Settings, About Settings, dll

**sliders**
- Slider gambar untuk setiap section
- Section: hero, about, features, contact
- **Tidak untuk section layanan**

**services**
- Layanan yang ditawarkan
- Features disimpan dalam JSON
- Slug auto-generate

**offices**
- Data 2 kantor (pusat & cabang)
- Working hours dalam JSON
- Koordinat untuk Google Maps

**contact_messages**
- Pesan dari contact form
- Status tracking
- Reply feature

**activity_logs**
- Log semua aktivitas admin
- Old value & new value dalam JSON
- IP & User Agent tracking

---

## 🔧 Troubleshooting

### Error: "Access Denied"
- Pastikan sudah login
- Check role permissions
- Clear browser cache

### Error: "Database Connection Failed"
- Periksa kredensial di `config.php`
- Pastikan MySQL service running
- Check database exists

### Upload Gambar Gagal
- Periksa permission folder `uploads/`
- Pastikan ukuran file < 5MB
- Format: JPG, JPEG, PNG, GIF, WEBP only

### Slider Tidak Muncul
- Check slider status = Active
- Periksa section yang dipilih
- Clear cache browser

### Menu Admin Tidak Muncul (Admin Regular)
- Beberapa menu hanya untuk Super Admin:
  - Hero Settings
  - Slider Management
  - About Settings
  - Features
  - Contact Settings
  - Admin Management
  - Activity Logs

---

## 📚 API & Development

### Menambah Field Baru di Settings
```php
// Di database
INSERT INTO site_settings (setting_key, setting_value, setting_type) 
VALUES ('new_field', 'default_value', 'text');

// Di PHP
$value = get_setting('new_field', 'default_value');
set_setting('new_field', 'new_value', $admin_id);
```

### Log Aktivitas
```php
log_activity(
    $admin_id,      // ID admin
    'create',       // Action: create, update, delete, login, logout
    'services',     // Table name
    $service_id,    // Record ID
    null,           // Old value (optional)
    $new_data       // New value (optional)
);
```

### Upload File
```php
$result = upload_file($_FILES['image'], 'sliders');
if ($result['success']) {
    $filename = $result['filename'];
    $path = $result['path'];
    $url = $result['url'];
}
```

---

## 🔒 Security

### Best Practices
1. **Ganti password default** segera setelah instalasi
2. **Backup database** secara berkala
3. **Update PHP** ke versi terbaru
4. **Set strong password** untuk database
5. **Gunakan HTTPS** untuk production
6. **Batasi akses** ke folder `/admin` via .htaccess
7. **Monitor activity logs** secara berkala
8. **Disable error display** di production:
```php
// config.php
error_reporting(0);
ini_set('display_errors', 0);
```

### Recommended .htaccess untuk Admin
```apache
# File: /admin/.htaccess
<Files "*.php">
    Order Deny,Allow
    Deny from all
    Allow from 127.0.0.1
    Allow from YOUR_IP_ADDRESS
</Files>

# Kecuali login.php
<Files "login.php">
    Order Allow,Deny
    Allow from all
</Files>
```

---

## 📞 Support

### Dokumentasi
- Online Docs: Coming soon
- Video Tutorial: Coming soon

### Contact
- Email: info@mdn.id
- Phone: +62 812-3456-7890
- Website: Coming soon

### Issues & Bug Report
Jika menemukan bug atau error:
1. Screenshot error message
2. Catat langkah-langkah reproduksi
3. Kirim ke email support dengan subject "MDN Bug Report"

---

## 📝 Changelog

### Version 1.0.0 (February 2026)
- ✅ Initial release
- ✅ Complete admin dashboard
- ✅ Landing page management
- ✅ Slider management untuk semua section kecuali layanan
- ✅ Service management
- ✅ Office management (2 kantor)
- ✅ Admin management (super admin only)
- ✅ Activity logs
- ✅ Gallery & FAQ
- ✅ Contact inbox

---

## 📄 License

Copyright © 2026 Masjid Digital Network. All rights reserved.

---

## 🙏 Credits

Developed with ❤️ for Indonesian mosques digitalization.

### Technologies Used:
- PHP 7.4+
- MySQL 5.7+
- HTML5 & CSS3
- JavaScript (Vanilla)
- Chart.js for statistics
- Inter Font Family

---

**Happy Coding! 🚀**

Jika ada pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi tim support kami.
