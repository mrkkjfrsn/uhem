<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);

   if ($select_admin->rowCount() > 0) {
      $message[] = 'username already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm passowrd not matched!';
      } else {
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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

<body>

   <?php include '../components/admin_header.php' ?>

   <!-- register admin section starts  -->

   <section class="form-container">

      <form action="" method="POST">
         <h3>register now</h3>
         <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="register now" name="submit" class="btn">
      </form>

   </section>

   <!-- register admin section ends -->

















   <!-- custom js file link  -->
   <script src="../js/admin.js"></script>

</body>

</html>