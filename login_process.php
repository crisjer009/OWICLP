<?php
header('Content-Type: application/json');
session_start();

$conn = new mysqli("localhost", "root", "", "clp");

if ($conn->connect_error) {
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

$user = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : ''; 

$stmt = $conn->prepare("SELECT id, password, user_status, user_attempt, LastName, FirstName, user_role, total_points, account_expiry, current_tier FROM tbl_users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

if (!$userData) {
    echo json_encode(["status" => 2, "message" => "Invalid Username"]);
    exit;
}

if ($userData['user_status'] === 'L' || $userData['user_status'] === 'Blocked') {
    echo json_encode(["status" => 3, "message" => "Account Blocked. Contact Admin."]);
    exit;
}

// Check Base64 encoded password
if ($userData['password'] === base64_encode($pass)) { 
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'Active' WHERE id = ?");
    $update->bind_param("i", $userData['id']);
    $update->execute();

    $_SESSION['user_id']   = $userData['id'];
    $_SESSION['full_name'] = $userData['FirstName'] . " " . $userData['LastName'];
    $_SESSION['user_role'] = (int)$userData['user_role']; 
    $_SESSION['points']    = $userData['total_points'];
    $_SESSION['tier']      = $userData['current_tier'];

    // Redirection Logic
    $redirectPage = ($_SESSION['user_role'] === 1 || $_SESSION['user_role'] === 3) ? "admin_dashboard.php" : "dashboard.php";

    echo json_encode(["status" => 1, "message" => "Access Granted", "redirect" => $redirectPage]);
} else {
    $newAttempts = $userData['user_attempt'] + 1;
    $newStatus = ($newAttempts >= 3) ? 'L' : $userData['user_status'];
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $newAttempts, $newStatus, $userData['id']);
    $update->execute();
    
    echo json_encode(["status" => 2, "message" => ($newStatus === 'L') ? "Account Blocked." : "Invalid Password."]);
}
?>