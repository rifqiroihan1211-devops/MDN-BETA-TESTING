<?php
/**
 * MDN Admin - Login Page
 */
require_once '../config.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect(ADMIN_URL . 'index.php');
}

$error = '';
$success = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi';
    } else {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM admins WHERE (username = ? OR email = ?) AND is_active = 1");
            $stmt->execute([$username, $username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                // Set session
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['full_name'] = $admin['full_name'];
                $_SESSION['role'] = $admin['role'];
                $_SESSION['avatar'] = $admin['avatar'];
                
                // Update last login
                $stmt = $db->prepare("UPDATE admins SET last_login = NOW() WHERE admin_id = ?");
                $stmt->execute([$admin['admin_id']]);
                
                // Log activity
                log_activity($admin['admin_id'], 'login', 'admins', $admin['admin_id']);
                
                // Set remember me cookie
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/');
                }
                
                redirect(ADMIN_URL . 'index.php');
            } else {
                $error = 'Username atau password salah';
            }
        } catch (Exception $e) {
            $error = 'Terjadi kesalahan sistem';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MDN Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0d3d28 0%, #1a5f3f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .login-left {
            background: linear-gradient(135deg, #1a5f3f 0%, #0d3d28 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 700;
        }
        
        .login-left h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .login-left p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .features {
            margin-top: 40px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .login-right {
            padding: 60px 40px;
        }
        
        .login-form h3 {
            font-size: 24px;
            font-weight: 700;
            color: #1a5f3f;
            margin-bottom: 8px;
        }
        
        .login-form .subtitle {
            color: #666;
            margin-bottom: 32px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #1a5f3f;
            box-shadow: 0 0 0 4px rgba(26, 95, 63, 0.1);
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
        
        .forgot-password {
            font-size: 14px;
            color: #1a5f3f;
            text-decoration: none;
            font-weight: 600;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a5f3f 0%, #0d3d28 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 95, 63, 0.3);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .features {
                display: none;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo">
                <div class="logo-icon">🕌</div>
                <div class="logo-text">MDN</div>
            </div>
            <h2>Selamat Datang di<br>Admin Dashboard</h2>
            <p>Platform manajemen konten untuk Masjid Digital Network</p>
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">📊</div>
                    <div>Kelola Konten Website</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🖼️</div>
                    <div>Manajemen Slider</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⚙️</div>
                    <div>Pengaturan Lengkap</div>
                </div>
            </div>
        </div>
        
        <div class="login-right">
            <form method="POST" class="login-form">
                <h3>Login Admin</h3>
                <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
                
                <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="username">Username atau Email</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>
                
                <button type="submit" class="btn-login">Login Sekarang</button>
            </form>
        </div>
    </div>
</body>
</html>
