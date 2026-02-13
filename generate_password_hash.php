<?php
/**
 * Password Hash Generator untuk MDN Admin
 * File ini akan generate hash password yang benar untuk database
 */

// Password yang akan di-hash
$passwords = [
    'admin123' => 'Password default untuk superadmin dan admin',
    'admin'    => 'Password alternatif untuk admin'
];

echo "========================================\n";
echo "MDN Admin - Password Hash Generator\n";
echo "========================================\n\n";

foreach ($passwords as $password => $description) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Password: {$password}\n";
    echo "Deskripsi: {$description}\n";
    echo "Hash: {$hash}\n";
    echo "----------------------------------------\n\n";
}

echo "Gunakan hash di atas untuk UPDATE database:\n\n";
echo "UPDATE admins SET password = 'HASH_DISINI' WHERE username = 'admin';\n";
echo "UPDATE admins SET password = 'HASH_DISINI' WHERE username = 'superadmin';\n\n";

echo "Atau jalankan query ini langsung:\n\n";

$hash_admin123 = password_hash('admin123', PASSWORD_DEFAULT);

echo "-- Set password 'admin123' untuk kedua user\n";
echo "UPDATE admins SET password = '{$hash_admin123}' WHERE username IN ('admin', 'superadmin');\n\n";

echo "========================================\n";
echo "SELESAI!\n";
echo "========================================\n";
?>
