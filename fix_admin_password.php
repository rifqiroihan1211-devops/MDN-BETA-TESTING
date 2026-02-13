<?php
/**
 * MDN Admin - Database Password Fixer
 * Script ini akan otomatis memperbaiki password admin di database
 * 
 * CARA PAKAI:
 * 1. Upload file ini ke server (folder yang sama dengan config.php)
 * 2. Buka di browser: http://your-domain.com/fix_admin_password.php
 * 3. Password akan otomatis diperbaiki
 * 4. HAPUS file ini setelah selesai untuk keamanan!
 */

// Load config
require_once 'config.php';

// Password baru yang akan diset
$new_password = 'admin123';

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Fix Admin Password - MDN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #0d3d28 0%, #1a5f3f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #1a5f3f;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .status {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .credentials {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .credentials h3 {
            color: #1a5f3f;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .cred-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .cred-label {
            font-weight: 600;
            color: #495057;
        }
        .cred-value {
            font-family: monospace;
            color: #1a5f3f;
            font-weight: bold;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .warning strong {
            display: block;
            margin-bottom: 5px;
        }
        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            color: #e83e8c;
        }
    </style>
</head>
<body>
    <div class='container'>";

echo "<h1>🔧 Fix Admin Password</h1>";
echo "<p class='subtitle'>Memperbaiki password admin di database MDN</p>";

try {
    // Koneksi ke database
    $db = Database::getInstance()->getConnection();
    
    echo "<div class='status info'>⏳ Memproses... Sedang generate hash password baru</div>";
    
    // Generate hash password baru
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    echo "<div class='status info'>⏳ Hash berhasil dibuat. Mengupdate database...</div>";
    
    // Update password untuk admin
    $stmt = $db->prepare("UPDATE admins SET password = ? WHERE username = 'admin'");
    $result_admin = $stmt->execute([$password_hash]);
    
    // Update password untuk superadmin
    $stmt = $db->prepare("UPDATE admins SET password = ? WHERE username = 'superadmin'");
    $result_superadmin = $stmt->execute([$password_hash]);
    
    // Cek hasil
    if ($result_admin && $result_superadmin) {
        echo "<div class='status success'>✅ <strong>PASSWORD BERHASIL DIPERBAIKI!</strong></div>";
        
        echo "<div class='credentials'>";
        echo "<h3>📋 Kredensial Login</h3>";
        
        echo "<div class='cred-item'>";
        echo "<span class='cred-label'>Username:</span>";
        echo "<span class='cred-value'>admin</span>";
        echo "</div>";
        
        echo "<div class='cred-item'>";
        echo "<span class='cred-label'>Password:</span>";
        echo "<span class='cred-value'>{$new_password}</span>";
        echo "</div>";
        
        echo "<hr style='margin: 15px 0; border: none; border-top: 1px solid #dee2e6;'>";
        
        echo "<div class='cred-item'>";
        echo "<span class='cred-label'>Username:</span>";
        echo "<span class='cred-value'>superadmin</span>";
        echo "</div>";
        
        echo "<div class='cred-item'>";
        echo "<span class='cred-label'>Password:</span>";
        echo "<span class='cred-value'>{$new_password}</span>";
        echo "</div>";
        
        echo "</div>";
        
        echo "<div class='warning'>";
        echo "<strong>⚠️ PENTING - UNTUK KEAMANAN:</strong>";
        echo "1. SEGERA HAPUS file <code>fix_admin_password.php</code> ini dari server!<br>";
        echo "2. Login ke admin panel dan ubah password Anda<br>";
        echo "3. Jangan biarkan file ini tetap ada di server";
        echo "</div>";
        
        // Verifikasi
        $stmt = $db->prepare("SELECT username, full_name FROM admins WHERE username IN ('admin', 'superadmin')");
        $stmt->execute();
        $users = $stmt->fetchAll();
        
        echo "<div class='status success' style='margin-top: 20px;'>";
        echo "✓ Verifikasi: " . count($users) . " akun admin berhasil diupdate<br>";
        echo "✓ Hash baru: " . substr($password_hash, 0, 30) . "...<br>";
        echo "✓ Silakan login di: <a href='admin/login.php' style='color: #1a5f3f; font-weight: bold;'>Admin Login</a>";
        echo "</div>";
        
    } else {
        echo "<div class='status error'>❌ Gagal update password. Silakan cek koneksi database.</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='status error'>";
    echo "❌ <strong>ERROR:</strong><br>";
    echo "Pesan: " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "Pastikan file config.php dan koneksi database sudah benar.";
    echo "</div>";
}

echo "    </div>
</body>
</html>";
?>
