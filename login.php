<?php
// session_start();
// require 'db.php';

// $error = "";

// if($_SERVER["REQUEST_METHOD"] == "POST"){

//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
//     $stmt->execute([$username]);
//     $user = $stmt->fetch();

//     if($user && password_verify($password, $user['password'])){
//         $_SESSION['user'] = $user['fullname'];
//         header("Location: dashboard.php");
//         exit;
//     }else{
//         $error = "Invalid username or password.";
//     }
// }
?>

<!DOCTYPE html>
<html>
<head>
<title>System Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    height:100vh;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Poppins', sans-serif;
}

.login-card{
    width:380px;
    padding:35px;
    border-radius:20px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    color:white;
    box-shadow: 0 10px 40px rgba(0,0,0,.4);
}

.form-control{
    border-radius:12px;
}

.btn-login{
    border-radius:12px;
    font-weight:600;
}

.title{
    font-weight:700;
    letter-spacing:1px;
}

</style>
</head>

<body>

<div class="login-card">

    <h3 class="text-center mb-4 title">🔐 SYSTEM LOGIN</h3>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <input type="text" name="username" class="form-control"
                   placeholder="Username" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password"
                   class="form-control"
                   placeholder="Password" required>
        </div>

        <button class="btn btn-warning w-100 btn-login">
            Login
        </button>

    </form>

</div>

</body>
</html>
