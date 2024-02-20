<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message">
        <span>' . $message . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>';
    }
}
?>


<header class="header">
    <a href="dashboard.php" class="logo">Admin <span>Panel</span></a>
    <div class="profile">

        <?php
        $select_profile = $conn->prepare("SELECT * from `admin` where id = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

        <p><?= $fetch_profile['name']; ?></p>;
        <a href="update_profile.php" class="btn">update profile</a>

    </div>
    <nav class="navbar">
        <a href="dashboard.php"><i class="fa-solid fa-home"></i><span>home</span></a>
        <a href="add_posts.php"><i class="fa-solid fa-pen"></i><span>add post</span></a>
        <a href="view_posts.php"><i class="fa-solid fa-eye"></i><span>view post</span></a>
        <a href="admin_accounts.php"><i class="fa-solid fa-user"></i><span>accounts</span></a>
        <a href="../components/admin_logout.php" onclick="return confirm('logout from the website?');"><i class="fa-solid fa-right-from-bracket"></i><span style="color: #d32f2f;">logout</span></a>

    </nav>

    <div class="flex-btn">
        <a href="login_admin.login.php" class="option-btn">login</a>
        <a href="register_admin.login.php" class="option-btn">register</a>
    </div>

</header>


<div id="menu-btn" class="fas fa-bars"></div>