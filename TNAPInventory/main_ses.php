<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require 'database.php';
if(!empty($_POST['username']) && !empty($_POST['password'])):
  
  $records = $conn->prepare('SELECT * FROM tbl_user WHERE username = :username');
  $records->bindParam(':username', $_POST['username']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);


$user = NULL;

  if( count($results) > 0){
    $user = $results;
  }
  $message = 'Hello user';
    $_SESSION['user_id'] = $results['id'];
    $_SESSION['username'] = $results['username'];
    $_SESSION['password'] = $results['password'];
    $_SESSION['f_name'] = $results['f_name'];
    $_SESSION['lst_name'] = $results['lst_name'];   
    $_SESSION['dept_id'] = $results['dept_id'];   
    $_SESSION['usr_lvl'] = $results['usr_lvl'];   
    $_SESSION['ld_user_secID'] = $results['ld_user_secID'];   
  if(count($results) > 0 && base64_encode($_POST['password']) == $results['password'] && $results['dept_id'] == '2')
  {
    $_SESSION['login'] = 'true';
    $_SESSION['user_id'] = $results['id'];
    header("Location: dashboard.php");
    exit();

  }
  elseif (count($results) > 0 && base64_encode($_POST['password']) == $results['password'] && $results['dept_id'] == '1') {
    $_SESSION['login'] = 'true';
    $_SESSION['user_id'] = $results['id'];
    header("Location: dashboard.php");
    exit();

  }
  elseif (count($results) > 0 && base64_encode($_POST['password']) == $results['password'] && $results['dept_id'] == '3') {
    $_SESSION['login'] = 'true';
    $_SESSION['user_id'] = $results['id'];
    header("Location: ld_dash.php");
    exit();

  }
  elseif (count($results) > 0 && base64_encode($_POST['password']) == $results['password'] && $results['dept_id'] == '4') {
    $_SESSION['login'] = 'true';
    $_SESSION['user_id'] = $results['id'];
    header("Location: sales_dash.php");
    exit();

  }

   else {
    $message = 'Sorry, those credentials do not sss';
  }


endif;

?>