<?php
session_start();
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login Page</title> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
html, body { width: 100%; height: 100%; }
body { background: #94abd8; display: flex; justify-content: center; align-items: center; }

.container {
    display: flex;
    width: 80%; 
    max-width: 1000px;
    height: 600px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

/* right style */
.right {
    width: 50%;
    background: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 50px;
}

.right h1 { font-size: 2rem; font-weight: bold; margin-bottom: 10px; color: #222; }
.right p { font-size: 0.9rem; color: #0e0d0d; margin-bottom: 30px; }

.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 25px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.3s ease;
}
.login-box input:focus { border-color: #0066cc; }

.login-box button {
    width: 50%;          
    padding: 15px;
    background: #141618;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: background 0.3s ease;
    display: block;      
    margin: 0 auto 15px; 
}

.login-box button:hover { background: #004c99; }

.login-box a {
    display: block;
    margin-top: 10px;
    font-size: 0.8rem;
    color: #1f2020;
    text-decoration: none;
    text-align: center;
}
.login-box a:hover { text-decoration: underline; }

.message {
    margin-bottom: 15px;
    font-size: 0.9rem;
    text-align: center;
    color: red;
}
.success { color: green; }

/* left side style */
.left {
    width: 50%;
    background: #004b9b; 
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 40px;
}
.left h2 { font-size: 1.8rem; margin-bottom: 20px; }
.left p { font-size: 0.9rem; line-height: 1.5; color: #ddd; }



.social-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 25px;
}

.fa-google {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
    text-decoration: none;
    color: #EA4335;
    font-size: 22px;
    cursor: pointer;
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
    transition: all 0.25s ease;
}

.fa-google:hover { background: #fbfdff; }
    

 /* Responsive tablet */ 
@media (max-width:900px) {
 .container { 
    width: 90%;
    height:auto;
    flex-direction: column;
}

.left, .right {
    width: auto;
    padding: 0%;
    text-align: center;
}

.login-box button {
    width: 70%;
}
/*  Responsive Mobile Phones */
@media (max-width: 500px) {
    body {
        padding: 20px;
    }

    .container {
        width: 100%;
        border-radius: 10px;
    }

    .right h1 {
        font-size: 2.0rem;
    }

    .left h2 {
        font-size: 1.4rem;
    }

    .login-box input {
        padding: 10px;
        font-size: 0.85rem;
    }

    .login-box button {
        width: 100%;
        padding: 12px;
    }

    .left p, .right p {
        font-size: 0.85rem;
    }
    }
}
     
</style>
</head>
<body>

<div class="container">
    <div class="left">
        <h2>PixelBloom Studios</h2>
        <p>Where Productivity Meets Precision</p>
    </div>

    <div class="right">
        <h1>LOGIN FORM</h1>
        <p>Welcome Back!</p>

        <div class="message" id="message"><?php echo $message; ?></div>

        <div class="login-box">
            <form id="loginForm">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">LOG IN</button>
                <a href="#">Forgot Password?</a>
            </form>
        </div>
        <div class="social-icons">
    
    
    <!--  for google link connection -->
    <a href="https://www.google.com/" target="_blank" class="fa fa-google"></a>
    
    
</div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>

</body>
</html>
