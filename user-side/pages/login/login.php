
<?php
session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

$systemName = isset($_GET['system']) ? ucfirst($_GET['system']) : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>

<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
html, body {
    width: 100%;
    height: 100%;
}
body {
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
}
.container {
    width: 80%;
    max-width: 1000px;
    height: 600px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 24px rgba(0,0,0,0.2);
}
.left {
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    transition:
        opacity 0.5s ease,
        transform 0.5s ease,
        max-height 0.5s ease,
        padding 0.5s ease;
    overflow: hidden;
}
.left img {
    width: 280px;
    max-width: 100%;
    height: auto;
}
.right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px;
    text-align: center;
}
.right h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #fff;
}
.right p {
    font-size: 0.9rem;
    color: #fff;
    margin-bottom: 30px;
}
.message {
    margin-bottom: 15px;
    font-size: 0.9rem;
    text-align: center;
    color: red;
}
.success {
    color: green;
}
.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 25px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.3s ease, background 0.3s ease;
}
.login-box input:focus {
    border-color: #0066cc;
    background: #fff;
}
.login-box input::placeholder {
    color: #999;
}
    
 /* home */
.right-header {
    width: 100%;
    display: flex;
    justify-content: flex-start; 
    margin-bottom: 30px;         
}

.home-btn {
    padding: 10px 25px;
    font-size: 0.9rem;
    color: #fff;
    background:(135deg, rgb(2, 0, 36), #4b4a4af6);
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
}




    
.login_btn {
    width: 80%;
    max-width: 300px;
    padding: 15px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 10px;
    border: 2px solid #000;
    background-color: #fff;
    color: #000;
    cursor: pointer;
    transition: all 0.3s ease;
    display: block;
    margin: 0 auto 15px;
}
.login_btn:hover:not(:disabled) {
    background-color: #18191a;
    border-color: #dadfe4;
    color: #fff;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
.login_btn:disabled {
    background-color: #999;
    border-color: #999;
    color: #666;
    cursor: not-allowed;
}

.right-header {
    width: 100%;
    display: flex;
    justify-content: flex-start; 
    margin-bottom: 30px;         
}
 /* home button*/
.home-btn {
    padding: 10px 25px;
    font-size: 0.9rem;
    color: #fff;
    background:(135deg, rgb(2, 0, 36), #4b4a4af6);
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
}



.login-box a, .login-box .forgot-password {
    display: block;
    margin-top: 10px;
    font-size: 0.85rem;
    color: #4a90e2;
    text-decoration: none;
    text-align: center;
    transition: color 0.3s ease;
}
.login-box a:hover, .login-box .forgot-password:hover {
    color: #2a5c9b;
}
.spinner {
    width: 18px;
    height: 18px;
    border: 3px solid #fff;
    border-top: 3px solid transparent;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
    animation: spin 1s linear infinite;
    vertical-align: middle;
}
@keyframes spin {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}
/* Responsive tablet */
@media (max-width: 900px) {
    .container {
        width: 90%;
        max-width: 500px;
        height: auto;
        grid-template-columns: 1fr;
        background: #272525a1;
        border-radius: 25px;
        padding: 35px 25px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    .container:hover {
        transform: translateY(-3px);
    }
    .left {
        opacity: 0;
        transform: translateY(-20px);
        max-height: 0;
        padding: 0;
    }
    .right {
        width: 100%;
        text-align: center;
    }
    .right h1 {
        font-size: 2rem;
        margin-bottom: 25px;
    }
    .login-box input {
        width: 100%;
        padding: 14px 15px;
        font-size: 1rem;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 1px solid #d1d9e6;
        background: #f9f9f9;
    }
    .login-box input:focus {
        border-color: #0e0f0f;
        box-shadow: 0 0 5px rgba(74,144,226,0.3);
    }
}
/* Responsive mobile  */
@media (max-width: 500px) {
    .container {
        display: flex;
        flex-direction: column; 
        
        padding: 20px; 
        width: 95%;    
        margin: 0 auto;
    }

    .left, .right {
        width: 100%;   
        padding: 10px 0;
    }

    .right h1 {
        font-size: 1.6rem; 
        line-height: 1.2;
    }

    .right p {
        font-size: 0.9rem;
        line-height: 1.5; 
    }

    img {
        max-width: 100%;
        height: auto;
    }
}
</style>
</head>
<body>

<div class="container">
    <div class="left">
        <img src="/images/image.svg" alt="Office Warehouse Logo" />
    </div>

    <div class="right">
        <div class="right-header">
        <a href="/index.php" class="home-btn">Home</a>
    </div>
        <h1>LOGIN FORM</h1>
        <p>Welcome Back!</p>
        <div class="login-box">
            <p id="err_mes" class="message"></p>
            
            <form method="post" id="login_form" autocomplete="off" novalidate>
                <input type="text" name="username" placeholder="Username" required autocomplete="username" />
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                <button type="submit" class="login_btn" disabled>Login</button>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {
    const $username = $('input[name="username"]');
    const $password = $('input[name="password"]');
    const $submitBtn = $('.login_btn');
    const $message = $('#err_mes');

    function checkInputs() {
        const usernameVal = $username.val().trim();
        const passwordVal = $password.val().trim();

        if (!usernameVal && !passwordVal) {
            $message.text('Please input username and password.').css('color', 'red');
            $submitBtn.prop('disabled', true);
        } else if (!usernameVal) {
            $message.text('Please input username.').css('color', 'red');
            $submitBtn.prop('disabled', true);
        } else if (!passwordVal) {
            $message.text('Please input password.').css('color', 'red');
            $submitBtn.prop('disabled', true);
        } else {
            $message.text('');
            $submitBtn.prop('disabled', false);
        }
    }

    $username.on('input', checkInputs);
    $password.on('input', checkInputs);

    $('#login_form').on('submit', function (e) {
        e.preventDefault();

        const username = $username.val().trim();
        const password = $password.val().trim();

        if (!username || !password) {
            checkInputs();
            return false;
        }

        // Show spinner and disable button
        if (!$submitBtn.find('.spinner').length) {
            $submitBtn.prepend('<span class="spinner"></span>');
        }
        $submitBtn.prop('disabled', true);
        $message.text('');

        $.ajax({
            url: 'login_process.php',
            type: 'POST',
            dataType: 'json',
            data: { username, password },
            success: function (response) {
                $submitBtn.find('.spinner').remove();
                if (response.status === 'success') {
                    $message.text(response.message).css('color', 'green');
                    // Redirect after a short delay so user can see the success message
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 800);
                } else {
                    $message.text(response.message).css('color', 'red');
                    $submitBtn.prop('disabled', false);
                }
            },
            error: function () {
                $submitBtn.find('.spinner').remove();
                $message.text('An error occurred. Please try again.').css('color', 'red');
                $submitBtn.prop('disabled', false);
            }
        });
    });

    checkInputs();
});
</script>

</body>
</html>
