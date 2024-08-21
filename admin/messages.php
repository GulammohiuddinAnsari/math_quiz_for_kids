<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\{PHPMailer, Exception};

include 'connectmongo.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header('location:admin_login.php');
    exit();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $messageCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($delete_id)]);
    echo "<script>alert('Message deleted successfully!')</script>";
    echo "<script>window.location.href='messages.php';</script>";
   
}

if (isset($_POST['send_reply'])) {
    $message_id = $_POST['message_id'];
    $reply = $_POST['reply'];

    $message = $messageCollection->findOne(['_id' => new MongoDB\BSON\ObjectID($message_id)]);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kaushik91ahir@gmail.com';
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('kaushik91ahir@gmail.com', 'Kaushik');
        $mail->addAddress($message['email'], $message['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Reply to your message';
        $mail->Body = $reply;
        $mail->send();
        $messageCollection->updateOne(['_id' => new MongoDB\BSON\ObjectID($message_id)], ['$set' => ['replied' => true, 'reply_text' => $reply]]);
        echo "<script>alert('Reply sent successfully!')</script>";
        echo "<script>window.location.href='messages.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to send message.')</script>";
        echo "<script>window.location.href='messages.php';</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   
</head>
<body>
   <?php include 'admin_header.php' ?>

   <section class="messages">
      <h1 class="heading">Messages</h1>
      <div class="box-container">
         <?php
         $messagesCount = $messageCollection->countDocuments();
         if ($messagesCount > 0) {
            $messagesCursor = $messageCollection->find();
            foreach ($messagesCursor as $message) {
         ?>
               <div class="box">
                  <?php
                  $replied = isset($message['replied']) && $message['replied'];
                  ?>
                  <!-- <p>User ID: <span><?= $message['user_id']; ?></span></p> -->
                  <p>Name: <span><?= $message['name']; ?></span></p>
                  <p>Email: <span><?= $message['email']; ?></span></p>
                  <p>Message: <span><?= $message['message']; ?></span></p>
                  <p>Timestamp: <span><?=$message['timestamp']; ?></span></p>
                  <p>Replied: <span><?= $replied ? $message['reply_text'] : 'Not yet replied'; ?></span></p>
                  <?php if (!$replied): ?>
                     <form action="" method="post">
                        <input type="hidden" name="message_id" value="<?= $message['_id']; ?>">
                        <textarea name="reply" class="box" placeholder="Enter your reply" maxlength="500" cols="30" rows="5"></textarea>
                        <input type="submit" value="Send Reply" name="send_reply" class="btn">
                     </form>
                  <?php endif; ?>
                  <a href="messages.php?delete=<?= $message['_id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?');">Delete</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">You have no messages</p>';
         }
         ?>
      </div>
   </section>
   <script src="js/admin_script.js"></script>
</body>
</html>
