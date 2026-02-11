<?php
session_start();
require 'connection.php'; 

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo "<div class='text-danger'>Please enter username and password.</div>";
    exit;
}

// Fetch user
$sql = "SELECT * FROM tbl_users WHERE username = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// User not found
if (!$user) {
    echo "<div class='text-danger'>Invalid username or password.</div>";
    exit;
}

// User Status Check 
switch ((int)$user['user_status']) {
    case 2: // Locked
        echo "<div class='text-danger fw-bold'>Your account is locked. Contact IT.</div>";
        exit;
    case 4: // Blocked 
        echo "<div class='text-danger fw-bold'>Account is blocked. Contact IT.</div>";
        exit;
}

// Attempt Check
if ($user['user_attempt'] >= 3) {
    echo "<div class='text-danger fw-bold'>Account locked after 3 failed attempts.</div>";
    exit;
}

// Password Check
$encodedPassword = base64_encode($password);
if ($encodedPassword !== $user['password']) {
    $attempts = $user['user_attempt'] + 1;
    $update = $mysqli->prepare("UPDATE tbl_users SET user_attempt = ? WHERE id = ?");
    $update->bind_param("ii", $attempts, $user['id']);
    $update->execute();
    
    $remaining = 3 - $attempts;
    echo "<div class='text-danger'>Incorrect password. Remaining: <b>$remaining</b></div>";
    exit;
}

// Set Session Data
$_SESSION['user_id']   = $user['id'];
$_SESSION['username']  = $user['username'];
$_SESSION['user_role'] = $user['user_role'];
$_SESSION['dept_id']   = $user['dept_id'];
$_SESSION['FirstName'] = $user['FirstName']; 
$_SESSION['LastName']  = $user['LastName'];

// Reset attempts and update last login
$success = $mysqli->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW() WHERE id = ?");
$success->bind_param("i", $user['id']);
$success->execute();

// Determine Redirect and Display Name
$redirect_url = "";
$role_display_name = "";

switch ((int)$user['user_role']) {
    case 1: 
        $redirect_url = 'admin_dashboard.php';
        $role_display_name = 'Administrator';
        break;
    case 2:
        $redirect_url = 'it_dashboard.php';
        $role_display_name = 'IT Support';
        break;
    case 3:
        $redirect_url = 'customer_dashboard.php';
        $role_display_name = 'Customer';
        break;
    default: 
        echo "<div class='text-danger fw-bold'>Access denied. Role not recognized.</div>";
        exit;
}

//  Show personalized welcome and Redirect
$firstName = htmlspecialchars($user['FirstName']);

echo "
<div class='text-success fw-bold'>
    Login successful!<br>
</div>
<script>
    setTimeout(function(){
        window.location.href = '$redirect_url';
    }, 1500);
</script>
";
?>