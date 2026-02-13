<?php
/**
 * MDN Admin - Hero Section Settings (Super Admin Only)
 */
define('ADMIN_PAGE', true);
$page_title = 'Pengaturan Hero Section';

require_once '../config.php';

// Check super admin
if ($_SESSION['role'] !== 'super_admin') {
    die('Access denied. Super admin only.');
}

$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'hero_title_line1' => clean_input($_POST['hero_title_line1']),
        'hero_title_line2' => clean_input($_POST['hero_title_line2']),
        'hero_subtitle' => clean_input($_POST['hero_subtitle']),
        'hero_description' => clean_input($_POST['hero_description']),
        'hero_stat1_number' => clean_input($_POST['hero_stat1_number']),
        'hero_stat1_label' => clean_input($_POST['hero_stat1_label']),
        'hero_stat2_number' => clean_input($_POST['hero_stat2_number']),
        'hero_stat2_label' => clean_input($_POST['hero_stat2_label']),
        'hero_stat3_number' => clean_input($_POST['hero_stat3_number']),
        'hero_stat3_label' => clean_input($_POST['hero_stat3_label']),
    ];
    
    foreach ($settings as $key => $value) {
        set_setting($key, $value, $_SESSION['admin_id']);
    }
    
    log_activity($_SESSION['admin_id'], 'update', 'site_settings', null, null, $settings);
    $success = 'Pengaturan hero section berhasil diupdate';
}

// Get current settings
$hero_title_line1 = get_setting('hero_title_line1', 'Dari Jamaah,');
$hero_title_line2 = get_setting('hero_title_line2', 'Untuk Jamaah');
$hero_subtitle = get_setting('hero_subtitle', 'Digitalisasi Masjid yang Aman dan Transparan');
$hero_description = get_setting('hero_description', 'Masjid Digital Network (MDN) adalah platform layanan digital terpadu yang menghubungkan teknologi modern dengan kebutuhan manajemen masjid di seluruh Indonesia.');
$hero_stat1_number = get_setting('hero_stat1_number', '1000+');
$hero_stat1_label = get_setting('hero_stat1_label', 'Masjid Terdaftar');
$hero_stat2_number = get_setting('hero_stat2_number', '50K+');
$hero_stat2_label = get_setting('hero_stat2_label', 'Jamaah Aktif');
$hero_stat3_number = get_setting('hero_stat3_number', '99.9%');
$hero_stat3_label = get_setting('hero_stat3_label', 'Uptime Server');

require_once 'includes/header.php';
?>

<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengaturan Hero Section</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <h4 style="margin-bottom:16px; color:#1a5f3f;">📝 Judul Utama</h4>
            
            <div class="form-group">
                <label class="form-label">Judul Baris 1 *</label>
                <input type="text" name="hero_title_line1" class="form-control" value="<?= htmlspecialchars($hero_title_line1) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Judul Baris 2 *</label>
                <input type="text" name="hero_title_line2" class="form-control" value="<?= htmlspecialchars($hero_title_line2) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Subtitle *</label>
                <input type="text" name="hero_subtitle" class="form-control" value="<?= htmlspecialchars($hero_subtitle) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi *</label>
                <textarea name="hero_description" class="form-control" rows="3" required><?= htmlspecialchars($hero_description) ?></textarea>
            </div>
            
            <hr style="margin:32px 0; border:none; border-top:2px solid #f0f0f0;">
            
            <h4 style="margin-bottom:16px; color:#1a5f3f;">📊 Statistik (3 Angka)</h4>
            
            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:24px;">
                <div>
                    <h5 style="margin-bottom:12px;">Statistik 1</h5>
                    <div class="form-group">
                        <label class="form-label">Angka *</label>
                        <input type="text" name="hero_stat1_number" class="form-control" value="<?= htmlspecialchars($hero_stat1_number) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Label *</label>
                        <input type="text" name="hero_stat1_label" class="form-control" value="<?= htmlspecialchars($hero_stat1_label) ?>" required>
                    </div>
                </div>
                
                <div>
                    <h5 style="margin-bottom:12px;">Statistik 2</h5>
                    <div class="form-group">
                        <label class="form-label">Angka *</label>
                        <input type="text" name="hero_stat2_number" class="form-control" value="<?= htmlspecialchars($hero_stat2_number) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Label *</label>
                        <input type="text" name="hero_stat2_label" class="form-control" value="<?= htmlspecialchars($hero_stat2_label) ?>" required>
                    </div>
                </div>
                
                <div>
                    <h5 style="margin-bottom:12px;">Statistik 3</h5>
                    <div class="form-group">
                        <label class="form-label">Angka *</label>
                        <input type="text" name="hero_stat3_number" class="form-control" value="<?= htmlspecialchars($hero_stat3_number) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Label *</label>
                        <input type="text" name="hero_stat3_label" class="form-control" value="<?= htmlspecialchars($hero_stat3_label) ?>" required>
                    </div>
                </div>
            </div>
            
            <div style="margin-top:32px;">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<div class="alert alert-info" style="margin-top:24px;">
    <strong>💡 Tips:</strong> Perubahan akan langsung terlihat di landing page setelah disimpan. 
    Klik tombol "Lihat Website" di pojok kanan atas untuk melihat hasilnya.
</div>

<?php require_once 'includes/footer.php'; ?>
