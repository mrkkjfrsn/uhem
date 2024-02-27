<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}
if (isset($_POST['delete'])) {
    $delete_id = $_POST['post_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $select_image = $conn->prepare("SELECT * from `posts` where id = ?");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_image['image'] != '') {
        unlink('../uploaded_images/' . $fetch_image['image']);
    }
    $delete_comments = $conn->prepare("DELETE from `comments` where post_id = ?");
    $delete_comments->execute([$delete_id]);

    $delete_likes = $conn->prepare("DELETE from `likes` where post_id = ?");
    $delete_likes->execute([$delete_id]);

    $delete_post = $conn->prepare("DELETE from `posts` where id = ?");
    $delete_post->execute([$delete_id]);

    $message[] = 'post deleted successfully';
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search page</title>

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

    <section class="show-posts">

        <h1 class="heading">search posts</h1>

        <form action="search_page.php" method="post" class="search-form">
            <input type="text" placeholder="search posts...." required maxlength="100" name="search_box">
            <button class="fas fa-search" type="submit" name="search_btn"></button>
        </form>

        <div class="box-container">

            <?php
            if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
                $search_box = $_POST['search_box'];

                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? and title Like '%{$search_box}%'");
                $select_posts->execute([$admin_id]);
                if ($select_posts->rowCount() > 0) {
                    while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                        $post_id = $fetch_posts['id'];

                        $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                        $count_post_comments->execute([$post_id]);
                        $total_post_comments = $count_post_comments->rowCount();

                        $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                        $count_post_likes->execute([$post_id]);
                        $total_post_likes = $count_post_likes->rowCount();

            ?>
                        <form method="post" class="box">
                            <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                            <?php if ($fetch_posts['image'] != '') { ?>
                                <img src="../uploaded_images/<?= $fetch_posts['image']; ?>" class="image" alt="">
                            <?php } ?>
                            <div class="status" style="background-color:<?php if ($fetch_posts['status'] == 'active') {
                                                                            echo 'limegreen';
                                                                        } else {
                                                                            echo 'coral';
                                                                        }; ?>;"><?= $fetch_posts['status']; ?></div>
                            <div class="title"><?= $fetch_posts['title']; ?></div>
                            <div class="posts-content"><?= $fetch_posts['content']; ?></div>
                            <div class="icons">
                                <div class="likes"><i class="fas fa-heart"></i><span><?= $total_post_likes; ?></span></div>
                                <div class="comments"><i class="fas fa-comment"></i><span><?= $total_post_comments; ?></span></div>
                            </div>
                            <div class="flex-btn">
                                <a href="edit_post.php?id=<?= $post_id; ?>" class="option-btn">edit</a>
                                <button type="submit" name="delete" class="delete-btn" onclick="return confirm('delete this post?');">delete</button>
                            </div>
                            <a href="read_post.php?post_id=<?= $post_id; ?>" class="btn">view post</a>
                        </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">no posts found<a href="add_posts.php" class="btn" style="margin-top:1.5rem;">add post</a></p>';
                }
            }
            ?>

        </div>


    </section>



    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>