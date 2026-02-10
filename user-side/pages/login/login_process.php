<?php
session_start();
require '../../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $response = [];

    if ($user) {
        if ($user['user_status'] == 'L') {
            $response['status'] = 'error';
            $response['message'] = 'Account is locked. Please contact admin.';
        } elseif ($user['user_status'] == 'R') {
            $response['status'] = 'error';
            $response['message'] = 'Password reset required. Please reset your password.';
        }elseif($user['user_status'] == 'B') {
            $response['status'] = 'error';
            $response['message'] ='Account is Restricted. Please contact admin.';
        
        } elseif ($user['password'] === $password) {
            $_SESSION['user'] = $user['username'];
            $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW() WHERE id = :id");
            $update->execute(['id' => $user['id']]);

            $response['status'] = 'success';
            $response['message'] = ''; 
        } else {
            $attempts = $user['user_attempt'] + 1;
            if ($attempts >= 3) {
                $update = $conn->prepare("UPDATE tbl_users SET user_attempt = :attempts, user_status = 'L' WHERE id = :id");
                $update->execute(['attempts' => $attempts, 'id' => $user['id']]);
                $response['status'] = 'error';
                $response['message'] = 'Account locked due to 3 failed attempts.';
            } else {
                $update = $conn->prepare("UPDATE tbl_users SET user_attempt = :attempts WHERE id = :id");
                $update->execute(['attempts' => $attempts, 'id' => $user['id']]);
                $response['status'] = 'error';
                $response['message'] = "Invalid username or password. Attempt $attempts of 3.";
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User not found.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
