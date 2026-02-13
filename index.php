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
            background: linear-gradient(rgba(218, 219, 207, 0.3), rgba(214, 216, 184, 0.27)), 
                        url('images/bg_login yellow.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-card {
            background: #ffffff;
            padding: 2rem;
            padding-left:20px;
            padding-right:20px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(62, 62, 39, 0.4);
            border: 1px solid rgba(97, 95, 28, 0.1);
            width: 450px;
        }
        @media (min-width: 820px) {
            .login-card {
                margin-left:-55px; 
            }
        }
        .divider-text {
            color: #E1AD01;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .divider-text h2 {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            margin: 0;
            font-weight: 800;
        }

        .form-label {
            font-weight: 500;
            color: black;
        }

        .input-group-text {
            border-color: #ced4da;
            color: #bea933;
        }

        .form-control {
            border-color: #ced4da;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: #E1AD01;
            box-shadow: 0 0 0 0.25rem rgba(227, 205, 82, 0.2);
        }

        .btn-primary {
            background: #E1AD01;
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 10px;
            color: black;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: black;
            color: #E1AD01;
            transform: translateY(-2px);
        }
        .side-left { flex: 1; color: white; display: flex; justify-content: center; align-items: center;  }
        .side-right { flex: 1.2; display: flex; justify-content: center; align-items: center; padding: 20px; }
          @media (max-width: 850px) {
            .side-left { display: none !important; } 
            .side-right { width: 100%; }
            .login-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                margin: 20px;
                padding: 40px 25px;
                width: 90%;
            }
        }
         @media (max-width: 820px) {
            .side-left { display: none !important; } 
            .side-right { width: 100%; }
            .login-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                margin: 20px;
                padding: 40px 25px;
                width: 100%;
            }
        }
        footer {
            background: #313131;
            color: white;
            padding:2px 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="main-wrapper">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="side-left">
                <img src="images/clp new.png" class="img-fluid" alt="Branding Image" style="max-height: 900px; margin-left:-90px;">
            </div>
            <div class="side-right">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="login-card">
                    <form id="loginForm">
                        <div class="text-center mb-4">
                            <div class="divider-text mb-2">
                                <img src="images/owi.jpg" alt="Logo" style="width:50px; border-radius: 5px; ">
                                <h2>WELCOME</h2>
                            </div>
                            <div class="login-title" style="font-size:14px; color: #666;">LOG IN YOUR DETAILS</div>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
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
                        <div class="d-flex justify-content-end mb-4">
                            <a href="#!" class="small text-decoration-none" style="color: black;">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    </form>
                </div>
            </div> 
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container text-center">
         Version 3.0.3    
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
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
                        }).then(() => { window.location.href = "helpdesk_dashboard.php"; });
                    } else {
                        $('#username, #password').val(''); 
                        $('#username').focus();
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            html: response,
                            confirmButtonColor: '#E1AD01'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'System Error',
                        text: 'Could not connect to the server.',
                        confirmButtonColor: '#E1AD01'
                    });
                }
            });
        });
    });
</script>
</body>
</html>