<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);

   if ($select_admin->rowCount() > 0) {
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   } else {
      $message[] = 'incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- custome css  -->
   <link rel="stylesheet" href="../css/admin_style/general_admin.css">
   <link rel="stylesheet" href="../css/admin_style/accounts.css">
   <link rel="stylesheet" href="../css/admin_style/admin_header.css">
   <link rel="stylesheet" href="../css/admin_style/buttons.css">
   <link rel="stylesheet" href="../css/admin_style/comments.css">
   <link rel="stylesheet" href="../css/admin_style/dashboard.css">
   <link rel="stylesheet" href="../css/admin_style/messages.css">
   <link rel="stylesheet" href="../css/admin_style/post.css">
   <link rel="stylesheet" href="../css/admin_style/responsive_admin.css">

</head>

<body style="padding-left: 0 !important;">

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <!-- admin login form section starts  -->

   <section class="form-container">


      <div>
         <a href="../visitor/home.php">
            <h3>Uhem</h3>
         </a>
         <p>A home for every topic.</p>
      </div>


      <form action="" method="POST">
         <h3>login now</h3>
         <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="login" name="submit" class="btn">
         <p>Don't have an account? <a href="admin_register.php">Register</a></p>
      </form>


   </section>

   <!-- admin login form section ends -->










</body>

</html>