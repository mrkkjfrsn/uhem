<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header("Location: admin_login.php");
}
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    if(!empty($username)) {
        $select_name = $conn->prepare("SELECT * from `admin` where name = ?");
        $select_name->execute([$username]);
        if($select_name->rowCount() > 0) {
            $message[] = 'username already taken';
        }else {
            $update_name = $conn->prepare(("UPDATE `admin` SET name = ? where id = ?"));
            $update_name->execute([$username, $admin_id]);
            $message[] = 'username updated!';
        }
    }
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass != $empty_pass){
       if($old_pass != $prev_pass){
          $message[] = 'old password not matched!';
       }elseif($new_pass != $confirm_pass){
          $message[] = 'confirm password not matched!';
       }else{
          if($new_pass != $empty_pass){
             $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
             $update_pass->execute([$confirm_pass, $admin_id]);
             $message[] = 'password updated successfully!';
          }else{
             $message[] = 'please enter a new password!';
          }
       }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>

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

    <!-- profile update section starts  -->

    <section class="form-container">
        <form action="" method="post">
            <h3>Update profile</h3>

            <input type="text"  class="box" placeholder="<?= $fetch_profile['name']; ?>" maxlength="20" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password"  class="box" placeholder="Enter old your password" maxlength="20" name="old_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password"  class="box" placeholder="Enter your new password" maxlength="20" name="new_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password"  class="box" placeholder="Confirm your new password" maxlength="20" name="confirm_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" class="btn" name="submit" value="Update">
        
        </form>
    </section>

    <!-- profile update section ends  -->




    <!-- custom js -->
    <script src="../js/admin.js"></script>

</body>

</html>