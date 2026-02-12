
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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

<style>
* { 
    margin:0; 
    padding:0; 
    box-sizing:border-box; 
    font-family: 'Poppins', sans-serif; 
}

html, body { 
    width:100%; 
    height:100%; 
}

/*  violet and light gray  */
body { 
    display:flex; 
    justify-content:center; 
    align-items:center; 
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
}

/* Container */
.container {
    width: 80%;
    max-width: 1000px;
    height: 600px;
    display: grid;
    grid-template-columns: repeat(2,1fr);
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 24px rgba(0,0,0,0.2);
}

/* LEFT SIDE (WHITE WITH LOGO) */
.left {
    background:#ffffff;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

.left {
    transition: 
        opacity 0.5s ease,
        transform 0.5s ease,
        max-height 0.5s ease,
        padding 0.5s ease;
    overflow: hidden;
}


/* LOGO */
.left img{
    width:280px;
    max-width:100%;
    height:auto;
}

/* RIGHT SIDE */
.right {
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    padding:50px;
    text-align:center;
}

.right h1 { 
    font-size:2rem; 
    font-weight:bold; 
    margin-bottom:10px; 
    color: #fff;; 
}

.right p { 
    font-size:0.9rem; 
    color:#fff; 
    margin-bottom:30px; 
}

/* Message */
        .message { margin-bottom:15px; font-size:0.9rem; text-align:center; color:red; }
        .success { color:green; }

/* Login form inputs */
.login-box input {
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:25px;
            font-size:0.9rem;
            outline:none;
            transition:border-color 0.3s ease;
        }
        .login-box input:focus { 
            border-color:#0066cc; }

/* Button */
.login-box button {
            width:50%;
            padding:15px;
            background:#141618;
            color:#fff;
            font-weight:bold;
            border:none;
            border-radius:50px;
            cursor:pointer;
            transition:background 0.3s ease;
            margin:0 auto 15px;
            display:block;
        }
        .login-box button:hover { background:#004c99; }

/* Links */
.login-box a {
    display:block;
    margin-top:10px;
    font-size:0.8rem;
    color:#000;
    text-decoration:none;
}

.login-box a:hover { 
    text-decoration:underline; 
}

/* Responsive tablet */
        @media (max-width:900px) {
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
    }

    .container {
        width: 90%;
        max-width: 500px;
        height: auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        background: #fff;
        border-radius: 25px;
        padding: 35px 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .container:hover {
        transform: translateY(-3px);
    }

    /* Left and right sections stacked */
    .left, .right {
        width: 100%;
        padding: 0;
        text-align: center;
    }
    /* Animate left section out */
.left {
    opacity: 0;
    transform: translateY(-20px);
    max-height: 0;
    padding: 0;
}

/* Right section full */
.right {
    width: 100%;
    text-align: center;
}


    /* Adjust heading */
    .right h1 {
        font-size: 2rem;
        margin-bottom: 25px;
    }

    /* Inputs */
    .login-box input {
        width: 100%;
        padding: 14px 15px;
        font-size: 1rem;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 1px solid #d1d9e6;
        background: #f9f9f9;
        transition: all 0.3s ease;
    }

    .login-box input:focus {
        border-color: #0e0f0f;
        background: #fff;
        outline: none;
        box-shadow: 0 0 5px rgba(74,144,226,0.3);
    }

    /* Button full width with max 80% */
    .login-box button {
    width: 80%;
    max-width: 300px;
    padding: 15px;
    font-size: 1rem;
    border-radius: 10px;
    border: 2px solid #000;  /* black border */
    background-color: #fff;  /* white background */
    color: #000;             /* black text */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-box button:hover {
    background-color: #357abd; /* blue on hover */
    border-color: #357abd;     /* border also blue */
    color: #fff;               /* text becomes white */
    box-shadow: 0 6px 15px rgba(0,0,0,0.1); /* subtle shadow */
    transform: translateY(-2px); /* lift effect */
}


    /* Forgot password link */
    .login-box .forgot-password {
        display: block;
        text-align: center;
        margin-top: 15px;
        font-size: 0.85rem;
        color: #4a90e2;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .login-box .forgot-password:hover {
        color: #2a5c9b;
    }
}

        /* Responsive mobile */
@media (max-width:500px) {
    body {
        margin: 0;
        padding: 0;
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        width: 100%;
        max-width: 380px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .container:hover {
        transform: translateY(-3px);
    }

    /* Heading */
    .right h1 {
        font-size: 2rem;
        text-align: center;
        font-weight: 600;
        color: #000000;
        margin-bottom: 25px;
    }

    /* Inputs */
    .login-box input {
        width: 100%;
        padding: 14px 15px;
        font-size: 1rem;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 1px solid #d1d9e6;
        background: #f9f9f9;
        transition: all 0.3s ease;
    }

    .login-box input:focus {
        border-color: #e0e5eb;
        background: #fff;
        outline: none;
        box-shadow: 0 0 5px rgba(74,144,226,0.3);
    }

    /* Login button */
    .login-box button {
    width: 80%;
    max-width: 300px;
    padding: 15px;
    font-size: 1rem;
    border-radius: 10px;
    border: 2px solid #000;  
    background-color: #fff;  
    color: #000;             
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

    .login-box button:hover {
        background: linear-gradient(135deg, #496377, #2a5c9b);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .login-box .forgot-password {
        display: block;
        text-align: center;
        margin-top: 15px;
        font-size: 0.85rem;
        color: #4a90e2;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .login-box .forgot-password:hover {
        color: #2a5c9b;
    }

    
    /* Right section full width */
    .right {
        width: 100%;
        padding: 0;
    }
}
</style>
</head>
<body>
    <!-- LEFT SIDE WITH SVG LOGO -->
    <div class="container">

    <!-- LEFT SIDE WITH SVG LOGO -->
    <div class="left">
    <img src="../../../images/image.svg"> 
    </div>

    <!-- RIGHT SIDE LOGIN -->
    <div class="right">
        <h1>LOGIN FORM</h1>
        <p>Welcome Back!</p>

            <div class="message" id="message"><?php echo $message; ?></div>

            <div class="login-box">
                <form id="loginForm" method="post" action="process_login.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">LOG IN</button>
                    <a href="#">Forgot Password?</a>
                </form>
            </div>

        </div>
    </div>
    <!-- jQuery -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="Jquery.js"></script>
<script src="login.js"></script>
</body>
</html>
