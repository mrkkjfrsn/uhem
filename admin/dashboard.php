<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION[$admin_id])) {
    // header("location: admin_login.php");
  $_SESSION['admin_id'] = 1;

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

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

    <!-- dashboard section starts  -->
    <section class="dashboard">
        <h1 class="heading">dashboard</h1>

        <div class="box-container">
            <div class="box">
                <h3>Welcome</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update_profile.php" class="btn">update profile</a>
            </div>

            <div class="box">
                <?php
                $select_posts = $conn->prepare("SELECT * from `posts` where admin_id = ?");
                $select_posts->execute([$admin_id]);
                $number_of_posts = $select_posts->rowCount();
                ?>
                <h3><?= $number_of_posts; ?></h3>
                <p>posts added</p>
                <a href="add_posts.php" class="btn">add new post</a>
            </div>

            <div class="box">
                <?php
                $select_active_posts = $conn->prepare("SELECT * from `posts` where admin_id = ? AND status = ?");
                $select_active_posts->execute([$admin_id, 'active']);
                $number_of_active_posts = $select_active_posts->rowCount();
                ?>
                <h3><?= $number_of_active_posts; ?></h3>
                <p>active posts</p>
                <a href="view_posts.php" class="btn">view post</a>
            </div>


            <div class="box">
                <?php
                $select_deactive_posts = $conn->prepare("SELECT * from posts where admin_id = ? AND status = ?");
                $select_deactive_posts->execute([$admin_id, 'active']);
                $number_of_deactive_posts = $select_deactive_posts->rowCount();
                ?>
                <h3><?= $number_of_deactive_posts; ?></h3>
                <p>deactive posts</p>
                <a href="view_posts.php" class="btn">view post</a>
            </div>


            <div class="box">
                <?php
                $select_users = $conn->prepare("SELECT * from `users`");
                $select_users->execute();
                $number_of_users = $select_users->rowCount();
                ?>
                <h3><?= $number_of_users; ?></h3>
                <p>total users</p>
                <a href="users_accounts.php" class="btn">view users</a>
            </div>


            <div class="box">
                <?php
                $select_admins = $conn->prepare("SELECT * from `admin`");
                $select_admins->execute();
                $number_of_admins = $select_admins->rowCount();
                ?>
                <h3><?= $number_of_admins; ?></h3>
                <p>total admins</p>
                <a href="admin_accounts.php" class="btn">view admins</a>
            </div>

            <div class="box">
                <?php
                $select_comments = $conn->prepare("SELECT * from `comments` where admin_id = ?");
                $select_comments->execute([$admin_id]);
                $number_of_comments = $select_comments->rowCount();
                ?>
                <h3><?= $number_of_comments; ?></h3>
                <p>total comments</p>
                <a href="comments.php" class="btn">view comments</a>
            </div>

            <div class="box">
                <?php
                $select_likes = $conn->prepare("SELECT * from `likes` where admin_id = ?");
                $select_likes->execute([$admin_id]);
                $number_of_likes = $select_likes->rowCount();
                ?>
                <h3><?= $number_of_likes; ?></h3>
                <p>total likes</p>
                <a href="comments.php" class="btn">view likes</a>
            </div>





        </div>

    </section>
    <!-- dashboard section ends  -->




    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>