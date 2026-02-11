<?php
header('Content-Type: application/json');
session_start(); // Start session to store user info upon success

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "clp");

if ($conn->connect_error) {
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

// 2. Capture data from AJAX
$user = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : ''; 

// 3. Updated Query: Fetching all additional user information
$stmt = $conn->prepare("SELECT id, password, user_status, user_attempt, LastName, FirstName, user_level_id, dept_id, user_role FROM tbl_users WHERE username = ?");
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

    // Display in dashboard when succefully Login
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['username'] = $user;
    $_SESSION['full_name'] = $userData['FirstName'] . " " . $userData['LastName'];
    $_SESSION['role'] = $userData['user_role'];
    $_SESSION['dept'] = $userData['dept_id'];

    echo json_encode(["status" => 1, "message" => "Access Granted"]);
} else {
    // FAILURE: Handle attempts and potential lockout
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