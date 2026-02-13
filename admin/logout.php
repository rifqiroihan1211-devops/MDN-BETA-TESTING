<?php
/**
 * MDN Admin - Logout
 */
session_start();

// Log activity before destroying session
if (isset($_SESSION['admin_id'])) {
    require_once '../config.php';
    log_activity($_SESSION['admin_id'], 'logout', 'admins', $_SESSION['admin_id']);
}

// Destroy session
session_destroy();

// Redirect to login
header('Location: login.php');
exit();
?>
