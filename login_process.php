<?php
session_start();
require 'connection.php'; 
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo "<div class='text-danger'>Please enter username and password.</div>";
    exit;
}

//fecth user
$sql = "SELECT * FROM tbl_users WHERE username = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
//User not found
if (!$user) {
    echo "<div class='text-danger'>Invalid username or password.</div>";
    exit;
}
//User Status Check
/* Status checks */
switch ((int)$user['user_status']) {
    case 2: // Locked
        echo "<div class='text-danger fw-bold'>
                Your account is locked.<br>
                Please contact IT Administrator.
              </div>";
        exit;

    case 3: // Reset
        echo "<div class='text-warning fw-bold'>
                Password reset required.<br>
                Please reset your password.
              </div>";
        exit;

    case 4: // Blocked
        echo "<div class='text-danger fw-bold'>
                Account is blocked.<br>
                Contact IT Administrator.
              </div>";
        exit;
}
//Attempt Check
if ($user['user_attempt'] >= 3) {
    // Auto mark as Blocked
    $block = $mysqli->prepare("
        UPDATE tbl_users 
        SET user_status = 'Blocked' 
        WHERE id = ?
    ");
    $block->bind_param("i", $user['id']);
    $block->execute();

    echo "<div class='text-danger fw-bold'>
            Account locked after 3 failed attempts.<br>
            Contact IT Administrator.
          </div>";
    exit;
}

//Paswword Check
$encodedPassword = base64_encode($password);
if ($encodedPassword !== $user['password']) {
    $attempts = $user['user_attempt'] + 1;
    $update = $mysqli->prepare("
        UPDATE tbl_users 
        SET user_attempt = ? 
        WHERE id = ?
    ");
    $update->bind_param("ii", $attempts, $user['id']);
    $update->execute();
    $remaining = 3 - $attempts;
    if ($remaining <= 0) {
        // Lock + Block
        $lock = $mysqli->prepare("
            UPDATE tbl_users 
            SET user_status = 'Blocked' 
            WHERE id = ?
        ");
        $lock->bind_param("i", $user['id']);
        $lock->execute();

        echo "<div class='text-danger fw-bold'>
                Account locked after 3 failed attempts.
              </div>";
    } else {
        echo "<div class='text-danger'>
                Incorrect password.<br>
                Remaining attempt(s): <b>$remaining</b>
              </div>";
    }
    exit;
}
//Role Check
if ($user['user_role'] != 1) {
    echo "<div class='text-danger fw-bold'>
            Access denied.<br>
            IT users only.
          </div>";
    exit;
}
$_SESSION['user_id']   = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['user_role'] = $user['user_role'];
$_SESSION['dept_id']   = $user['dept_id'];
//Reset attempts and update last login
$success = $mysqli->prepare("
    UPDATE tbl_users 
    SET user_attempt = 0,
        last_logIn = NOW()
    WHERE id = ?
");
$success->bind_param("i", $user['id']);
$success->execute();

echo "
<div class='text-success fw-bold'>
    Login successful!<br>
    Redirecting to IT Dashboard...
</div>
<script>
    setTimeout(function(){
        window.location.href = 'IT_dashboard.php';
    }, 1500);
</script>
";
?>
