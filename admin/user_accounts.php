<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user account</title>

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


    <section class="accounts">
        <h1 class="heading">users accounts</h1>

        <div class="box-container">
           

            <?php
            $select_account = $conn->prepare("SELECT * from `users`");
            $select_account->execute();
            if ($select_account->rowCount() > 0) {
                while ($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)) {

            ?>
                    <div class="box">
                        <p>id: <span><?= $fetch_account['id']; ?></span></p>
                        <p>username: <span><?= $fetch_account['name']; ?></span></p>
                        <p>user email: <span><?= $fetch_account['email']; ?></span></p>
                       

                    </div>

            <?php
                }
            } else {
                echo '<p class="empty">no accounts found!</p>';
            } ?>
        </div>
    </section>



    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>