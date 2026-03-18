<?php
require '../../../db_connection.php';

$email = $_GET['email'] ?? '';
$response = ['exists' => false];

if ($email) {
    $stmt = $pdo->prepare("SELECT id FROM employees WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $response['exists'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);