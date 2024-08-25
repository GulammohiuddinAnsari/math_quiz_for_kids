<?php

if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="manage_quiz.php">Manage Quiz</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
         <a href="messages.php">Messages</a>
         <a href="report.php">Reports</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         include 'connectmongo.php';
         
         $adminProfile = $adminCollection->findOne(['_id' => new MongoDB\BSON\ObjectID($admin_id)]);
         ?>
         <p><?= $adminProfile['name']; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>
