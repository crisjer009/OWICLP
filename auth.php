<?php
// auth.php
header('Content-Type: application/json');

// 1. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

if ($db->connect_error) {
    die(json_encode(["status" => "F", "message" => "Connection failed"]));
}

// 2. Safely capture POST data
$username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';


// 3. Database Query
$query = "SELECT id, password, user_status, user_attempt FROM tbl_users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo json_encode(["status" => "F", "message" => "Invalid Username"]);
    exit;
}

if ($user['user_status'] === 'Blocked') {
    echo json_encode(["status" => "B", "message" => "Account Blocked."]);
    exit;
}

// 5. Password Check
if ($user['password'] === $password) {
    $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW() WHERE id = " . $user['id']);
    echo json_encode(["status" => "A", "message" => "Success"]);
} else {
    $attempts = $user['user_attempt'] + 1;
    $newStatus = ($attempts >= 3) ? 'Blocked' : $user['user_status'];
    
    $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $attempts, $newStatus, $user['id']);
    $update->execute();
    
    echo json_encode(["status" => "F", "message" => "Invalid Password. Attempt $attempts/3"]);
}
?>