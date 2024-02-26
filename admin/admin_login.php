<?php
include '../components/connect.php';
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']); 
    $password = filter_var($password, FILTER_SANITIZE_STRING);


    $select_admin = $conn->prepare("SELECT * from `admin` where name = ? and password = ?");
    $select_admin->execute([$username, $password]);

    if ($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header("Location: dashboard.php");
    } else {
        $message[] = 'incorrect username or password';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>

    <!-- font awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custome css  -->
    <link rel="stylesheet" href="../css/admin.css">

</head>

<body style="padding-left: 0;">

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>';
        }
    }
    ?>

    <!-- admin login section starts  -->
    <section class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>
            <input type="text" required class="box" placeholder="Enter your username" maxlength="20" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="box" placeholder="Enter your password" maxlength="20" name="password" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" class="btn" name="submit" value="Login">
        </form>
    </section>

    <!-- admin login section ends  -->



    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>