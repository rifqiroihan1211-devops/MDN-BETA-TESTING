<?php
/**
 * MDN Admin - Slider Management
 */
define('ADMIN_PAGE', true);
$page_title = 'Manajemen Slider';

require_once '../config.php';

// Check super admin
if ($_SESSION['role'] !== 'super_admin') {
    die('Access denied. Super admin only.');
}

$db = Database::getInstance()->getConnection();
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' || $action === 'edit') {
        $title = clean_input($_POST['title']);
        $description = clean_input($_POST['description']);
        $section = clean_input($_POST['section']);
        $link_url = clean_input($_POST['link_url'] ?? '');
        $link_text = clean_input($_POST['link_text'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Handle image upload
        $image = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload = upload_file($_FILES['image'], 'sliders');
            if ($upload['success']) {
                $image = $upload['path'];
                // Delete old image if editing
                if ($action === 'edit' && !empty($_POST['existing_image'])) {
                    delete_file($_POST['existing_image']);
                }
            }
        }
        
        if ($action === 'add') {
            $stmt = $db->prepare("INSERT INTO sliders (title, description, image, link_url, link_text, section, display_order, is_active, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$title, $description, $image, $link_url, $link_text, $section, $display_order, $is_active, $_SESSION['admin_id']])) {
                log_activity($_SESSION['admin_id'], 'create', 'sliders', $db->lastInsertId());
                $success = 'Slider berhasil ditambahkan';
            }
        } else {
            $id = (int)$_POST['slider_id'];
            $stmt = $db->prepare("UPDATE sliders SET title=?, description=?, image=?, link_url=?, link_text=?, section=?, display_order=?, is_active=? WHERE slider_id=?");
            if ($stmt->execute([$title, $description, $image, $link_url, $link_text, $section, $display_order, $is_active, $id])) {
                log_activity($_SESSION['admin_id'], 'update', 'sliders', $id);
                $success = 'Slider berhasil diupdate';
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['slider_id'];
        $stmt = $db->prepare("SELECT image FROM sliders WHERE slider_id = ?");
        $stmt->execute([$id]);
        $slider = $stmt->fetch();
        
        if ($slider) {
            delete_file($slider['image']);
            $stmt = $db->prepare("DELETE FROM sliders WHERE slider_id = ?");
            if ($stmt->execute([$id])) {
                log_activity($_SESSION['admin_id'], 'delete', 'sliders', $id);
                $success = 'Slider berhasil dihapus';
            }
        }
    }
}

// Get all sliders
$sliders = $db->query("SELECT * FROM sliders ORDER BY section, display_order")->fetchAll();

require_once 'includes/header.php';
?>

<?php if ($success): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-error"><?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Slider</h3>
        <button class="btn btn-primary" onclick="showAddForm()">
            <span>➕</span> Tambah Slider
        </button>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Section</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sliders as $slider): ?>
                    <tr>
                        <td>
                            <?php if ($slider['image']): ?>
                            <img src="<?= UPLOAD_URL . $slider['image'] ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 8px;">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($slider['title']) ?></td>
                        <td><span class="badge badge-primary"><?= ucfirst($slider['section']) ?></span></td>
                        <td><?= $slider['display_order'] ?></td>
                        <td>
                            <?php if ($slider['is_active']): ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Non-aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-secondary" onclick='editSlider(<?= json_encode($slider) ?>)'>Edit</button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus slider ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="slider_id" value="<?= $slider['slider_id'] ?>">
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

<!-- Add/Edit Modal (implement with JavaScript) -->
<div id="sliderModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; padding:40px;">
    <div style="max-width: 600px; margin:0 auto; background:white; border-radius:16px; padding:32px; max-height:90vh; overflow-y:auto;">
        <h3 id="modalTitle">Tambah Slider</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" id="formAction" value="add">
            <input type="hidden" name="slider_id" id="sliderId">
            <input type="hidden" name="existing_image" id="existingImage">
            
            <div class="form-group">
                <label class="form-label">Judul *</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar *</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <img id="imagePreview" style="max-width:200px; margin-top:10px; display:none;">
            </div>
            
            <div class="form-group">
                <label class="form-label">Section *</label>
                <select name="section" id="section" class="form-control" required>
                    <option value="hero">Hero</option>
                    <option value="about">About</option>
                    <option value="features">Features</option>
                    <option value="contact">Contact</option>
                </select>
                <small class="form-text">Catatan: Slider tidak ditampilkan di section Layanan</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Link URL</label>
                <input type="url" name="link_url" id="linkUrl" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label">Link Text</label>
                <input type="text" name="link_text" id="linkText" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label">Urutan</label>
                <input type="number" name="display_order" id="displayOrder" class="form-control" value="0">
            </div>
            
            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="is_active" id="isActive" value="1" checked>
                    <span>Aktif</span>
                </label>
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
    document.getElementById('modalTitle').textContent = 'Tambah Slider';
    document.getElementById('formAction').value = 'add';
    document.getElementById('sliderId').value = '';
    document.getElementById('sliderModal').style.display = 'block';
    document.querySelector('form').reset();
}

function editSlider(slider) {
    document.getElementById('modalTitle').textContent = 'Edit Slider';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('sliderId').value = slider.slider_id;
    document.getElementById('existingImage').value = slider.image;
    document.getElementById('title').value = slider.title;
    document.getElementById('description').value = slider.description;
    document.getElementById('section').value = slider.section;
    document.getElementById('linkUrl').value = slider.link_url || '';
    document.getElementById('linkText').value = slider.link_text || '';
    document.getElementById('displayOrder').value = slider.display_order;
    document.getElementById('isActive').checked = slider.is_active == 1;
    
    if (slider.image) {
        document.getElementById('imagePreview').src = '<?= UPLOAD_URL ?>' + slider.image;
        document.getElementById('imagePreview').style.display = 'block';
    }
    
    document.getElementById('sliderModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('sliderModal').style.display = 'none';
}
</script>

<?php require_once 'includes/footer.php'; ?>
