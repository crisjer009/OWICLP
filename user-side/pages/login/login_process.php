<?php
session_start();
require '../../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text input

    // Fetch user
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $response = [];

    if ($user) {
        if ($user['user_status'] === 'Locked') { 
            $response['status'] = 'error';
            $response['message'] = 'Account is locked. Please contact admin.';
            $response['lock'] = true;

        } elseif ($user['user_status'] === 'Reset') { 
            $response['status'] = 'error';
            $response['message'] = 'Password reset required. Please reset your password.';
            $response['lock'] = false;

        } else { // Active
            if ($user['password'] === base64_encode($password)) {
                $_SESSION['user'] = $user['username'];

                $update = $conn->prepare("UPDATE tbl_users SET user_attempt = 0, user_status = 'Active', last_logIn = NOW() WHERE id = :id");
                $update->execute(['id' => $user['id']]);

                $response['status'] = 'success';
                $response['message'] = '';
                $response['lock'] = false;

            } else {
                // for wrong password
                $attempts = $user['user_attempt'] + 1;

                if ($attempts >= 3) {
                    // Lock account
                    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = :attempts, user_status = 'Locked' WHERE id = :id");
                    $update->execute(['attempts' => $attempts, 'id' => $user['id']]);

                    $response['status'] = 'error';
                    $response['message'] = 'Account locked due to 3 failed attempts.';
                    $response['lock'] = true;

                } else {
                    // Increment attempts
                    $update = $conn->prepare("UPDATE tbl_users SET user_attempt = :attempts WHERE id = :id");
                    $update->execute(['attempts' => $attempts, 'id' => $user['id']]);

                    $response['status'] = 'error';
                    $response['message'] = "Invalid username or password. Attempt $attempts of 3.";
                    $response['lock'] = false;
                }
            }
        }

    } else {
        $response['status'] = 'error';
        $response['message'] = 'User not found.';
        $response['lock'] = false;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
