<?php
// 1. BACKEND LOGIC: Process the request only if POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');

    // Database Connection
    $db = new mysqli("localhost", "root", "", "clp");

    if ($db->connect_error) {
        echo json_encode(["status" => "F", "message" => "Connection failed"]);
        exit;
    }

    // Safely capture data
    $username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

 

    // Database Query
    $query = "SELECT id, password, user_status, user_attempt FROM tbl_users WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo json_encode(["status" => "F", "message" => "Invalid Username"]);
        exit;
    }

    if ($user['user_status'] === 'Blocked' || $user['user_status'] === 'L') {
        echo json_encode(["status" => "B", "message" => "Account Blocked."]);
        exit;
    }

    // Password Check (Comparing Base64 strings)
    if ($user['password'] === $password) {
        $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = " . $user['id']);
        echo json_encode(["status" => "A", "message" => "Success"]);
    } else {
        $attempts = $user['user_attempt'] + 1;
        $newStatus = ($attempts >= 3) ? 'Blocked' : $user['user_status'];
        
        $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
        $update->bind_param("isi", $attempts, $newStatus, $user['id']);
        $update->execute();
        
        $msg = ($newStatus === 'Blocked') ? "Account Blocked due to 3 failed attempts." : "Invalid Password. Attempt $attempts/3";
        echo json_encode(["status" => "F", "message" => $msg]);
    }
    exit; // Stop executing to prevent rendering HTML for AJAX calls
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLP Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; height: 100vh; display: flex; justify-content: center; align-items: center; background-color: aliceblue; }
        .login-card {
            background: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2), 0 0 15px rgba(0, 74, 155, 0.5);
            border: 1px solid rgba(0, 74, 155, 0.4);
            transition: box-shadow 0.3s ease-in-out;
        }
        .login-card:hover { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 50px rgba(0, 74, 155, 0.4); }
        h1 { font-size: 2.5rem; margin-bottom: 10px; color: #004a9b; }
        .input-group { display: flex; align-items: center; border-bottom: 2px solid #ccc; margin-bottom: 25px; padding: 5px 0; }
        .input-group i { color: #333; font-size: 1.2rem; margin-right: 15px; }
        .input-group input { border: none; background: none; outline: none; flex: 1; font-size: 1rem; color: #333; }
        .toggle-icon { width: 20px; height: 20px; cursor: pointer; opacity: 0.7; }
        .login-btn { width: 100%; padding: 12px; border: none; border-radius: 50px; background-color: #004a9b; color: white; font-size: 1.1rem; cursor: pointer; }
        #response-msg { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-card">
    <h1>CLP User LogIn</h1>
    <p>Log in your Account</p>
    <form id="loginForm">
        <div class="input-group">
            <i class="fa-regular fa-user"></i>
            <input type="text" id="username" placeholder="username" maxlength="18" required>
        </div>
        
        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" placeholder="password" maxlength="15" minlength="8" required>
            <i class="fa-solid fa-eye-slash toggle-icon" id="togglepassword" style="cursor:pointer"></i>
        </div>

        <button type="submit" class="login-btn">Log In</button>
    </form>
    <div id="response-msg"></div>
</div>

<script>
$(document).ready(function() {
    // Force lowercase and limit to 18 characters
    $('#username').on('input', function() {
        let val = $(this).val().toLowerCase().replace(/\s/g, ''); 
        if (val.length > 18) val = val.substring(0, 18);
        $(this).val(val);
    });

    // Toggle Password Visibility
    $('#togglepassword').on('click', function() {
        const passwordInput = $('#password');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        $(this).toggleClass('fa-eye-slash fa-eye');
    });

    // Form Submission Logic
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const username = $('#username').val().trim();
        const rawPassword = $('#password').val();

        if (rawPassword.length < 8) {
            $('#response-msg').html('<span style="color: #ff6b6b;">Password must be at least 8 characters.</span>');
            return;
        }
        
        // AJAX Request to the SAME file
        $.ajax({
            url: '', // Empty URL posts to the current file
            method: 'POST',
            data: { 
                ajax: 1,
                user: username, 
                pass: btoa(rawPassword) // Base64 encoding
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'A') {
                    $('#response-msg').html('<span style="color: #4CAF50;">' + res.message + '</span>');
                    setTimeout(() => { window.location.href = 'dashboard.php'; }, 1000);
                } else {
                    $('#response-msg').html('<span style="color: #ff6b6b;">' + res.message + '</span>');
                }
            },
            error: function() {
                $('#response-msg').html('<span style="color: #ff6b6b;">Server Error. Check database connection.</span>');
            }
        });
    });
});
</script>

</body>
</html>