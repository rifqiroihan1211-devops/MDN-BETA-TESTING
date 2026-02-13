<?php
/**
 * MDN Admin - Services Management
 */
define('ADMIN_PAGE', true);
$page_title = 'Manajemen Layanan';

require_once '../config.php';
$db = Database::getInstance()->getConnection();
$success = $error = '';

// Handle form submission  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' || $action === 'edit') {
        $service_name = clean_input($_POST['service_name']);
        $service_slug = clean_input($_POST['service_slug']);
        $short_description = clean_input($_POST['short_description']);
        $full_description = clean_input($_POST['full_description']);
        $icon = clean_input($_POST['icon']);
        $price_info = clean_input($_POST['price_info']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Features as JSON
        $features = [];
        if (!empty($_POST['features'])) {
            $features = array_filter(array_map('trim', explode("\n", $_POST['features'])));
        }
        $features_json = json_encode($features);
        
        // Handle image
        $image = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload = upload_file($_FILES['image'], 'services');
            if ($upload['success']) {
                $image = $upload['path'];
                if ($action === 'edit' && !empty($_POST['existing_image'])) {
                    delete_file($_POST['existing_image']);
                }
            }
        }
        
        if ($action === 'add') {
            $stmt = $db->prepare("INSERT INTO services (service_name, service_slug, short_description, full_description, icon, image, price_info, features, is_featured, display_order, is_active, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$service_name, $service_slug, $short_description, $full_description, $icon, $image, $price_info, $features_json, $is_featured, $display_order, $is_active, $_SESSION['admin_id']])) {
                log_activity($_SESSION['admin_id'], 'create', 'services', $db->lastInsertId());
                $success = 'Layanan berhasil ditambahkan';
            }
        } else {
            $id = (int)$_POST['service_id'];
            $stmt = $db->prepare("UPDATE services SET service_name=?, service_slug=?, short_description=?, full_description=?, icon=?, image=?, price_info=?, features=?, is_featured=?, display_order=?, is_active=? WHERE service_id=?");
            if ($stmt->execute([$service_name, $service_slug, $short_description, $full_description, $icon, $image, $price_info, $features_json, $is_featured, $display_order, $is_active, $id])) {
                log_activity($_SESSION['admin_id'], 'update', 'services', $id);
                $success = 'Layanan berhasil diupdate';
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['service_id'];
        $stmt = $db->prepare("SELECT image FROM services WHERE service_id = ?");
        $stmt->execute([$id]);
        $service = $stmt->fetch();
        
        if ($service) {
            if ($service['image']) delete_file($service['image']);
            $stmt = $db->prepare("DELETE FROM services WHERE service_id = ?");
            if ($stmt->execute([$id])) {
                log_activity($_SESSION['admin_id'], 'delete', 'services', $id);
                $success = 'Layanan berhasil dihapus';
            }
        }
    }
}

$services = $db->query("SELECT * FROM services ORDER BY display_order, service_id DESC")->fetchAll();

require_once 'includes/header.php';
?>

<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Layanan</h3>
        <button class="btn btn-primary" onclick="showAddForm()">➕ Tambah Layanan</button>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Layanan</th>
                        <th>Harga</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $svc): ?>
                    <tr>
                        <td><?= $svc['icon'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($svc['service_name']) ?></strong><br>
                            <small><?= htmlspecialchars($svc['short_description']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($svc['price_info']) ?></td>
                        <td><?= $svc['is_featured'] ? '⭐ Ya' : 'Tidak' ?></td>
                        <td>
                            <?php if ($svc['is_active']): ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Non-aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-secondary" onclick='editService(<?= json_encode($svc) ?>)'>Edit</button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="service_id" value="<?= $svc['service_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal (simplified - full version would be more elaborate) -->
<div id="serviceModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; padding:20px; overflow-y:auto;">
    <div style="max-width: 700px; margin:0 auto; background:white; border-radius:16px; padding:32px;">
        <h3 id="modalTitle">Tambah Layanan</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" id="formAction" value="add">
            <input type="hidden" name="service_id" id="serviceId">
            <input type="hidden" name="existing_image" id="existingImage">
            
            <div class="form-group">
                <label class="form-label">Nama Layanan *</label>
                <input type="text" name="service_name" id="serviceName" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Slug (URL)</label>
                <input type="text" name="service_slug" id="serviceSlug" class="form-control">
                <small class="form-text">Kosongkan untuk auto-generate</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat *</label>
                <input type="text" name="short_description" id="shortDescription" class="form-control" maxlength="255" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi Lengkap *</label>
                <textarea name="full_description" id="fullDescription" class="form-control" rows="4" required></textarea>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Icon (Emoji)</label>
                    <input type="text" name="icon" id="icon" class="form-control" placeholder="💰">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Info Harga</label>
                    <input type="text" name="price_info" id="priceInfo" class="form-control" placeholder="Mulai dari Rp 50.000/bulan">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar Layanan</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <img id="imagePreview" style="max-width:200px; margin-top:10px; display:none;">
            </div>
            
            <div class="form-group">
                <label class="form-label">Fitur-fitur (satu per baris)</label>
                <textarea name="features" id="features" class="form-control" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="display_order" id="displayOrder" class="form-control" value="0">
                </div>
                
                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" name="is_featured" id="isFeatured">
                        <span>Featured Service</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; margin-top:8px;">
                        <input type="checkbox" name="is_active" id="isActive" checked>
                        <span>Aktif</span>
                    </label>
                </div>
            </div>
            
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddForm() {
    document.getElementById('modalTitle').textContent = 'Tambah Layanan';
    document.getElementById('formAction').value = 'add';
    document.querySelector('form').reset();
    document.getElementById('serviceModal').style.display = 'block';
}

function editService(service) {
    document.getElementById('modalTitle').textContent = 'Edit Layanan';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('serviceId').value = service.service_id;
    document.getElementById('existingImage').value = service.image || '';
    document.getElementById('serviceName').value = service.service_name;
    document.getElementById('serviceSlug').value = service.service_slug;
    document.getElementById('shortDescription').value = service.short_description;
    document.getElementById('fullDescription').value = service.full_description;
    document.getElementById('icon').value = service.icon || '';
    document.getElementById('priceInfo').value = service.price_info || '';
    
    // Features from JSON
    if (service.features) {
        try {
            const features = JSON.parse(service.features);
            document.getElementById('features').value = features.join('\n');
        } catch(e) {}
    }
    
    document.getElementById('displayOrder').value = service.display_order;
    document.getElementById('isFeatured').checked = service.is_featured == 1;
    document.getElementById('isActive').checked = service.is_active == 1;
    
    if (service.image) {
        document.getElementById('imagePreview').src = '<?= UPLOAD_URL ?>' + service.image;
        document.getElementById('imagePreview').style.display = 'block';
    }
    
    document.getElementById('serviceModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('serviceModal').style.display = 'none';
}
</script>

<?php require_once 'includes/footer.php'; ?>
