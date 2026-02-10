<?php
session_start();
require 'connection.php'; // connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #eaf2ff, #f8fbff);
    }

    .program-icon{
      font-size: 1.2 rem;
      color: #004a9b;
    } 
    .login-title{
      text-align: center;
      font-size: 1rem;
      letter-spacing: 1px;
      color: #004a9b;
      margin-top:0.5rem;
    }
    .login-card{
      background-color: #ffffff;
      border-radius:16px;
      padding:2.5rem 2rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);

    }
    .divider-text{
      white-space: nowrap;
      color: #004a9b;
      font-weight: 700;
      text-align: center;
      font-size: 1.8rem;
      letter-spacing: 0.5px;
    }
    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }
    .h-custom {
      height: calc(100% - 73px);
    }
     @media (max-width: 450px) {
      .h-custom {
       height: 100%;
     }
    }
    
    .form-label {
        font-weight: 500;
        color: #004a9b;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
    .form-control:before{
      border-color: #004a9b;

    }

    .form-control:focus {
        border-color: #004a9b;
        box-shadow: 0 0 0 0.15rem rgba(0, 74, 155, 0.25);
    }

    .btn-primary {
        background: #004a9b;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 74, 155, 0.3);
    }

    .forgot-link {
        font-size: 0.85rem;
        color: #004a9b;
        text-decoration: none;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .register-link {
        color: #d63384;
        text-decoration: none;
    }

    .register-link:hover {
        text-decoration: underline;
    }

    footer {
        background: #004a9b;
        height: 5px;
        padding:10px;
    }

    footer a {
        transition: transform 0.3s ease;
    }

    footer a:hover {
        transform: scale(1.15);
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 2rem 1.5rem;
        }
    }
</style>
</head>
<body>
  <section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="images/owi logo 1.png"
          class="img-fluid" alt="Sample image">
      </div>
      
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1" 
      style="background:#ffffff; padding:20px; width:40%; height:100%; box-shadow: 0 5px 20px 0.20rem #004a9b; border-radius: 20px; margin-top:30px;">
        <form id="loginForm">
           <!-- Customer Loyalty Program Header -->
          <div class="my-4">
            <p class="divider-text d-flex justify-content-center align-items-center gap-2 mb-2"><img src="images/owi.jpg" alt="Logo" class="program-logo" style="width:40px;">Customer Loyalty Program</p>
            <div class="login-title">
              LOG IN YOUR ACCOUNT<br>
            </div>
          </div>
        
          <div class="mb-4">
            <label class="form-label">Username</label>
            <div class="input-group">
                 <span class="input-group-text bg-white border-end-0" style= "border-color:#004a9b">
                   <i class="fas fa-envelope text-primary"></i>
                 </span>
             <input type="text" id="username" name="username" class="form-control form-control-lg border-start-0" style="width:80%; border-color:#004a9b"placeholder="Enter a valid email address">
           </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0" style="border-color:#004a9b"> <i class="fas fa-lock text-primary">
              </i></span>
              <input type="password" id="password" name="password" class="form-control form-control-lg border-start-0 border-end-0" style="border-color:#004a9b"placeholder="Enter your password">
              <span class="input-group-text bg-white border-start-0 toggle-password" style="cursor:pointer; border-color:#004a9b;"><i class="fas fa-eye text-primary"></i></span>
            </div> 
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 10.5rem; padding-right: 10.5rem; margin-left: 40px;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0" style="margin-left:120px;">Don't have an account? <a href="#!"
                class="link-danger">Register</a></p>
          </div>
        </form>
      </div> 
    </div>
  </div>
  
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loginModalMessage">
          <!-- Message will appear here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-l-4 bg-primary"
   style="height:30px; margin-top:20px;">
    <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
       © 2026 Office Warehouse Inc. All Rights Reserved.
    </div>
    <!-- Copyright -->
  </div>
</section>
<script>
  //show password
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
  });

  //login validation
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        $.ajax({
            url: 'login_process.php',
            type: 'POST',
            data: {username: username, password: password},
           success: function(response) {

    // SUCCESS
    if (response.includes('Login successful')) {
        Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            html: response,
            timer: 1500,
            showConfirmButton: false
        });
    } 
    // ERROR / WARNING
    else {
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            html: response,
            confirmButtonColor: '#004a9b'
        });
    }
}

        });
    });
</script>
</body>
</html>