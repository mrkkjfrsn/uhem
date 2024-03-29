<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
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

    <main>
        <section class="form-container">

            <form action="" method="post">
                <h3>login now</h3>
                <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="submit" value="login now" name="submit" class="btn">
                <p>don't have an account? <a href="register.php">register now</a></p>
            </form>


        </section>
    </main>

    <footer class="footer" style=" position: absolute; bottom: 0; left:0; right:0;">
        &copy; copyright @ <?= date('Y'); ?> by <span><a href="../visitor/home.php">Uhem</a></span> | all rights reserved!
    </footer>









    <!-- custom js file link  -->
    <script src="../js/visitor.js"></script>

</body>

</html>