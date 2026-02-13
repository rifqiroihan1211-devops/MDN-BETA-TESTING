<?php
/**
 * MDN Admin - Offices Management (2 Kantor)
 */
define('ADMIN_PAGE', true);
$page_title = 'Manajemen Kantor';

require_once '../config.php';
$db = Database::getInstance()->getConnection();
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'edit') {
        $id = (int)$_POST['office_id'];
        $office_name = clean_input($_POST['office_name']);
        $office_type = clean_input($_POST['office_type']);
        $address = clean_input($_POST['address']);
        $city = clean_input($_POST['city']);
        $province = clean_input($_POST['province']);
        $postal_code = clean_input($_POST['postal_code']);
        $phone = clean_input($_POST['phone']);
        $email = clean_input($_POST['email']);
        $latitude = floatval($_POST['latitude']);
        $longitude = floatval($_POST['longitude']);
        
        // Working hours as JSON
        $working_hours = [
            'senin_jumat' => clean_input($_POST['senin_jumat']),
            'sabtu' => clean_input($_POST['sabtu']),
            'minggu' => clean_input($_POST['minggu'])
        ];
        $working_hours_json = json_encode($working_hours);
        
        // Handle image
        $image = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload = upload_file($_FILES['image'], 'offices');
            if ($upload['success']) {
                $image = $upload['path'];
                if (!empty($_POST['existing_image'])) {
                    delete_file($_POST['existing_image']);
                }
            }
        }
        
        $stmt = $db->prepare("UPDATE offices SET office_name=?, office_type=?, address=?, city=?, province=?, postal_code=?, phone=?, email=?, latitude=?, longitude=?, working_hours=?, image=? WHERE office_id=?");
        if ($stmt->execute([$office_name, $office_type, $address, $city, $province, $postal_code, $phone, $email, $latitude, $longitude, $working_hours_json, $image, $id])) {
            log_activity($_SESSION['admin_id'], 'update', 'offices', $id);
            $success = 'Data kantor berhasil diupdate';
        }
    }
}

// Get offices (max 2)
$offices = $db->query("SELECT * FROM offices ORDER BY office_type DESC")->fetchAll();

require_once 'includes/header.php';
?>

<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

<div class="alert alert-info">
    <strong>ℹ️ Info:</strong> Sistem mendukung 2 kantor: 1 Kantor Pusat dan 1 Kantor Cabang
</div>

<div style="display:grid; gap:24px;">
    <?php foreach ($offices as $office): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?= $office['office_type'] === 'head_office' ? '🏢 Kantor Pusat' : '🏬 Kantor Cabang' ?>
            </h3>
            <button class="btn btn-primary" onclick='editOffice(<?= json_encode($office) ?>)'>✏️ Edit</button>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns: 200px 1fr; gap:24px;">
                <?php if (isset($office['image']) && !empty($office['image'])): ?>
                <img src="<?= UPLOAD_URL . $office['image'] ?>" style="width:100%; border-radius:12px; object-fit:cover;">
                <?php else: ?>
                <div style="width:200px; height:150px; background:#f0f0f0; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#999;">No Image</div>
                <?php endif; ?>
                
                <div>
                    <h4><?= htmlspecialchars($office['office_name']) ?></h4>
                    <p style="margin:8px 0; color:#666;">
                        📍 <?= htmlspecialchars($office['address']) ?><br>
                        <?= htmlspecialchars($office['city']) ?>, <?= htmlspecialchars($office['province']) ?> <?= htmlspecialchars($office['postal_code']) ?>
                    </p>
                    <p style="margin:8px 0; color:#666;">
                        📞 <?= htmlspecialchars($office['phone']) ?><br>
                        ✉️ <?= htmlspecialchars($office['email']) ?>
                    </p>
                    <?php 
                    $hours = json_decode($office['working_hours'], true);
                    if ($hours):
                    ?>
                    <p style="margin:8px 0; color:#666;">
                        🕐 <strong>Jam Operasional:</strong><br>
                        Senin-Jumat: <?= $hours['senin_jumat'] ?? '-' ?><br>
                        Sabtu: <?= $hours['sabtu'] ?? '-' ?><br>
                        Minggu: <?= $hours['minggu'] ?? '-' ?>
                    </p>
                    <?php endif; ?>
                    <p style="margin:8px 0; color:#666;">
                        🌍 Koordinat: <?= $office['latitude'] ?>, <?= $office['longitude'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit Modal -->
<div id="officeModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; padding:20px; overflow-y:auto;">
    <div style="max-width: 800px; margin:0 auto; background:white; border-radius:16px; padding:32px;">
        <h3 id="modalTitle">Edit Kantor</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="office_id" id="officeId">
            <input type="hidden" name="existing_image" id="existingImage">
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Nama Kantor *</label>
                    <input type="text" name="office_name" id="officeName" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tipe *</label>
                    <select name="office_type" id="officeType" class="form-control" required>
                        <option value="head_office">Kantor Pusat</option>
                        <option value="branch_office">Kantor Cabang</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Alamat Lengkap *</label>
                <textarea name="address" id="address" class="form-control" rows="2" required></textarea>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Kota *</label>
                    <input type="text" name="city" id="city" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Provinsi *</label>
                    <input type="text" name="province" id="province" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" name="postal_code" id="postalCode" class="form-control">
                </div>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Telepon *</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Latitude</label>
                    <input type="number" step="0.0000001" name="latitude" id="latitude" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Longitude</label>
                    <input type="number" step="0.0000001" name="longitude" id="longitude" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Jam Operasional</label>
                <div style="display:grid; gap:8px;">
                    <input type="text" name="senin_jumat" id="seninJumat" class="form-control" placeholder="Senin-Jumat: 08:00 - 17:00">
                    <input type="text" name="sabtu" id="sabtu" class="form-control" placeholder="Sabtu: 08:00 - 14:00">
                    <input type="text" name="minggu" id="minggu" class="form-control" placeholder="Minggu: Tutup">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Foto Kantor</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <img id="imagePreview" style="max-width:200px; margin-top:10px; display:none;">
            </div>
            
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function editOffice(office) {
    document.getElementById('officeId').value = office.office_id;
    document.getElementById('existingImage').value = office.image || '';
    document.getElementById('officeName').value = office.office_name;
    document.getElementById('officeType').value = office.office_type;
    document.getElementById('address').value = office.address;
    document.getElementById('city').value = office.city;
    document.getElementById('province').value = office.province;
    document.getElementById('postalCode').value = office.postal_code || '';
    document.getElementById('phone').value = office.phone || '';
    document.getElementById('email').value = office.email || '';
    document.getElementById('latitude').value = office.latitude || '';
    document.getElementById('longitude').value = office.longitude || '';
    
    // Working hours from JSON
    if (office.working_hours) {
        try {
            const hours = JSON.parse(office.working_hours);
            document.getElementById('seninJumat').value = hours.senin_jumat || '';
            document.getElementById('sabtu').value = hours.sabtu || '';
            document.getElementById('minggu').value = hours.minggu || '';
        } catch(e) {}
    }
    
    if (office.image) {
        document.getElementById('imagePreview').src = '<?= UPLOAD_URL ?>' + office.image;
        document.getElementById('imagePreview').style.display = 'block';
    }
    
    document.getElementById('officeModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('officeModal').style.display = 'none';
}
</script>

<?php require_once 'includes/footer.php'; ?>
