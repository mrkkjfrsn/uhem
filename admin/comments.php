<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}

if (isset($_POST['delete_comment'])) {

    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comment->execute([$comment_id]);
    $message[] = 'comment delete!';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user comments</title>

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

    <section class="comments" style="padding-top: 0;">

        <p class="comment-title">post comments</p>
        <div class="box-container">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
            $select_comments->execute([$admin_id]);
            if ($select_comments->rowCount() > 0) {
                while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <?php
                        $select_posts = $conn->prepare("SELECT * from `posts` where id = ?");
                        $select_posts->execute([$fetch_comments['post_id']]);
                        while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {




                        ?>
                            <div class="post-title"><span>from:</span>
                                <p><?= $fetch_post['title']; ?></p><a href="read_posts.php?post_id=<?= $fetch_post['id']; ?>">read post</a>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="user">
                            <i class="fas fa-user"></i>
                            <div class="user-info">
                                <span><?= $fetch_comments['user_name']; ?></span>
                                <div><?= $fetch_comments['date']; ?></div>
                            </div>
                        </div>
                        <div class="text"><?= $fetch_comments['comment']; ?></div>
                        <form action="" method="POST">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comments['id']; ?>">
                            <button type="submit" class="inline-delete-btn" name="delete_comment" onclick="return confirm('delete this comment?');">delete comment</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no comments added yet!</p>';
            }
            ?>
        </div>

    </section>



    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>