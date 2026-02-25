<?php
$server = "localhost";
$username = 'root';
$password = '';
$db="owi_barcode_test";
// $connection = new PDO( 'mysql:host=localhost;dbname=owi_barcode', $username, $password );
try{
    $conn = new PDO("mysql:host=$server;dbname=$db","$username","$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e){
    die('Unable to connect with the database');
 }