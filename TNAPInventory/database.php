<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'owi_barcode';

$concat = mysqli_connect($server, $username, $password,$database);


try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}