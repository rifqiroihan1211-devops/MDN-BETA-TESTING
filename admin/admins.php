<?php
/**
 * MDN Admin - Admin Management (Super Admin Only)
 */
define('ADMIN_PAGE', true);
$page_title = 'Kelola Admin';

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
        $username = clean_input($_POST['username']);
        $email = clean_input($_POST['email']);
        $full_name = clean_input($_POST['full_name']);
        $role = clean_input($_POST['role']);
        $phone = clean_input($_POST['phone']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Handle avatar
        $avatar = $_POST['existing_avatar'] ?? '';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $upload = upload_file($_FILES['avatar'], 'admins');
            if ($upload['success']) {
                $avatar = $upload['path'];
                if ($action === 'edit' && !empty($_POST['existing_avatar'])) {
                    delete_file($_POST['existing_avatar']);
                }
            }
        }
        
        if ($action === 'add') {
            $password = $_POST['password'];
            if (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO admins (username, email, password, full_name, role, phone, avatar, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                try {
                    if ($stmt->execute([$username, $email, $hashed_password, $full_name, $role, $phone, $avatar, $is_active])) {
                        log_activity($_SESSION['admin_id'], 'create', 'admins', $db->lastInsertId());
                        $success = 'Admin berhasil ditambahkan';
                    }
                } catch (PDOException $e) {
                    $error = 'Username atau email sudah digunakan';
                }
            }
        } else {
            $id = (int)$_POST['admin_id'];
            
            // Update password only if provided
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                if (strlen($password) < 6) {
                    $error = 'Password minimal 6 karakter';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("UPDATE admins SET username=?, email=?, password=?, full_name=?, role=?, phone=?, avatar=?, is_active=? WHERE admin_id=?");
                    try {
                        if ($stmt->execute([$username, $email, $hashed_password, $full_name, $role, $phone, $avatar, $is_active, $id])) {
                            log_activity($_SESSION['admin_id'], 'update', 'admins', $id);
                            $success = 'Admin berhasil diupdate';
                        }
                    } catch (PDOException $e) {
                        $error = 'Username atau email sudah digunakan';
                    }
                }
            } else {
                $stmt = $db->prepare("UPDATE admins SET username=?, email=?, full_name=?, role=?, phone=?, avatar=?, is_active=? WHERE admin_id=?");
                try {
                    if ($stmt->execute([$username, $email, $full_name, $role, $phone, $avatar, $is_active, $id])) {
                        log_activity($_SESSION['admin_id'], 'update', 'admins', $id);
                        $success = 'Admin berhasil diupdate';
                    }
                } catch (PDOException $e) {
                    $error = 'Username atau email sudah digunakan';
                }
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['admin_id'];
        
        // Prevent deleting self
        if ($id == $_SESSION['admin_id']) {
            $error = 'Tidak bisa menghapus akun sendiri';
        } else {
            $stmt = $db->prepare("SELECT avatar FROM admins WHERE admin_id = ?");
            $stmt->execute([$id]);
            $admin = $stmt->fetch();
            
            if ($admin) {
                if ($admin['avatar']) delete_file($admin['avatar']);
                $stmt = $db->prepare("DELETE FROM admins WHERE admin_id = ?");
                if ($stmt->execute([$id])) {
                    log_activity($_SESSION['admin_id'], 'delete', 'admins', $id);
                    $success = 'Admin berhasil dihapus';
                }
            }
        }
    }
}

// Get all admins
$admins = $db->query("SELECT * FROM admins ORDER BY role DESC, created_at DESC")->fetchAll();

require_once 'includes/header.php';
?>

<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Admin</h3>
        <button class="btn btn-primary" onclick="showAddForm()">➕ Tambah Admin</button>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td>
                            <?php if ($admin['avatar']): ?>
                            <img src="<?= UPLOAD_URL . $admin['avatar'] ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                            <?php else: ?>
                            <div style="width:40px; height:40px; border-radius:50%; background:#1a5f3f; color:white; display:flex; align-items:center; justify-content:center; font-weight:700;">
                                <?= substr($admin['full_name'], 0, 1) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($admin['full_name']) ?></td>
                        <td><?= htmlspecialchars($admin['username']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td>
                            <?php if ($admin['role'] === 'super_admin'): ?>
                            <span class="badge badge-danger">Super Admin</span>
                            <?php else: ?>
                            <span class="badge badge-primary">Admin</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($admin['is_active']): ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Non-aktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $admin['last_login'] ? date('d M Y H:i', strtotime($admin['last_login'])) : '-' ?></td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-secondary" onclick='editAdmin(<?= json_encode($admin) ?>)'>Edit</button>
                            <?php if ($admin['admin_id'] != $_SESSION['admin_id']): ?>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus admin ini?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="admin_id" value="<?= $admin['admin_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="adminModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; padding:40px;">
    <div style="max-width: 600px; margin:0 auto; background:white; border-radius:16px; padding:32px; max-height:90vh; overflow-y:auto;">
        <h3 id="modalTitle">Tambah Admin</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" id="formAction" value="add">
            <input type="hidden" name="admin_id" id="adminId">
            <input type="hidden" name="existing_avatar" id="existingAvatar">
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="full_name" id="fullName" class="form-control" required>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label" id="passwordLabel">Password *</label>
                <input type="password" name="password" id="password" class="form-control">
                <small class="form-text">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Avatar</label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                <img id="avatarPreview" style="width:80px; height:80px; border-radius:50%; margin-top:10px; display:none; object-fit:cover;">
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
    document.getElementById('modalTitle').textContent = 'Tambah Admin';
    document.getElementById('formAction').value = 'add';
    document.getElementById('passwordLabel').textContent = 'Password *';
    document.getElementById('password').required = true;
    document.querySelector('form').reset();
    document.getElementById('adminModal').style.display = 'block';
}

function editAdmin(admin) {
    document.getElementById('modalTitle').textContent = 'Edit Admin';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('adminId').value = admin.admin_id;
    document.getElementById('existingAvatar').value = admin.avatar || '';
    document.getElementById('fullName').value = admin.full_name;
    document.getElementById('username').value = admin.username;
    document.getElementById('email').value = admin.email;
    document.getElementById('phone').value = admin.phone || '';
    document.getElementById('role').value = admin.role;
    document.getElementById('isActive').checked = admin.is_active == 1;
    document.getElementById('password').value = '';
    document.getElementById('passwordLabel').textContent = 'Password (kosongkan jika tidak diubah)';
    document.getElementById('password').required = false;
    
    if (admin.avatar) {
        document.getElementById('avatarPreview').src = '<?= UPLOAD_URL ?>' + admin.avatar;
        document.getElementById('avatarPreview').style.display = 'block';
    }
    
    document.getElementById('adminModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('adminModal').style.display = 'none';
}
</script>

<?php require_once 'includes/footer.php'; ?>
