<?php
$servername = "localhost";
$username = 'root';
$password = '';
$db="owi_barcode";
$concat = mysqli_connect($servername, $username, $password,$db);
$connection = new PDO( 'mysql:host=localhost;dbname=owi_barcode', $username, $password );

?>


