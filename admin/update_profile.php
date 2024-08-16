<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];
$admin = $adminCollection->findOne(['_id' => new MongoDB\BSON\ObjectID($admin_id)]);
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $existingAdmin = $collection->findOne(['name' => $name]);
      if($existingAdmin){
         $message[] = 'Username already taken!';
      }else{
         $updateNameResult = $adminCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($admin_id)],
            ['$set' => ['name' => $name]]
         );
      }
   }

   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)){
      $prev_pass = $admin['password'];
      
      if(sha1($old_pass) != $prev_pass){
         $message[] = 'Old password does not match!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'Confirm password does not match!';
      } else {
         $updatePassResult = $adminCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($admin_id)],
            ['$set' => ['password' => sha1($new_pass)]]
         );
         $message[] = 'Password updated successfully!';
      }
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php' ?>

<!-- admin profile update section starts  -->

<section class="form-container">

<form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $admin['name']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>

</section>

<!-- admin profile update section ends -->



<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
