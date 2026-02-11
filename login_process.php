<?php
// login_process.php
header('Content-Type: application/json');

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "clp");

if ($conn->connect_error) {
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

// 2. Safely capture data
$user = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : ''; // Base64 encoded from frontend

// 3. Check if user exists
$stmt = $conn->prepare("SELECT id, password, user_status, user_attempt FROM tbl_users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    // Code 2: Invalid User
    echo json_encode(["status" => 2, "message" => "Invalid Username"]);
    exit;
}

// 4. Check if account is already locked
if ($userData['user_status'] === 'L' || $userData['user_status'] === 'Blocked') {
    // Code 3: Blocked
    echo json_encode(["status" => 3, "message" => "Account Blocked. Contact Admin."]);
    exit;
}

// 5. Verify Password
if ($userData['password'] === $pass) {
    // SUCCESS: Reset attempts and update status to Active ('A')
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = ?");
    $update->bind_param("i", $userData['id']);
    $update->execute();

    echo json_encode(["status" => 1, "message" => "Access Granted"]);
} else {
    // FAILURE: Increment attempts
    $newAttempts = $userData['user_attempt'] + 1;
    $newStatus = ($newAttempts >= 3) ? 'L' : $userData['user_status'];
    
    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $newAttempts, $newStatus, $userData['id']);
    $update->execute();

    if ($newStatus === 'L') {
        // Code 3: Just became blocked
        echo json_encode(["status" => 3, "message" => "Account Blocked due to 3 failed attempts."]);
    } else {
        // Code 2: Wrong password
        $remaining = 3 - $newAttempts;
        echo json_encode(["status" => 2, "message" => "Invalid Password. $remaining attempts left."]);
    }
}

$stmt->close();
$conn->close();
?>