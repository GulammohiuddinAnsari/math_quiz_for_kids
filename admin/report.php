<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
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
   <h1 class="heading">Report Page</h1>

   <div class="box-container">
      <div class="box">
         <p>Total User Report</p>
         <a href="user_report.php" class="option-btn">User Report</a><br><br>
         <p>Total Questions Report</p>
         <a href="question_report.php" class="option-btn">Questions Report</a><br><br>
         <!-- <p>Score Report</p>
         <a href="score_report.php" class="option-btn">Score Report</a> -->
      </div>
   </div>
</section>
<!-- admins accounts section ends -->
<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
