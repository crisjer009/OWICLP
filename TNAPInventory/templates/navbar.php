<?php

session_start();

?>





<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OWI-PG Inventory System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/sweetalert/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="dist/select2/dist/css/select2.min.css">


   <!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/select2/dist/js/select2.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" id="homebtn" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link"  href="logout.php" role="button">
          <i class="fas fa-th-large"></i>
          <!-- <i class="far fa-sign-out"></i> -->
          <!-- <i class="fal fa-sign-out"></i> -->
          <!-- <i class="fa-solid fa-arrow-right-from-bracket"></i> -->
          
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

