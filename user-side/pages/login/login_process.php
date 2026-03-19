<?php
session_start();
require '../../../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    $response = [];

    // Fetch user
    $stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        // Check account status
        if ($user['user_status'] === 'Locked') {
            $response = [
                'status' => 'error',
                'message' => 'Account is locked. Please contact admin.',
                'lock' => true
            ];
        } elseif ($user['user_status'] === 'Reset') {
            $response = [
                'status' => 'error',
                'message' => 'Password reset required. Please reset your password.',
                'lock' => false
            ];
        } else {
            // Compare password stored as base64
            if ($user['password'] === base64_encode($password)) {
                // Successful login
                $_SESSION['user'] = $user['username'];

                // Reset attempts and update last login
                $update = $pdo->prepare("UPDATE tbl_users SET user_attempt = 0, user_status = 'Active', last_logIn = NOW() WHERE id = :id");
                $update->execute(['id' => $user['id']]);

                $response = [
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'lock' => false,
                    'redirect' => '/admin-side/dashboard.php'
                ];
            } else {
                // Wrong password
                $attempts = $user['user_attempt'] + 1;

                if ($attempts >= 3) {
                    // Lock account
                    $update = $pdo->prepare("UPDATE tbl_users SET user_attempt = :attempts, user_status = 'Locked' WHERE id = :id");
                    $update->execute(['attempts' => $attempts, 'id' => $user['id']]);

                    $response = [
                        'status' => 'error',
                        'message' => 'Account locked due to 3 failed attempts.',
                        'lock' => true
                    ];
                } else {
                    // Increment attempts
                    $update = $pdo->prepare("UPDATE tbl_users SET user_attempt = :attempts WHERE id = :id");
                    $update->execute(['attempts' => $attempts, 'id' => $user['id']]);

                    $response = [
                        'status' => 'error',
                        'message' => "Invalid username or password. Attempt $attempts of 3.",
                        'lock' => false
                    ];
                }
            }
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'User not found.',
            'lock' => false
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>