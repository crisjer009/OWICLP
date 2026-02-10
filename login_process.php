<?php
// login_process.php
header('Content-Type: application/json');

// Database Connection (Update with your credentials)
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$user = $_POST['username'];
$pass = $_POST['password']; //  Base64 encoded

// 1. Check if user exists and status
$sql = "SELECT * FROM tbl_users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    echo json_encode(["status" => "error", "message" => "Invalid Username"]);
    exit;
}

// 2. Check if account is locked
if ($userData['user_status'] == 'L') {
    echo json_encode(["status" => "error", "message" => "Account Locked. Contact Admin."]);
    exit;
}

// 3. Verify Password (Comparing Base64 strings)
if ($userData['password'] === $pass) {
    // Success: Reset attempts and update last_logIn
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = ?");
    $update->bind_param("i", $userData['id']);
    $update->execute();

    echo json_encode(["status" => "success", "message" => "Login Successful!"]);
} else {
    // Failure: Increment attempts
    $newAttempts = $userData['user_attempt'] + 1;
    $newStatus = ($newAttempts >= 3) ? 'L' : $userData['user_status'];
    
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $newAttempts, $newStatus, $userData['id']);
    $update->execute();

    $remaining = 3 - $newAttempts;
    $msg = ($newStatus == 'L') ? "Account Locked due to 3 failed attempts." : "Invalid Password. $remaining attempts left.";
    echo json_encode(["status" => "error", "message" => $msg]);
}

$stmt->close();
$conn->close();
?>