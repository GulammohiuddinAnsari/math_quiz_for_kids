<?php
require '../vendor/autoload.php';
session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->users;

    $userData = $collection->findone([
        "email" => $email
    ]);

    if ($userData && password_verify($password, $userData["password"])) {
        $_SESSION["email"] = $email;
        $_SESSION["userName"] = $userData["name"];
        $_SESSION["signedin"] = true;
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Invalid email or password!')</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit;
    }
}
?>

<html>

<head>
    <title>User Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="login-form">
        <h2>User Login</h2>
        <form action="" method="post">
            <label>
                Email:
                <input type="email" name="email" id="email" required placeholder="Enter your email" />
            </label>
            <br />
            <label>
                Password:
                <input type="password" name="password" id="password" required placeholder="Enter password" />
            </label>
            <br />
            <div>
                <a href="pwdreset.php">Forgot Password?</a>
            </div>
            <br>
            <button type="submit">Log In</button>
            <div>
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</body>

</html>
