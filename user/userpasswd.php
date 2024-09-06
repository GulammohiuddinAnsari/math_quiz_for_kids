<?php
session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $oldpasswd = $_POST["oldpasswd"];
        $newpasswd = $_POST["newpasswd"];
        $confpasswd = $_POST["confpasswd"];

        if ($newpasswd === $confpasswd) {

            require '../vendor/autoload.php';

            $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
            $database = $mongoClient->mathsquiz;
            $collection = $database->users;

            $user = $collection->findOne(["email" => $_SESSION["email"]]);

            if (password_verify($oldpasswd, $user["password"])) {
                $newHashedPassword = password_hash($newpasswd, PASSWORD_DEFAULT);
                $updateResult = $collection->updateOne(
                    ["email" => $_SESSION["email"]],
                    ['$set' => ["password" => $newHashedPassword]]
                );

                if ($updateResult->getModifiedCount() > 0) {
                    echo '<script>alert("Password Changed Successfully!"); window.location.href = "index.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Failed to update password."); window.location.href = "userpasswd.php";</script>';
                    exit;
                }
            } else {
                echo '<script>alert("Current Password is Wrong!"); window.location.href = "userpasswd.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("New passwords do not match."); window.location.href = "userpasswd.php";</script>';
            exit;
        }
    }
?>
    <html>

    <head>
        <title>Change the password</title>
        <link rel="stylesheet" href="css/userpasswd.css">
    </head>

    <body>
        <?php include('header.php'); ?>

        <div class="container">
            <h2>Change your password</h2>

            <form action="" method="post">

                <label for="oldpasswd">Current Password</label>
                <input type="password" id="oldpasswd" name="oldpasswd" required placeholder="Enter your old password"> <br>

                <label for="newpasswd">New Password</label>
                <input type="password" id="newpasswd" name="newpasswd" required placeholder="Enter new password"> <br>

                <label for="confpasswd">Confirm New Password</label>
                <input type="password" id="confpasswd" name="confpasswd" required placeholder="Re-enter new password"> <br>

                <input type="submit" value="Change Password">
            </form>
        </div>
        <?php include('footer.php'); ?>
    </body>

    </html>
<?php
} else {
    header("Location: signin.php");
    exit;
}
?>
