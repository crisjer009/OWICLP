<?php
header('Content-Type: application/json');
session_start();

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "clp");

if ($conn->connect_error) {
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

// 2. Capture data from AJAX
$user = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : ''; 

// 3. Enhanced Query: Fetching points, tier, and expiration for the dashboard
$stmt = $conn->prepare("SELECT id, password, user_status, user_attempt, LastName, FirstName, user_level_id, dept_id, user_role, total_points, account_expiry, current_tier FROM tbl_users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    echo json_encode(["status" => 2, "message" => "Invalid Username"]);
    exit;
}

// 4. Check Blocked Status
if ($userData['user_status'] === 'L' || $userData['user_status'] === 'Blocked') {
    echo json_encode(["status" => 3, "message" => "Account Blocked. Contact Admin."]);
    exit;
}

// 5. Verify Password
if ($userData['password'] === $pass) {
    // SUCCESS: Reset attempts and set status to Active
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = ?");
    $update->bind_param("i", $userData['id']);
    $update->execute();

    // Store essential dashboard data in Session
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['username'] = $user;
    $_SESSION['full_name'] = $userData['FirstName'] . " " . $userData['LastName'];
    $_SESSION['role'] = $userData['user_role'];
    $_SESSION['status'] = $userData['user_status'];
    
    // New Dashboard specific session data
    $_SESSION['points'] = $userData['total_points'];
    $_SESSION['expiry'] = $userData['account_expiry'];
    $_SESSION['tier'] = $userData['current_tier'];

    echo json_encode(["status" => 1, "message" => "Access Granted"]);
} else {
    // FAILURE logic remains the same
    $newAttempts = $userData['user_attempt'] + 1;
    $newStatus = ($newAttempts >= 3) ? 'L' : $userData['user_status'];
    
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $newAttempts, $newStatus, $userData['id']);
    $update->execute();

    if ($newStatus === 'L') {
        echo json_encode(["status" => 3, "message" => "Account Blocked."]);
    } else {
        $remaining = 3 - $newAttempts;
        echo json_encode(["status" => 2, "message" => "Invalid Password. $remaining attempts left."]);
    }
}

$stmt->close();
$conn->close();
?>