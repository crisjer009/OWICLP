<?php
// auth.php
header('Content-Type: application/json');
session_start();

// 1. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

if ($db->connect_error) {
    // Log the connection error for IT Review
    error_log("Connection failed: " . $db->connect_error);
    echo json_encode(["status" => 0, "message" => "Connection failed"]);
    exit;
}

// 2. Capture and Clean Data
$username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';

// 3. Database Query
// Explicitly fetching organizational IDs to ensure session consistency
$stmt = $db->prepare("SELECT id, password, user_status, user_attempt, FirstName, LastName, user_role, dept_id, user_level_id FROM tbl_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 4. Validation Logic
if (!$user) {
    echo json_encode(["status" => 2, "message" => "Invalid Username"]);
    exit;
}

// Check if blocked before checking password
if ($user['user_status'] === 'Blocked' || $user['user_status'] === 'L') {
    echo json_encode(["status" => 3, "message" => "Account Blocked."]);
    exit;
}

// 5. Password Check
if ($user['password'] === $password) {
    // SUCCESS: Reset attempts and update login time
    // We explicitly set user_status to 'Active' to ensure it clears any 'L' flags
    $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'Active' WHERE id = " . $user['id']);
    
    // Set Session Variables
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $username;
    $_SESSION['full_name'] = $user['FirstName'] . " " . $user['LastName'];
    $_SESSION['user_role'] = (int)$user['user_role']; // Store as integer for Level-based logic
    $_SESSION['status']    = 'Active';
    
    // Organizational data for IT/Admin reference
    $_SESSION['dept_id']       = $user['dept_id'];
    $_SESSION['user_level_id'] = $user['user_level_id'];

    $redirectPath = "dashboard.php"; 

    echo json_encode([
        "status" => 1, 
        "message" => "Success",
        "redirect" => $redirectPath
    ]);
} else {
    // FAILURE: Increment attempts
    $attempts = $user['user_attempt'] + 1;
    $newStatus = ($attempts >= 3) ? 'Blocked' : $user['user_status']; 
    
    // Command: Update with safe handling of the ENUM status
    $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
    $update->bind_param("isi", $attempts, $newStatus, $user['id']);
    $update->execute();
    
    if ($newStatus === 'Blocked' || $newStatus === 'L') {
        // Log the lockout event for the IT Dept
        $ip = $_SERVER['REMOTE_ADDR'];
        $log_msg = "User Locked Out: $username (IP: $ip)";
        $db->query("INSERT INTO tbl_system_logs (user_id, action, error_message, ip_address) VALUES ({$user['id']}, 'ACCOUNT_LOCKOUT', '$log_msg', '$ip')");

        echo json_encode(["status" => 3, "message" => "Account Blocked due to 3 failed attempts."]);
    } else {
        $remaining = 3 - $attempts;
        echo json_encode(["status" => 2, "message" => "Invalid Password. $remaining attempts left."]);
    }
}

$stmt->close();
$db->close();
?>