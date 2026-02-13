<?php
/**
 * MDN Admin - Dashboard
 */
define('ADMIN_PAGE', true);
$page_title = 'Dashboard';

require_once '../config.php';
require_once 'includes/header.php';

// Get statistics
try {
    $db = Database::getInstance()->getConnection();
    
    // Get stats
    $stats = $db->query("SELECT * FROM admin_statistics")->fetch();
    
    // Get recent messages
    $recent_messages = $db->query("
        SELECT * FROM contact_messages 
        ORDER BY created_at DESC 
        LIMIT 5
    ")->fetchAll();
    
    // Get recent activity
    $recent_activities = $db->query("
        SELECT al.*, a.full_name 
        FROM activity_logs al
        LEFT JOIN admins a ON al.admin_id = a.admin_id
        ORDER BY al.created_at DESC 
        LIMIT 10
    ")->fetchAll();
    
} catch (Exception $e) {
    $stats = null;
    $recent_messages = [];
    $recent_activities = [];
}
?>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-header">
            <div class="stat-icon">🖼️</div>
        </div>
        <div class="stat-value"><?= $stats['total_sliders'] ?? 0 ?></div>
        <div class="stat-label">Total Slider</div>
    </div>
    
    <div class="stat-card secondary">
        <div class="stat-header">
            <div class="stat-icon">🛠️</div>
        </div>
        <div class="stat-value"><?= $stats['total_services'] ?? 0 ?></div>
        <div class="stat-label">Layanan Aktif</div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon">🏢</div>
        </div>
        <div class="stat-value"><?= $stats['total_offices'] ?? 0 ?></div>
        <div class="stat-label">Kantor</div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon">✉️</div>
        </div>
        <div class="stat-value"><?= $stats['unread_messages'] ?? 0 ?></div>
        <div class="stat-label">Pesan Baru</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Messages -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pesan Terbaru</h3>
            <a href="messages.php" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (empty($recent_messages)): ?>
                <div style="padding: 40px; text-align: center; color: #999;">
                    Belum ada pesan
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Subjek</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_messages as $msg): ?>
                            <tr>
                                <td><?= htmlspecialchars($msg['name']) ?></td>
                                <td><?= htmlspecialchars($msg['subject']) ?></td>
                                <td>
                                    <?php
                                    $badge_class = 'badge-primary';
                                    $status_text = 'Baru';
                                    if ($msg['status'] === 'read') {
                                        $badge_class = 'badge-warning';
                                        $status_text = 'Dibaca';
                                    } elseif ($msg['status'] === 'replied') {
                                        $badge_class = 'badge-success';
                                        $status_text = 'Dibalas';
                                    }
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $status_text ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($msg['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aksi Cepat</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="sliders.php?action=add" class="btn btn-primary" style="justify-content: center;">
                    <span>➕</span> Tambah Slider
                </a>
                <a href="services.php?action=add" class="btn btn-primary" style="justify-content: center;">
                    <span>➕</span> Tambah Layanan
                </a>
                <a href="offices.php?action=add" class="btn btn-primary" style="justify-content: center;">
                    <span>➕</span> Tambah Kantor
                </a>
                <?php if ($_SESSION['role'] === 'super_admin'): ?>
                <a href="admins.php?action=add" class="btn btn-secondary" style="justify-content: center;">
                    <span>👤</span> Tambah Admin
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($_SESSION['role'] === 'super_admin'): ?>
<!-- Recent Activity -->
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">Aktivitas Terbaru</h3>
        <a href="activity-logs.php" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <?php if (empty($recent_activities)): ?>
            <div style="padding: 40px; text-align: center; color: #999;">
                Belum ada aktivitas
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Aksi</th>
                            <th>Tabel</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_activities as $activity): ?>
                        <tr>
                            <td><?= htmlspecialchars($activity['full_name'] ?? 'Unknown') ?></td>
                            <td><?= htmlspecialchars($activity['action']) ?></td>
                            <td><?= htmlspecialchars($activity['table_name'] ?? '-') ?></td>
                            <td><?= date('d M Y H:i', strtotime($activity['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
