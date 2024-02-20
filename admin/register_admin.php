<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']); 
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $confirm_password = sha1($_POST['confirm-password']); 
    $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);


    $select_admin = $conn->prepare("SELECT * from `admin` where name = ?");
    $select_admin->execute([$username]);

    if ($select_admin->rowCount() > 0) {
       $message[] = 'username already exist!';
    } else {
        if($password != $confirm_password){
            $message[] = 'confirm password is not matched!';
        }else {
            $insert_admin = $conn->prepare("INSERT into `admin` (name, password) values(?,?)");
            $insert_admin->execute([$username, $confirm_password]);
            $message[] = 'new admin registered!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register admin</title>

    <!-- font awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custome css  -->
    <link rel="stylesheet" href="../css/admin.css">

</head>

<body>
    <!-- header section starts  -->
    <?php
    include '../components/admin_header.php';
    ?>

    <!-- header section ends  -->

    <!-- admin register section starts  -->

    <section class="form-container">
        <form action="" method="post">
            <h3>Register now</h3>
            
            <input type="text" required class="box" placeholder="Enter your username" maxlength="20" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="box" placeholder="Enter your password" maxlength="20" name="password" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="box" placeholder="Confirm your password" maxlength="20" name="confirm-password" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" class="btn" name="submit" value="Register">
        </form>
    </section>

    <!-- admin register section ends  -->




    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>