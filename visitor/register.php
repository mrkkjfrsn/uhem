<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $message[] = 'email already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm password not matched!';
        } else {
            $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
            $insert_user->execute([$name, $email, $cpass]);
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $pass]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
            if ($select_user->rowCount() > 0) {
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
            }
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
    <link rel="stylesheet" href="../css/visitor_style/authors.css">
    <link rel="stylesheet" href="../css/visitor_style/buttons.css">
    <link rel="stylesheet" href="../css/visitor_style/categories.css">
    <link rel="stylesheet" href="../css/visitor_style/comments.css">
    <link rel="stylesheet" href="../css/visitor_style/footer.css">
    <link rel="stylesheet" href="../css/visitor_style/general_visitor.css">
    <link rel="stylesheet" href="../css/visitor_style/home.css">
    <link rel="stylesheet" href="../css/visitor_style/messages.css">
    <link rel="stylesheet" href="../css/visitor_style/post.css">
    <link rel="stylesheet" href="../css/visitor_style/responsive_visitor.css">
    <link rel="stylesheet" href="../css/visitor_style/visitor_header.css">

</head>

<body>

    <!-- header section starts  -->
    <?php include '../components/user_header.php'; ?>
    <!-- header section ends -->

    <section class="form-container">

        <form action="" method="post">
            <h3>register now</h3>
            <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
            <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" name="submit" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>

    </section>











    <?php include '../components/footer.php'; ?>









    <!-- custom js file link  -->
    <script src="../js/visitor.js"></script>
</body>

</html>