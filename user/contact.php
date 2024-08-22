<?php

session_name("user");
session_start();

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION["signedin"]) == true) {
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->users;
    $user = $collection->findOne([
        "email" => $_SESSION["email"]
    ]);

    if ($user) {
        $userName = $user->name;
        $userEmail = $user->email;
    }} else {
        $userName = '';
        $userEmail = '';
    } 
    
//$user_id = $_SESSION['user_id'] ?? '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];
    date_default_timezone_set('Asia/Kolkata');
    $listTimestamp = time();
    $send_time = date('d-m-Y H:i:s', $listTimestamp);

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->feedback;

    $messageData = [
        //'user_id' => $user_id,
        'name' => $name,
        'email' => $email,
        'message' => $msg,
        'timestamp' => $send_time,
        'replied' => false
    ];

    $result = $collection->insertOne($messageData);

    if ($result->getInsertedCount() > 0) {

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
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Thank you for contacting us!';
            $mail->Body = 'Dear ' . $name . ',<br><br>Thank you for contacting us. We have received your message and will get back to you as soon as possible.<br><br>Best regards,<br>Maths Quiz for kids';
            $mail->AltBody = 'Thank you for contacting us. We will get back to you soon.';
            $mail->send();
            echo "<script>alert('Message sent successfully!')</script>";
            echo "<script>window.location.href='contact.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send message.')</script>";
            echo "<script>window.location.href='contact.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to send message.')</script>";
        echo "<script>window.location.href='contact.php';</script>";
        // echo "<script>window.location.href='index.php?contact';</script>";
    }
}
?>
<html>

<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h2>Contact Us</h2>

        <form action="" method="post">
            <label for="name">Name</label>
            <?php if ($userName): ?>
                <input type="text" id="name" name="name" value="<?= $userName ?>" readonly>
            <?php else: ?>
                <input type="text" id="name" name="name" required placeholder="Enter your name">
            <?php endif; ?>

            <label for="email">Email</label>
            <?php if ($userEmail): ?>
                <input type="email" id="email" name="email" value="<?= $userEmail ?>" readonly>
            <?php else: ?>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            <?php endif; ?>
            
            <label for="message">Message</label>
            <textarea id="message" name="msg" rows="4" required placeholder="Write your message"></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</body>

</html>
