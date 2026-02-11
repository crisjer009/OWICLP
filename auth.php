<?php
// auth.php
header('Content-Type: application/json');

// 1. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

if ($db->connect_error) {
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

// 2. Capture and Clean Data
$username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';

// 3. Database Query
$stmt = $db->prepare("SELECT id, password, user_status, user_attempt FROM tbl_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 4. Validation Logic
if (!$user) {
    // Numeric Code 2: User not found
    echo json_encode(["status" => 2, "message" => "Invalid Username"]);
    exit;
}

// Check if blocked before checking password
if ($user['user_status'] === 'Blocked' || $user['user_status'] === 'L') {
    // Numeric Code 3: Account is locked
    echo json_encode(["status" => 3, "message" => "Account Blocked."]);
    exit;
}

// 5. Password Check (Matching Base64 strings)
if ($user['password'] === $password) {
    // Success: Update attempts, status, and login time
    $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = " . $user['id']);
    
    // Numeric Code 1: Success
    echo json_encode(["status" => 1, "message" => "Success"]);
} else {
    // Failure: Increment attempts
    $attempts = $user['user_attempt'] + 1;
    $newStatus = ($attempts >= 3) ? 'Blocked' : $user['user_status'];
    
    $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $attempts, $newStatus, $user['id']);
    $update->execute();
    
    // Determine message based on new status
    if ($newStatus === 'Blocked') {
        echo json_encode(["status" => 3, "message" => "Account Blocked due to 3 failed attempts."]);
    } else {
        // Numeric Code 2: Wrong password
        echo json_encode(["status" => 2, "message" => "Invalid Password. Attempt $attempts/3"]);
    }
}

$stmt->close();
$db->close();
?>