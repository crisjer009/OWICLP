<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $db = new mysqli("localhost", "root", "", "clp");
    
    if ($db->connect_error) {
        echo json_encode(["status" => 0, "message" => "Database Connection Error"]);
        exit;
    }

    $username = isset($_POST['user']) ? strtolower(trim($_POST['user'])) : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

    // Updated Query to include user_role
    $stmt = $db->prepare("SELECT id, password, user_status, user_attempt, FirstName, LastName, user_role FROM tbl_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo json_encode(["status" => 2, "message" => "Invalid Username"]);
        exit;
    }

    // Handle Blocked logic
    if ($user['user_status'] === 'Blocked' || $user['user_status'] === 'L') {
        echo json_encode(["status" => 3, "message" => "Account Blocked. Contact Support."]);
        exit;
    }

    if ($user['password'] === $password) {
        // SUCCESS: Reset attempts and update login time
        $db->query("UPDATE tbl_users SET user_attempt = 0, last_logIn = NOW(), user_status = 'Active' WHERE id = " . $user['id']);
        
        // Store info in Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = $user['FirstName'] . " " . $user['LastName'];
        $_SESSION['user_role'] = (int)$user['user_role']; 
        $_SESSION['status'] = 'Active'; 
        
        // Designated Redirection based on role
        $redirectPath = ($user['user_role'] == 1 || $user['user_role'] == 3) ? 'admin_dashboard.php' : 'dashboard.php';
        
        echo json_encode([
            "status" => 1, 
            "message" => "Access Granted",
            "redirect" => $redirectPath
        ]);
    } else {
        $attempts = $user['user_attempt'] + 1;
        $newStatus = ($attempts >= 3) ? 'L' : $user['user_status'];
        
        $update = $db->prepare("UPDATE tbl_users SET user_attempt = ?, user_status = ? WHERE id = ?");
        $update->bind_param("isi", $attempts, $newStatus, $user['id']);
        $update->execute();
        
        if ($newStatus === 'L') {
            echo json_encode(["status" => 3, "message" => "Account Blocked due to multiple failed attempts."]);
        } else {
            echo json_encode(["status" => 2, "message" => "Invalid Password ($attempts/3)"]);
        }
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
    <link rel="icon" type="img/x-icon" href="logo/logo2.png"> 
    <style>
        :root { --brand-blue: #004a9b; --brand-pink: #e056fd; }
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body, html { margin: 0; padding: 0; height: 100%; width: 100%; overflow-x: hidden; background: linear-gradient(115deg, #ffffff 50%, #004a9b 50%); background-attachment: fixed; }
        .wrapper { display: flex; min-height: 100vh; width: 100%; }
        .side-left { flex: 1; color: white; display: flex; justify-content: center; align-items: center; padding: 60px; }
        .side-right { flex: 1.2; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .login-card { background: #ffffff; padding: 50px 40px; border-radius: 30px; width: 100%; max-width: 420px; text-align: center; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08); transition: all 0.5s ease; }
        .input-group { display: flex; align-items: center; border-bottom: 2px solid #eaeaea; margin-bottom: 30px; padding: 10px 0; }
        .input-group i { color: var(--brand-blue); font-size: 1.2rem; margin-right: 15px; width: 25px; }
        .input-group input { border: none; background: none; outline: none; flex: 1; font-size: 1rem; color: #333; }
        .login-btn { width: 100%; padding: 15px; border: none; border-radius: 50px; background-color: var(--brand-blue); color: white; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .login-btn:hover { background-color: #003670; transform: translateY(-2px); }
        .toggle-icon { color: #bbb; cursor: pointer; padding: 5px; }
        #response-msg { margin-top: 25px; min-height: 20px; }
        #contact-info { display: none; text-align: left; margin-top: 20px; padding: 15px; border-top: 1px dashed #ccc; color: #333; font-size: 0.85rem; }

        /* ---UI MOBILE MEDIA QUERIES --- */
        @media (max-width: 850px) {
            .side-left { display: none !important; } 
            .side-right { background: linear-gradient(135deg, #a2d2ff 0%, #004a9b 100%); width: 100%; }
            .login-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                margin: 20px;
                padding: 40px 25px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="side-left">
        <img src="logo/logo1.png" alt="CLP Logo" style="max-width:300px;">
    </div>

    <div class="side-right">
        <div class="login-card">
            <img src="logo/logo2.png" alt="CLP Logo" style="width:80px; margin-bottom:15px;">
            <div id="login-text">
                <h2 style="margin: 0; color: #333;">Welcome Back!</h2>
                <p style="color:#777; margin-bottom:35px;">Log in to your account</p>
            </div>

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
            
            <div id="contact-info">
                <div style="color: #c0392b; font-weight: bold; font-size: 1.1rem; margin-bottom: 10px;">Contact Us</div>
                <p>Office Warehouse, Inc.<br>Quezon City, Philippines</p>
                <strong>Tel:</strong> 02 8376-0877 <br>
                <strong>Email:</strong> info@officewarehouse.com.ph
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#username').on('input', function() {
        let val = $(this).val().toLowerCase().replace(/\s/g, ''); 
        $(this).val(val);
    });

    $('#togglepassword').on('click', function() {
        const passwordInput = $('#password');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        $(this).toggleClass('fa-eye-slash fa-eye');
    });

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const username = $('#username').val().trim();
        const rawPassword = $('#password').val();
        
        $.ajax({
            url: '', 
            method: 'POST',
            data: { 
                ajax: 1,
                user: username, 
                pass: btoa(rawPassword) // base64 encoded
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 1) { 
                    setTimeout(() => { window.location.href = res.redirect; }, 1000);
                } 
                else if(res.status === 3) {
                    // Logic: Hide form and show contact info
                    $('#response-msg').html('<span style="color: #c0392b; font-weight: bold;">' + res.message + '</span>');
                    $('#loginForm, #login-text').fadeOut(400, function() { 
                        $('#contact-info').fadeIn(400); 
                        $('.login-card').css('border', '1px solid #c0392b');
                    });
                }
                else { 
                    $('.login-btn').text('Log In').prop('disabled', false);
                    $('#response-msg').html('<span style="color: #e67e22;">' + res.message + '</span>');
                }
            },
            error: function() {
                $('.login-btn').text('Log In').prop('disabled', false);
                $('#response-msg').html('<span style="color: #e74c3c;">System Error.</span>');
            }
        });
    });
});
</script>
</body>
</html>