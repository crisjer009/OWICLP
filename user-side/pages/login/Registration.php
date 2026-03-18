<?php
session_start();

// === Load Composer & dotenv ===
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// === Database Connection ===
require '../../../db_connection.php';

if (!isset($pdo)) {
    die("Database connection failed.");
}

// === Fetch Departments ===
$stmt = $pdo->query("SELECT * FROM departments ORDER BY department_name ASC");
$departments = $stmt->fetchAll();

// System settings
$systemName = isset($_GET['system']) ? ucfirst($_GET['system']) : '';
$accent      = '#8bacf6'; 
$accent_rgb  = '139, 172, 246';
$accent_dark = '#0a0e1a';

$serverError = '';

// === Handle Form Submission ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Validation ---
    if (empty($fname) || empty($lname) || empty($department) || empty($email) || empty($password)) {
        $serverError = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $serverError = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $serverError = "Passwords do not match!";
    } else {
        // --- Check if email exists ---
        $check = $pdo->prepare("SELECT id FROM employees WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $serverError = "Email already registered!";
        } else {
            // --- Generate Employee ID ---
            $stmt = $pdo->query("SELECT MAX(id) as max_id FROM employees");
            $row = $stmt->fetch();
            $nextID = ($row['max_id'] ?? 0) + 1;
            $employeeID = "OWI-2024-" . str_pad($nextID, 3, '0', STR_PAD_LEFT);

            // --- Hash password ---
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // --- Generate verification token ---
            $token = bin2hex(random_bytes(16));
            $verifyLink = rtrim($_ENV['APP_URL'], '/') . "/user-side/pages/login/verify.php?token=" . $token;

            // --- Insert into database ---
            $insert = $pdo->prepare("
                INSERT INTO employees 
                (employee_id, first_name, last_name, department, email, password, is_verified, verification_token) 
                VALUES (?, ?, ?, ?, ?, ?, 0, ?)
            ");

            $insert->execute([
                $employeeID,
                $fname,
                $lname,
                $department,
                $email,
                $hashedPassword,
                $token
            ]);

            // --- Send Verification Email ---
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME'];
                $mail->Password   = $_ENV['MAIL_PASSWORD'];
                $mail->SMTPSecure = $_ENV['SMTP_SECURE'] ?? 'tls';
                $mail->Port       = $_ENV['SMTP_PORT'] ?? 587;

                $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_NAME']);
                $mail->addAddress($email, $fname . ' ' . $lname);

                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Account';
                $mail->Body    = "
                    Hi $fname,<br><br>
                    Please verify your email by clicking the link below:<br><br>
                    <a href='$verifyLink'>$verifyLink</a><br><br>
                    Thank you!
                ";
                $mail->AltBody = "Verify your account: $verifyLink";

                $mail->send();

                $_SESSION['success'] = "Registration successful! Please check your email.";
                header("Location: /UI/UX/login.php");
                exit;

            } catch (Exception $e) {
                $serverError = "Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account</title>
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
        padding: 40px 20px;
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
        top: 0; 
        left: 0;
    }

    .reg-container {
        display: flex;
        width: 1100px;
        min-height: 700px;
        background: var(--glass);
        backdrop-filter: blur(40px) saturate(150%);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.8);
        z-index: 10;
        animation: slideUp 0.8s var(--ease);
    }

    .reg-left {
        flex: 0.8;
        padding: 60px;
        background: linear-gradient(135deg, rgba(var(--accent-rgb), 0.1) 0%, transparent 100%);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .icon-wrapper {
        width: 60px; height: 60px;
        background: var(--accent);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 30px;
        box-shadow: 0 0 30px rgba(var(--accent-rgb), 0.3);
    }

    .reg-left h1 { 
        font-size: 2.5rem; 
        font-weight: 800;
        letter-spacing: -1.5px;
        margin-bottom: 15px;
    }

    .reg-left p { 
        color: rgba(255,255,255,0.5); 
        line-height: 1.6; font-size: 0.95rem; 
    }

    .reg-right { flex: 1.5; padding: 60px; }

    .status-badge {
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        background: rgba(var(--accent-rgb), 0.1);
        border: 1px solid rgba(var(--accent-rgb), 0.3);
        color: var(--accent);
        padding: 6px 16px; 
        border-radius: 100px;
        font-size: 0.7rem; 
        font-weight: 800; 
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .error-text {
    color: #ff6b6b;
    font-size: 0.75rem;
    margin-top: 6px;
    display: none;
}

.input-error {
    border-color: #ff6b6b !important;
    box-shadow: 0 0 10px rgba(255, 107, 107, 0.2);
}

.input-success {
    border-color: #4caf50 !important;
}


    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .form-group { position: relative; }
    .form-group.full-width { grid-column: span 2; }

    .form-group label {
        display: block; font-size: 0.7rem; font-weight: 600;
        color: rgba(255,255,255,0.4); margin-bottom: 8px;
        text-transform: uppercase; letter-spacing: 1px;
    }

    .form-group input, .form-group select {
        width: 100%;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--glass-border);
        padding: 16px 20px;
        border-radius: 14px;
        color: white;
        font-size: 0.9rem;
        transition: 0.3s var(--ease);
    }

    .form-group select option { background: #1a1a1a; color: white; }

    .form-group input:focus, .form-group select:focus {
        outline: none; border-color: var(--accent);
        background: rgba(255,255,255,0.07);
        box-shadow: 0 0 20px rgba(var(--accent-rgb), 0.1);
    }

    .btn-reg {
        width: 100%;
        padding: 18px;
        background: var(--accent);
        color: var(--bg-dark);
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        transition: 0.4s var(--ease);
    }

    .btn-reg:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(var(--accent-rgb), 0.2);
    }

    .footer-links {
        margin-top: 25px;
        text-align: center;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.4);
    }

    .footer-links a { color: var(--accent); text-decoration: none; font-weight: 600; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
        .reg-container { flex-direction: column; width: 100%; border-radius: 20px; }
        .reg-left { padding: 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: span 1; }
    }
</style>
</head>
<body>

<div class="reg-container">
    <div class="reg-left">
        <div class="icon-wrapper">
            <svg viewBox="0 0 24 24" 
            fill="none" 
            stroke="currentColor" 
            stroke-width="2.5" 
            stroke-linecap="round" 
            stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
        </div>
        <h1>Create Account</h1>
        <p>Please fill in your details to get started with your professional workspace.</p>
    </div>

    <div class="reg-right">
        <div class="status-badge">Registration Portal</div>
        
        <form method="POST" novalidate>
            <div class="form-grid">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="firstname" placeholder="John" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lastname" placeholder="Doe" required>
                </div>
                <div class="form-group full-width">
                    <label>Employee ID</label>
                    <input type="text" value="OWI--XXXX"disabled>
                </div>
                <div class="form-group">
              <label>Department</label>
             <select name="department" required>
           <option value="" disabled selected>Select Department</option>

                 <?php foreach ($departments as $dept): ?>
                 <option value="<?= htmlspecialchars($dept['department_name']); ?>">
                <?= htmlspecialchars($dept['department_name']); ?>
              </option>
          <?php endforeach; ?>
          </select>
            </div>
            
                <div class="form-group">
                 <label>Email Address</label>
                 <input type="email" id="email" name="email" placeholder="john.doe@company.com" required>
                <small id="emailError" class="error-text">Invalid email format</small>
                </div>

                 <div class="form-group">
                 <label>Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                 </div>

                <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                <small id="passwordError" class="error-text">Passwords do not match</small>
                </div>

            <button type="submit" class="btn-reg">CREATE ACCOUNT</button>
            
            <div class="footer-links">
                Already have an account? <a href="/UI/UX/draft4.php? echo $systemName; ?>">Log in here</a>
            </div>
        </form>
    </div>
</div>

<script>
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');

    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    email.addEventListener('input', () => {
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/; // alphanumeric

     if (!email.value.match(emailPattern)) {
        emailError.style.display = 'block';
        email.classList.add('input-error');
        email.classList.remove('input-success');
     } else {
        emailError.style.display = 'none';
        email.classList.remove('input-error');
        email.classList.add('input-success');
    }
});

    function validatePassword() {
    if (confirmPassword.value === "") {
        passwordError.style.display = 'none';
        confirmPassword.classList.remove('input-error');
        return;
    }

    if (password.value !== confirmPassword.value) {
        passwordError.style.display = 'block';
        confirmPassword.classList.add('input-error');
    } else {
        passwordError.style.display = 'none';
        confirmPassword.classList.remove('input-error');
        confirmPassword.classList.add('input-success');
    }
}

password.addEventListener('input', validatePassword);
confirmPassword.addEventListener('input', validatePassword);

document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    if (!email.value.match(emailPattern)) {
        emailError.style.display = 'block';
        email.classList.add('input-error');
        valid = false;
    }

    if (password.value !== confirmPassword.value) {
        passwordError.style.display = 'block';
        confirmPassword.classList.add('input-error');
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
</script>
</body>
</html>