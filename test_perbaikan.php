<?php
/**
 * Test File - Validasi Perbaikan Error
 * File ini untuk testing perbaikan error yang telah dilakukan
 */

// Disable error reporting display (akan disimpan ke log)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$test_results = [];
$all_passed = true;

echo "<!DOCTYPE html>
<html>
<head>
    <title>MDN - Test Perbaikan Error</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; }
        h1 { color: #1a5f3f; }
        .test-item { padding: 15px; margin: 10px 0; border-radius: 8px; border-left: 4px solid; }
        .pass { background: #d4edda; border-color: #28a745; }
        .fail { background: #f8d7da; border-color: #dc3545; }
        .info { background: #d1ecf1; border-color: #17a2b8; }
        .test-title { font-weight: bold; margin-bottom: 5px; }
        .test-detail { font-size: 14px; color: #666; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .summary { padding: 20px; margin: 20px 0; border-radius: 8px; font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
<h1>🔧 MDN - Test Perbaikan Error</h1>
<p><strong>Tanggal Test:</strong> " . date('Y-m-d H:i:s') . "</p>
<hr>
";

// Test 1: Config.php - BASE_URL Auto-detect
echo "<h2>Test 1: BASE_URL Auto-detect</h2>";
require_once 'config.php';

if (defined('BASE_URL')) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $expected_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $is_correct = (strpos(BASE_URL, $expected_host) !== false);
    
    if ($is_correct) {
        echo "<div class='test-item pass'>
            <div class='test-title'>✅ PASS: BASE_URL Auto-detect</div>
            <div class='test-detail'>BASE_URL: <code>" . BASE_URL . "</code></div>
            <div class='test-detail'>Expected Host: <code>" . $expected_host . "</code></div>
        </div>";
        $test_results[] = true;
    } else {
        echo "<div class='test-item fail'>
            <div class='test-title'>❌ FAIL: BASE_URL tidak sesuai</div>
            <div class='test-detail'>BASE_URL: <code>" . BASE_URL . "</code></div>
            <div class='test-detail'>Expected Host: <code>" . $expected_host . "</code></div>
        </div>";
        $test_results[] = false;
        $all_passed = false;
    }
} else {
    echo "<div class='test-item fail'>
        <div class='test-title'>❌ FAIL: BASE_URL tidak terdefinisi</div>
    </div>";
    $test_results[] = false;
    $all_passed = false;
}

// Test 2: Helper Functions
echo "<h2>Test 2: Helper Functions</h2>";

if (function_exists('array_get') && function_exists('escape_array_get')) {
    // Test array_get
    $test_array = ['name' => 'Test', 'value' => 123];
    $result1 = array_get($test_array, 'name', 'default');
    $result2 = array_get($test_array, 'missing', 'default');
    
    $test1_pass = ($result1 === 'Test');
    $test2_pass = ($result2 === 'default');
    
    if ($test1_pass && $test2_pass) {
        echo "<div class='test-item pass'>
            <div class='test-title'>✅ PASS: Helper function array_get()</div>
            <div class='test-detail'>Test 1 (existing key): <code>" . $result1 . "</code> = 'Test' ✓</div>
            <div class='test-detail'>Test 2 (missing key): <code>" . $result2 . "</code> = 'default' ✓</div>
        </div>";
        $test_results[] = true;
    } else {
        echo "<div class='test-item fail'>
            <div class='test-title'>❌ FAIL: Helper function array_get() tidak bekerja dengan benar</div>
        </div>";
        $test_results[] = false;
        $all_passed = false;
    }
    
    // Test escape_array_get
    $test_array2 = ['html' => '<script>alert("xss")</script>'];
    $result3 = escape_array_get($test_array2, 'html', '');
    $result4 = escape_array_get($test_array2, 'missing', 'default');
    
    $test3_pass = (strpos($result3, '&lt;script&gt;') !== false);
    $test4_pass = ($result4 === 'default');
    
    if ($test3_pass && $test4_pass) {
        echo "<div class='test-item pass'>
            <div class='test-title'>✅ PASS: Helper function escape_array_get()</div>
            <div class='test-detail'>HTML escaped correctly ✓</div>
            <div class='test-detail'>Default value works ✓</div>
        </div>";
        $test_results[] = true;
    } else {
        echo "<div class='test-item fail'>
            <div class='test-title'>❌ FAIL: Helper function escape_array_get() tidak bekerja dengan benar</div>
        </div>";
        $test_results[] = false;
        $all_passed = false;
    }
} else {
    echo "<div class='test-item fail'>
        <div class='test-title'>❌ FAIL: Helper functions tidak ditemukan</div>
    </div>";
    $test_results[] = false;
    $all_passed = false;
}

// Test 3: Upload Directory
echo "<h2>Test 3: Upload Directory</h2>";

$upload_dirs = ['uploads', 'uploads/offices', 'uploads/services', 'uploads/sliders', 'uploads/admins', 'uploads/gallery'];
$all_dirs_exist = true;

foreach ($upload_dirs as $dir) {
    if (is_dir($dir)) {
        echo "<div class='test-item pass'>
            <div class='test-title'>✅ Directory exists: <code>$dir</code></div>
            <div class='test-detail'>Writable: " . (is_writable($dir) ? 'Yes ✓' : 'No ⚠️') . "</div>
        </div>";
    } else {
        echo "<div class='test-item fail'>
            <div class='test-title'>❌ Directory missing: <code>$dir</code></div>
        </div>";
        $all_dirs_exist = false;
        $all_passed = false;
    }
}

$test_results[] = $all_dirs_exist;

// Test 4: .htaccess Files
echo "<h2>Test 4: .htaccess Files</h2>";

$htaccess_files = [
    '.htaccess' => 'Root directory',
    'uploads/.htaccess' => 'Uploads directory'
];

$all_htaccess_exist = true;

foreach ($htaccess_files as $file => $location) {
    if (file_exists($file)) {
        echo "<div class='test-item pass'>
            <div class='test-title'>✅ .htaccess exists: <code>$file</code></div>
            <div class='test-detail'>Location: $location</div>
            <div class='test-detail'>Readable: " . (is_readable($file) ? 'Yes ✓' : 'No ⚠️') . "</div>
        </div>";
    } else {
        echo "<div class='test-item fail'>
            <div class='test-title'>❌ .htaccess missing: <code>$file</code></div>
            <div class='test-detail'>Location: $location</div>
        </div>";
        $all_htaccess_exist = false;
        $all_passed = false;
    }
}

$test_results[] = $all_htaccess_exist;

// Test 5: Database Connection (Optional)
echo "<h2>Test 5: Database Connection</h2>";

try {
    $db = Database::getInstance()->getConnection();
    
    echo "<div class='test-item pass'>
        <div class='test-title'>✅ PASS: Database connection successful</div>
        <div class='test-detail'>Database: <code>" . DB_NAME . "</code></div>
    </div>";
    $test_results[] = true;
    
    // Check if offices table exists
    $stmt = $db->query("SHOW TABLES LIKE 'offices'");
    if ($stmt->rowCount() > 0) {
        // Check if image column exists
        $stmt = $db->query("SHOW COLUMNS FROM offices LIKE 'image'");
        if ($stmt->rowCount() > 0) {
            echo "<div class='test-item pass'>
                <div class='test-title'>✅ PASS: Table 'offices' has 'image' column</div>
            </div>";
            $test_results[] = true;
        } else {
            echo "<div class='test-item fail'>
                <div class='test-title'>❌ FAIL: Table 'offices' missing 'image' column</div>
                <div class='test-detail'>Run: <code>ALTER TABLE offices ADD COLUMN image VARCHAR(255) DEFAULT NULL;</code></div>
            </div>";
            $test_results[] = false;
            $all_passed = false;
        }
    } else {
        echo "<div class='test-item info'>
            <div class='test-title'>ℹ️ INFO: Table 'offices' not found</div>
            <div class='test-detail'>Run database.sql to create tables</div>
        </div>";
    }
} catch (Exception $e) {
    echo "<div class='test-item fail'>
        <div class='test-title'>❌ FAIL: Database connection error</div>
        <div class='test-detail'>Error: " . htmlspecialchars($e->getMessage()) . "</div>
    </div>";
    $test_results[] = false;
    $all_passed = false;
}

// Summary
echo "<hr>";
$total_tests = count($test_results);
$passed_tests = array_sum($test_results);
$failed_tests = $total_tests - $passed_tests;

if ($all_passed) {
    echo "<div class='summary' style='background: #d4edda; color: #155724; border: 2px solid #28a745;'>
        ✅ Semua test PASSED! ($passed_tests/$total_tests)
    </div>";
} else {
    echo "<div class='summary' style='background: #f8d7da; color: #721c24; border: 2px solid #dc3545;'>
        ❌ Beberapa test FAILED! ($passed_tests passed, $failed_tests failed dari $total_tests total)
    </div>";
}

echo "<div class='test-item info'>
    <div class='test-title'>📝 Catatan</div>
    <div class='test-detail'>
        - Jika ada test yang failed, periksa PERBAIKAN_ERROR.md untuk solusi<br>
        - Pastikan permissions folder uploads: <code>chmod 755 uploads/</code><br>
        - Pastikan .htaccess files ada dan readable<br>
        - Untuk production, gunakan HTTPS dan sesuaikan konfigurasi
    </div>
</div>";

echo "</body></html>";
?>
