<?php
session_start();
require '../../../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fname) || empty($lname) || empty($department) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    $check = $pdo->prepare("SELECT id FROM employees WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        die("Email already registered!");
    }

    

    $stmt = $pdo->query("SELECT MAX(id) as max_id FROM employees");
    $row = $stmt->fetch();

    $nextID = ($row['max_id'] ?? 0) + 1;
    $employeeID = "OWI-2024-" . str_pad($nextID, 3, '0', STR_PAD_LEFT);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insert = $pdo->prepare("
        INSERT INTO employees 
        (employee_id, first_name, last_name, department, email, password) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

   $insert->execute([
    $employeeID,
    $fname,
    $lname,
    $department,
    $email,
    $hashedPassword
]);


    $_SESSION['success'] = "Registration successful! You can now log in.";
header("Location: /admin-side/dashboard.php");
exit;
}
?>