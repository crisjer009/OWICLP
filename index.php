<?php
session_start();
require 'connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | IT Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eaf2ff, #f8fbff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .login-card {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 74, 155, 0.15);
            border: 1px solid rgba(0, 74, 155, 0.1);
            margin-right: -70px;
            margin-bottom: -40px;
            
        }

        .divider-text {
            color: #004a9b;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #004a9b;
        }

        .input-group-text {
            border-color: #004a9b;
            color: #004a9b;
        }

        .form-control {
            border-color: #004a9b;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: #004a9b;
            box-shadow: 0 0 0 0.25rem rgba(0, 74, 155, 0.1);
        }

        .btn-primary {
            background: #004a9b;
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #003670;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 74, 155, 0.3);
        }

        footer {
            background: #004a9b;
            color: white;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
                margin: 0 10px;
            }
            .divider-text {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="container">
        <div class="row g-5 align-items-center justify-content-center">
            
            <div class="col-md-6 col-lg-6 d-none d-md-block text-center">
                <img src="images/owi logo 1.png" class="img-fluid" alt="Branding Image" style="max-height: 400px;">
            </div>
            
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="login-card">
                    <form id="loginForm">
                        <div class="text-center mb-4">
                            <div class="divider-text">
                                <img src="images/owi.jpg" alt="Logo" style="width:40px; border-radius: 5px;">
                                CUSTOMER LOYALTY PROGRAM
                            </div>
                            <div class="login-title">LOG IN</div>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-envelope"></i></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Email address" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                <span class="input-group-text bg-white toggle-password" style="cursor:pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div> 
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label small" for="rememberMe">Remember me</label>
                            </div>
                            <a href="#!" class="small text-decoration-none" style="color: #004a9b;">Forgot password?</a>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                            <p class="small fw-bold mb-0">
                                Don't have an account? <a href="#!" class="text-danger text-decoration-none">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div> 

        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        &copy; 2026 Office Warehouse Inc. All Rights Reserved.
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    // Toggle Password Visibility
    $('.toggle-password').on('click', function () {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // AJAX Login
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const username = $('#username').val();
        const password = $('#password').val();

        $.ajax({
            url: 'login_process.php',
            type: 'POST',
            data: {username: username, password: password},
            success: function(response) {
                if (response.includes('Login successful')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Redirecting...',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                       
                    });
                    $('head').append(response);
                } else {
                    // AUTO CLEAR THE INPUTS
                    $('#username, #password').val(''); 
                    
                    // FOCUS ON THE FIRST INPUT
                    $('#username').focus();

                    // SHOW ERROR MESSAGE
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        html: response, // This will display your "Locked" or "Incorrect" message from PHP
                        confirmButtonColor: '#004a9b'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Could not connect to the server.',
                    confirmButtonColor: '#004a9b'
                });
            }
        });
    });
});
</script>
</body>
</html>