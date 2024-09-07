<?php
session_name("user");
session_start();

require '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->mathsquiz;
$collection = $db->users;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $securityQuestion = $_POST['security_question'] ?? '';
    $securityAnswer = $_POST['security_answer'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    $user = $collection->findOne(['email' => $email]);

    if ($user && strtolower($user['security_question']) === strtolower($securityQuestion) && strtolower($user['security_answer']) === strtolower($securityAnswer)) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateResult = $collection->updateOne(
            ['_id' => $user['_id']],
            ['$set' => ['password' => $newPasswordHash]]
        );

        if ($updateResult->getModifiedCount() == 1) {
            echo '<script>alert("Password has been successfully reset."); window.location.href = "index.php";</script>';
        } else {
            echo '<script>alert("Failed to reset password."); window.location.href = "index.php";</script>';
        }
    } else {
        echo '<script>alert("Invalid details provided"); window.location.href = "pwdreset.php";</script>';
    }
}

?>
<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/pwdreset.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h2>Reset your password</h2>

        <form method="post">
            <label>
                Email:
                <input type="email" name="email" required placeholder="Enter your email" />
            </label> <br>

            <label>
                Security Question:
                <select name="security_question" required>
                    <option value="">Select your question</option>
                    <option value="animal">What animal do you like the most?</option>
                    <option value="friend">
                        What is the name of your best friend?
                    </option>
                    <option value="hobby">
                        What is your favorite hobby or activity?
                    </option>
                </select>
            </label> <br>

            <label>
                Security Answer:
                <input type="text" name="security_answer" required placeholder="Enter answer" />
            </label> <br>

            <label>
                New Password:
                <input type="password" name="new_password" required placeholder="Enter new password" />
            </label> <br />

            <input type="submit" value="Reset Password">
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
