<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $db = new mysqli("localhost", "root", "", "clp");
    
    if ($db->connect_error) {
        echo json_encode(["status" => 0, "message" => "Database Connection Error"]);
        exit;
    }

    $username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

    $stmt = $db->prepare("SELECT id, password, user_status, user_attempt FROM tbl_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // No user found
    if (!$user) {
        echo json_encode(["status" => 2, "message" => "Invalid Username"]);
        exit;
    }

    // Check if blocked
    if ($user['user_status'] === 'Blocked' || $user['user_status'] === 'L') {
        echo json_encode(["status" => 3, "message" => "Account Blocked."]);
        exit;
    }

    // Password Check
    if ($user['password'] === $password) {
        $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'A' WHERE id = " . $user['id']);
        echo json_encode(["status" => 1, "message" => "Access Granted"]);
    } else {
        $attempts = $user['user_attempt'] + 1;
        $newStatus = ($attempts >= 3) ? 'Blocked' : $user['user_status'];
        
        $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
        $update->bind_param("isi", $attempts, $newStatus, $user['id']);
        $update->execute();
        
        $msg = ($newStatus === 'Blocked') ? "Account Blocked." : "Invalid Password ($attempts/3)";
        echo json_encode(["status" => 2, "message" => $msg]);
    }
    exit;
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
        :root { --brand-blue: #004a9b; --brand-pink: #e056fd; }
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        body, html { margin: 0; padding: 0; height: 100%; width: 100%; overflow-x: hidden; }

        /* Main Container for Split Screen */
        .wrapper { display: flex; min-height: 100vh; width: 100%; }

        /* LEFT SIDE: Branding */
        .side-left {
            flex: 1;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            text-align: center;
        }
        .side-left .brand-logo-img { height: auto; margin-bottom: 20px; }
        .side-left p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 30px; }

        /* RIGHT SIDE: for log in  */
        .side-right {
            flex: 1.2;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Login Card Styling */
        .login-card {
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 30px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .login-card .brand-logo-img { width: 80px; margin-bottom: 15px; }
        .login-card p { color: #777; margin-bottom: 35px; font-size: 0.95rem; }

        /* Inputs */
        .input-group { 
            display: flex; 
            align-items: center; 
            border-bottom: 2px solid #eaeaea; 
            margin-bottom: 30px; 
            padding: 10px 0;
            transition: border-color 0.3s;
        }
        .input-group:focus-within { border-color: var(--brand-blue); }
        .input-group i:not(.toggle-icon) { color: var(--brand-blue); font-size: 1.2rem; margin-right: 15px; width: 25px; }
        .input-group input { border: none; background: none; outline: none; flex: 1; font-size: 1rem; color: #333; }
        
        .toggle-icon { color: #bbb; cursor: pointer; padding: 5px; }
        .toggle-icon:hover { color: var(--brand-blue); }

       /* .brand-address {
        color: #333 !important; 
        font-size: 1rem; 
        line-height: 1;
        max-width: 280px;
        margin: 10px auto;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(255, 255, 255, 0.2); 
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-block;
        }
        */

        .login-btn { 
            width: 100%; 
            padding: 15px; 
            border: none; 
            border-radius: 50px; 
            background-color: var(--brand-blue); 
            color: white; 
            font-size: 1.1rem; 
            font-weight: 600;
            cursor: pointer; 
            box-shadow: 0 5px 15px rgba(0, 74, 155, 0.3);
            transition: 0.3s;
        }
        .login-btn:hover { background-color: #003670; transform: translateY(-2px); }

        #response-msg { margin-top: 25px; min-height: 20px; }

        /* mobile responsiveness */
        @media (max-width: 850px) {
            .side-left { display: none; } 
            .side-right { 
                background: linear-gradient(135deg, #a2d2ff 0%, #004a9b 100%); 
                width: 100%;
            }
            .login-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(15px);
                margin: 20px;
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
   <div class="side-left">
    <div class="logo-box">
        <img src="logo/logo1.png" alt="CLP Logo" class="brand-logo-img">
    </div>
</div>

    <div class="side-right">
        <div class="login-card">
            <img src="logo/logo2.png" alt="CLP Logo" class="brand-logo-img">
            <h2 style="margin: 0; color: #333;">Welcome Back!</h2>
            <p>Log in to your account</p>

            <form id="loginForm">
                <div class="input-group">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" id="username" placeholder="Username" maxlength="18" required>
                </div>
                
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" placeholder="Password" maxlength="15" minlength="8" required>
                    <i class="fa-solid fa-eye-slash toggle-icon" id="togglepassword"></i>
                </div>

                <button type="submit" class="login-btn">Log In</button>
            </form>
            <div id="response-msg"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // 1. Username formatting
    $('#username').on('input', function() {
        let val = $(this).val().toLowerCase().replace(/\s/g, ''); 
        if (val.length > 18) val = val.substring(0, 18);
        $(this).val(val);
    });

    // 2. Toggle Visibility
    $('#togglepassword').on('click', function() {
        const passwordInput = $('#password');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        $(this).toggleClass('fa-eye-slash fa-eye');
    });

    // 3. AJAX Submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const username = $('#username').val().trim();
        const rawPassword = $('#password').val();

        if (rawPassword.length < 8) {
            $('#response-msg').html('<span style="color: #e74c3c;">Minimum 8 characters required.</span>');
            return;
        }
        
        // Show a "loading" state on button
        $('.login-btn').text('Checking...').prop('disabled', true);
        
        $.ajax({
            url: '', 
            method: 'POST',
            data: { 
                ajax: 1,
                user: username, 
                pass: btoa(rawPassword) 
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 1) { 
                    // if login is success
                    $('.login-btn').text('Log In').prop('disabled', false);
                    $('#response-msg').html('<span style="color: #27ae60; font-weight: bold;">Welcome! Redirecting...</span>');
                    setTimeout(() => { window.location.href = 'dashboard.php'; }, 1000);
                } 
                else if(res.status === 3) {
                    // unavailable login form
                    $('#response-msg').html('<span style="color: #c0392b; font-weight: bold;">' + res.message + '</span>');
                    
                    // disable inputs
                    $('#username, #password').prop('disabled', true).css({
                        'background-color': '#f2f2f2',
                        'cursor': 'not-allowed'
                    });

                    // disable Button
                    $('.login-btn').text('Account Locked').prop('disabled', true).css({
                        'opacity': '0.6',
                        'cursor': 'not-allowed',
                        'background': '#666'
                    });

                    //hide the icons
                    $('#togglepassword').hide();
                }
                else { 
                    // FAILED (status 2 or other)
                    $('.login-btn').text('Log In').prop('disabled', false);
                    $('#response-msg').html('<span style="color: #e67e22;">' + res.message + '</span>');
                    $('#password').val('').focus(); // Clear and focus for retry
                }
            },
            error: function() {
                $('.login-btn').text('Log In').prop('disabled', false);
                $('#response-msg').html('<span style="color: #e74c3c;">System Error. Try again later.</span>');
            }
        });
    });
});
</script>

</body>
</html>