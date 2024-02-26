<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}
if(isset($_POST['delete'])){
    $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
    $delete_image->execute([$admin_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_delete_image['image'] != ''){
       unlink('../uploaded_images/'.$fetch_delete_image['image']);
    }


    $delete_posts = $conn->prepare("DELETE from `posts` where admin_id = ?");
    $delete_posts->execute([$admin_id]);
    $delete_comments = $conn->prepare("DELETE from `comments` where admin_id = ?");
    $delete_comments->execute([$admin_id]);
    $delete_likes = $conn->prepare("DELETE from `likes` where admin_id = ?");
    $delete_likes->execute([$admin_id]);
    $delete_admin = $conn->prepare("DELETE from `admin` where admin_id = ?");
    $delete_admin->execute([$admin_id]);
    header('location: ../components/admin_logout.php');
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins accounts</title>

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
        <h1 class="heading">admins accounts</h1>
        <div class="box-container">
            <div class="box" style="order: -2;">
                <p>register new admin</p>
                <a href="register_admin.php" class="option-btn">register now</a>
            </div>

            <?php
            $select_account = $conn->prepare("SELECT * from `admin`");
            $select_account->execute();
            if ($select_account->rowCount() > 0) {
                while ($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)) {


                    $count_admin_posts = $conn->prepare("SELECT * from `posts` where admin_id = ?");
                    $count_admin_posts->execute([$fetch_account['id']]);
                    $total_admin_posts = $count_admin_posts->rowCount();

            ?>
                    <div class="box" style="<?php  if ($fetch_account['id'] == $admin_id){
                        echo 'order: -1';
                        }?>">
                        <p>id: <span><?= $fetch_account['id']; ?></span></p>
                        <p>username: <span><?= $fetch_account['name']; ?></span></p>
                        <p>total posts: <span><?= $total_admin_posts; ?></span></p>

                        <?php
                        if ($fetch_account['id'] == $admin_id) {

                        ?>
                            <div class="flex-btn"> <a href="updata_profile.php" class="option-btn">update</a>
                                <form action="" method="post">
                                    <button type="submit" class="delete-btn" onclick="return confirm('delete the account?');" name="delete">delete</button>
                                </form>
                            </div>
                        <?php

                        }



                        ?>
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