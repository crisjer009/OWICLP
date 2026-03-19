<?php
// Correct absolute relative path
require_once __DIR__ . '/../../../db_connection.php'; 
$token = $_GET['token'] ?? '';
$message = '';
$success = false;

if ($token) {
    $stmt = $pdo->prepare("UPDATE employees SET is_verified = 1 WHERE verification_token = ? AND is_verified = 0");
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $message = "Your email has been verified! You can now log in.";
        $success = true;
    } else {
        $message = "Invalid token or email already verified.";
    }
} else {
    $message = "No token provided.";
}

$accent      = '#8bacf6'; 
$accent_rgb  = '139, 172, 246';
$accent_dark = '#0a0e1a';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email Verification</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
    :root {
        --accent: <?php echo $accent; ?>;
        --accent-rgb: <?php echo $accent_rgb; ?>;
        --bg-dark: <?php echo $accent_dark; ?>;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
        --ease: cubic-bezier(0.16, 1, 0.3, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

    body {
        min-height: 100vh; 
        background-color: var(--bg-dark);
        background-image: 
        radial-gradient(at 0% 0%, rgba(var(--accent-rgb), 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(var(--accent-rgb), 0.1) 0px, transparent 50%);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        color: white;
        position: relative;
    }

    body::before {
        content: ""; 
        position: absolute; 
        width: 100%; 
        height: 100%;
        background: url('https://grainy-gradients.vercel.app/noise.svg');
        opacity: 0.15; 
        pointer-events: none; 
        top: 0; left: 0;
    }

    .verify-container {
        background: var(--glass);
        backdrop-filter: blur(40px) saturate(150%);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        padding: 60px;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        animation: slideUp 0.8s var(--ease);
        z-index: 10;
    }

    .verify-container h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .verify-message {
        font-size: 1.05rem;
        margin-bottom: 30px;
        color: <?php echo $success ? '#83cd6a' : '#ff6b6b'; ?>;
    }

    .btn-login {
        padding: 15px 30px;
        border-radius: 14px;
        background: var(--accent);
        color: var(--bg-dark);
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        transition: 0.3s;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(var(--accent-rgb), 0.2);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>

<div class="verify-container">
    <h1>Email Verification</h1>
    <p class="verify-message"><?php echo $message; ?></p>
    <a href="/OLD_OWICLP/user-side/pages/login/loginn.php" class="btn-login">
                        <?php echo $success ? 'Go to Login' : 'Back to Login'; ?>
    </a>
</div>

</body>
</html>