<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php' ?>

   <!-- admin dashboard section starts  -->

   <section class="dashboard">
      <h1 class="heading">dashboard</h1>
      <div class="box-container">

         <div class="box">
            <h3>welcome!</h3>
            <?php
            $admin = $adminCollection->findOne(["_id" => new MongoDB\BSON\ObjectId($admin_id)]);
            if ($admin) {
               echo '<p>' . $admin->name . '</p>';
            }
            ?>
            <a href="update_profile.php" class="btn">update profile</a>
         </div>

         <div class="box">
            <?php
               $totalQuestions = $questionsCollection->countDocuments();
            ?>
            <h3><?= $totalQuestions; ?></h3>
            <p>Questions added</p>
            <a href="add_questions.php" class="btn">See Questions </a>
         </div>

         <div class="box">
            <?php
            $totalUsers = $userCollection->countDocuments();
            ?>
            <h3><?= $totalUsers; ?></h3>
            <p>users accounts</p>
            <a href="users_accounts.php" class="btn">see users</a>
         </div>

         <div class="box">
            <?php
            $totalAdmins = $adminCollection->countDocuments();
            ?>
            <h3><?= $totalAdmins; ?></h3>
            <p>admins</p>
            <a href="admin_accounts.php" class="btn">see admins</a>

         </div>

         <div class="box">
            <?php
            $numbers_of_messages = $messageCollection->countDocuments();
            ?>
            <h3><?= $numbers_of_messages; ?></h3>
            <p>new messages</p>
            <a href="messages.php" class="btn">see messages</a>
         </div>

      </div>
   </section>

   <!-- admin dashboard section ends -->


   <!-- custom js file link  -->
   <script src="js/admin_script.js"></script>

</body>

</html>
