<?php

include 'main_ses.php';
  ?>

<style>
         .home-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        padding: 10px 20px;
        text-decoration: none;
        font-weight: bold;
        z-index: 10;
        transition: all 0.3s ease;
      }
      
      .home-btn:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
      }
    </style>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>C.O.F.</title>
    <link rel="stylesheet" href="dist/style.css" />
  </head>
  <body>
    <div class="wrapper">
      <div class="container">
        <h1>Tindahan Ni Aling Puring</h1>
        

        <?php if(!empty($message)): ?>
    <p id="err_mes" class="text-white"><?= $message ?></p>
  <?php endif; ?>

        <form method="post" class="form" id="report_form" enctype="multipart/form-data">


          <input type="text" placeholder="Username" name="username" />
          <input type="password" placeholder="Password" name="password" />
          <input type="submit" name="btn" value="Login" class="btn btn-outline-primary float-right login_btn">
        </form>
        <a href="/PGInventory/index.php" class="home-btn">Home</a>
      </div>

      <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
    <!-- partial -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="dist/style.css"></script>
  </body>
</html>


<script>
setTimeout(function() {
  $("#err_mes").remove();
}, 5000);



</script>