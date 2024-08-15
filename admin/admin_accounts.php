<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $deleteResult = $adminCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($delete_id)]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admins accounts</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

<?php include 'admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">
   <h1 class="heading">admins account</h1>

   <div class="box-container">
      <div class="box">
         <p>Register New Admin</p>
         <a href="register_admin.php" class="option-btn">Register</a>
      </div>

      <?php
         $accountsCursor = $adminCollection->find();
         $count = 0;
         foreach ($accountsCursor as $account) {
            $account = (array) $account; // Convert to associative array
            $count++;
      ?>
      <div class="box">
         <p> Admin ID : <span><?= $account['_id']; ?></span> </p>
         <p> Username : <span><?= $account['name']; ?></span> </p>
         <div class="flex-btn">
            <a href="admin_accounts.php?delete=<?= $account['_id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
            <?php
               if($account['_id'] == $admin_id){
                  echo '<a href="update_profile.php" class="option-btn">Update</a>';
               }
            ?>
         </div>
      </div>
      <?php
         }
         if ($count === 0) {
            echo '<p class="empty">No accounts available</p>';
         }
      ?>

   </div>
</section>
<!-- admins accounts section ends -->
<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
