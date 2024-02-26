<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header("Location: admin_login.php");
}

if(isset($_POST['publish'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $status = 'active';

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_images/'.$image;

    $select_image = $conn->prepare("SELECT * from `posts` where image = ? and admin_id = ? ");
    $select_image->execute([$image, $admin_id]);

    if(isset($image)){
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'image name repeated';
        }elseif($image_size > 2000000){
            $message[] = 'image size is too large';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);

        }
    }else{
        $image = '';
    }
    if($select_image->rowCount() > 0 AND $image != ''){
        $message[] = 'please rename your image';
    }else{
        $insert_post = $conn->prepare("INSERT into `posts` (admin_id, name, title, content, category, image, status) values(?,?,?,?,?,?,?)");
        $insert_post->execute([$admin_id, $name, $title, $content, $category, $image, $status]);
        $message[] = 'post published';
    }
}



if(isset($_POST['draft'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $status = 'deactive';

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_images/'.$image;

    $select_image = $conn->prepare("SELECT * from `posts` where image = ? and admin_id = ? ");
    $select_image->execute([$image, $admin_id]);

    if(isset($image)){
        if($select_image->rowCount() > 0 AND $image != ''){
            $message[] = 'image name repeated';
        }elseif($image_size > 2000000){
            $message[] = 'image size is too large';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);

        }
    }else{
        $image = '';
    }
    if($select_image->rowCount() > 0 AND $image != ''){
        $message[] = 'please rename your image';
    }else{
        $insert_post = $conn->prepare("INSERT into `posts` (admin_id, name, title, content, category, image, status) values(?,?,?,?,?,?,?)");
        $insert_post->execute([$admin_id, $name, $title, $content, $category, $image, $status]);
        $message[] = 'draft saved';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add post</title>

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

    <section class="post-editor">
        <h1 class="heading">add post</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
            <p>post title <span>*</span> </p>
            <input type="text" name="title" required placeholder="add post title" maxlength="100" class="box">
            <p>post content <span>*</span> </p>
            <textarea name="content" class="box" required maxlength="100000" cols="30" rows="10" placeholder="write your content"></textarea>
            <p>post category <span>*</span></p>
            <select name="category" class="box" required>
                <option value="" disabled selected>-- select post category</option>
                <option value="nature">nature</option>
                <option value="education">education</option>
                <option value="pets and animals">pets and animals</option>
                <option value="technology">technology</option>
                <option value="fashion">fashion</option>
                <option value="entertainment">entertainment</option>
                <option value="movies">movies</option>
                <option value="gaming">gaming</option>
                <option value="music">music</option>
                <option value="sports">sports</option>
                <option value="news">news</option>
                <option value="travel">travel</option>
                <option value="comedy">comedy</option>
                <option value="design and development">desing and development</option>
                <option value="foods and drinks">foods and drinks</option>
                <option value="personal">personal</option>
                <option value="health and fitness">health and fitness</option>
                <option value="business">business</option>
                <option value="shopping">shopping</option>
                
            </select>
            <p>post image</p>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
            <div class="flex-btn">
                <input type="submit" value="public post" name="publish" class="btn">
                <input type="submit" value="safe draft" name="draft" class="option-btn">
            </div>

        </form>
    </section>




    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>