<?php
/**
 * MDN - Masjid Digital Network
 * Configuration File
 * 
 * File ini berisi konfigurasi database dan konstanta aplikasi.
 * Untuk saat ini, file ini belum digunakan di landing page.
 * File ini akan digunakan untuk development admin panel di masa depan.
 */

// Error Reporting (Development Mode)
// Ubah ke 0 saat production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Database Configuration
// PENTING: Ganti dengan kredensial database Anda
define('DB_HOST', 'localhost');
define('DB_NAME', 'apaco318_MDN');
define('DB_USER', 'apaco318_admin');
define('DB_PASS', 'adminlagi123@#');
define('DB_CHARSET', 'utf8mb4');

// Base URL
// Ganti dengan URL website Anda
define('BASE_URL', 'http://localhost/mdn-website/');
define('ADMIN_URL', BASE_URL . 'admin/');

// Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Security
define('HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_NAME', 'MDN_SESSION');
define('CSRF_TOKEN_NAME', 'mdn_csrf_token');

// Site Settings
define('SITE_NAME', 'MDN - Masjid Digital Network');
define('SITE_TAGLINE', 'Platform Digital Terpadu untuk Masjid Indonesia');
define('SITE_DESCRIPTION', 'Masjid Digital Network adalah platform layanan digital terpadu untuk transformasi masjid Indonesia');
define('SITE_KEYWORDS', 'masjid digital, manajemen masjid, kas masjid, platform masjid, digitalisasi masjid');

// Contact Info
define('CONTACT_EMAIL', 'info@mdn.id');
define('CONTACT_PHONE', '+62 812-3456-7890');
define('CONTACT_ADDRESS', 'Jakarta, Indonesia');

// Social Media
define('FACEBOOK_URL', '#');
define('INSTAGRAM_URL', '#');
define('TWITTER_URL', '#');
define('YOUTUBE_URL', '#');

// Pagination
define('ITEMS_PER_PAGE', 10);

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

/**
 * Database Connection Class
 * Menggunakan PDO untuk keamanan
 */
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserializing
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Helper Functions
 */

/**
 * Sanitize input
 */
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Redirect function
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        return false;
    }
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Upload file helper
 */
function upload_file($file, $folder = '') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File terlalu besar'];
    }
    
    // Check file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return ['success' => false, 'message' => 'Format file tidak diizinkan'];
    }
    
    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $ext;
    $upload_path = UPLOAD_DIR . $folder;
    
    // Create folder if not exists
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0755, true);
    }
    
    $destination = $upload_path . '/' . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $folder . '/' . $filename,
            'url' => UPLOAD_URL . $folder . '/' . $filename
        ];
    }
    
    return ['success' => false, 'message' => 'Gagal meng-upload file'];
}

/**
 * Delete file helper
 */
function delete_file($path) {
    $full_path = UPLOAD_DIR . $path;
    if (file_exists($full_path)) {
        return unlink($full_path);
    }
    return false;
}

/**
 * Format date Indonesia
 */
function format_date_id($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $tanggal = date('d', $timestamp);
    $bulan_idx = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    
    return $tanggal . ' ' . $bulan[$bulan_idx] . ' ' . $tahun;
}

/**
 * Get setting from database
 */
function get_setting($key, $default = '') {
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        
        return $result ? $result['setting_value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Set setting to database
 */
function set_setting($key, $value, $admin_id = null) {
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO site_settings (setting_key, setting_value, updated_by) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = ?, updated_by = ?
        ");
        return $stmt->execute([$key, $value, $admin_id, $value, $admin_id]);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Log activity
 */
function log_activity($admin_id, $action, $table_name = null, $record_id = null, $old_value = null, $new_value = null) {
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO activity_logs (admin_id, action, table_name, record_id, old_value, new_value, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        return $stmt->execute([
            $admin_id, 
            $action, 
            $table_name, 
            $record_id, 
            $old_value ? json_encode($old_value) : null,
            $new_value ? json_encode($new_value) : null,
            $ip,
            $user_agent
        ]);
    } catch (Exception $e) {
        return false;
    }
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

/**
 * NOTE:
 * File ini belum digunakan di landing page saat ini.
 * File ini akan digunakan untuk development:
 * 1. Admin panel
 * 2. Slider management
 * 3. Content management
 * 4. Contact form handler
 * 5. Dan fitur-fitur lainnya
 * 
 * Untuk menggunakan file ini:
 * 1. Buat database menggunakan database.sql
 * 2. Update kredensial database di atas
 * 3. Include file ini di halaman yang membutuhkan: require_once 'config.php';
 */
?>