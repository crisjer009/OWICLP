<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /user-side/pages/login/login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container {
    background: #fff;
    padding: 40px 60px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    text-align: center;
}
h1 {
    color: #004b9b;
    margin-bottom: 15px;
}
p {
    color: #333;
    font-size: 1rem;
}
a {
    display: inline-block;
    margin-top: 20px;
    color: #004b9b;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 16px;
    border: 1px solid #004b9b;
    border-radius: 6px;
    transition: background 0.3s, color 0.3s;
}
a:hover {
    background: #004b9b;
    color: #fff;
}
</style>
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    <p>You have successfully logged in.</p>
    <a href="logout.php">Logout</a> <!-- Adjust path if logout.php is in a different folder -->
</div>
</body>
</html>
