<?php
$host = "localhost";       
$dbname = "clp";           
$user = "root";             
$pass = "";                 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Uncomment to test connection
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
