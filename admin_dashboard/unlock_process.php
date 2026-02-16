<?php
session_start();
// Ensure only admins can access this
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$db = new mysqli("localhost", "root", "", "clp");

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Reset status to 'Active' and clear failed login attempts
    $stmt = $db->prepare("UPDATE tbl_users SET status = 'Active', attempts = 0 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=UserUnlocked");
    } else {
        header("Location: admin_dashboard.php?msg=Error");
    }
}
?>