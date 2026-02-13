# 🔧 Panduan Perbaikan Login Admin MDN

## 🚨 MASALAH
Password di database menggunakan hash yang salah, sehingga login selalu gagal meskipun username dan password sudah benar.

## ✅ SOLUSI - 3 CARA

### 📌 CARA 1: Otomatis dengan PHP Script (PALING MUDAH)

1. **Upload file `fix_admin_password.php` ke server** (folder yang sama dengan config.php)
2. **Buka di browser**: `http://your-domain.com/fix_admin_password.php`
3. **Script akan otomatis:**
   - Generate hash password baru
   - Update database
   - Menampilkan kredensial login
4. **PENTING:** Hapus file `fix_admin_password.php` setelah selesai!

**Kredensial Login Setelah Fix:**
- Username: `admin` atau `superadmin`
- Password: `admin123`

---

### 📌 CARA 2: Manual dengan SQL Query

1. **Generate hash password** terlebih dahulu dengan menjalankan:
   ```bash
   php generate_password_hash.php
   ```

2. **Copy hash** yang dihasilkan

3. **Jalankan query SQL** di phpMyAdmin atau MySQL client:
   ```sql
   UPDATE admins 
   SET password = 'HASH_YANG_SUDAH_DIGENERATE' 
   WHERE username IN ('admin', 'superadmin');
   ```

---

### 📌 CARA 3: Import Database Baru (Jika Fresh Install)

1. **Backup database lama** (jika ada data penting)
2. **Import** file `database-fixed.sql`
3. **Edit hash password** di line 33-34 dengan hash yang di-generate dari `generate_password_hash.php`
4. **Re-import database**

---

## 🔐 KREDENSIAL DEFAULT

Setelah perbaikan selesai:

| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | Admin |
| superadmin | admin123 | Super Admin |

---

## ⚠️ CATATAN KEAMANAN

1. **SEGERA ubah password** setelah berhasil login
2. **Hapus file fix script** dari server
3. **Jangan gunakan password default** untuk production

---

## 🧪 TESTING

Test login dengan:
1. Buka: `http://your-domain.com/admin/login.php`
2. Username: `admin`
3. Password: `admin123`
4. Klik "Login Sekarang"

Jika berhasil, Anda akan masuk ke dashboard admin.

---

## 📞 TROUBLESHOOTING

### Login masih gagal?

**Cek koneksi database:**
- Pastikan file `config.php` memiliki kredensial database yang benar
- Test koneksi database dengan membuka halaman lain

**Cek table admins:**
```sql
SELECT username, email, is_active FROM admins;
```

**Pastikan akun aktif:**
```sql
UPDATE admins SET is_active = 1 WHERE username IN ('admin', 'superadmin');
```

**Reset ulang password:**
```sql
-- Generate hash baru dengan PHP
-- php -r "echo password_hash('admin123', PASSWORD_DEFAULT);"
-- Kemudian update dengan hash tersebut
UPDATE admins SET password = 'HASH_BARU' WHERE username = 'admin';
```

---

## 📁 FILE YANG DISERTAKAN

1. **fix_admin_password.php** - Script otomatis fix password
2. **generate_password_hash.php** - Generator hash password
3. **database-fixed.sql** - Database schema yang sudah diperbaiki
4. **PERBAIKAN_LOGIN.md** - Dokumentasi ini

---

## ✨ SETELAH LOGIN BERHASIL

1. Masuk ke menu **Admin Management**
2. Edit profil admin Anda
3. **Ganti password** dengan yang lebih aman
4. Simpan perubahan

---

**🎉 Selamat! Login admin sudah diperbaiki.**
