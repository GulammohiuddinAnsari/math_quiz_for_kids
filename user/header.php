<html>

<head>
    <link rel="stylesheet" href="./css/header.css">
</head>

<body>
    <div class="heading">
        <a href="index.php">
            <img src="assets/maths quiz.jpg" alt="Logo" class="logo">
            <h1>Welcome to Maths Quiz for Kids</h1>
            <img src="assets/maths quiz.jpg" alt="Logo" class="logo">
        </a>
    </div>

    <div class="nav">
        <a href="index.php">Home</a>
        <a href="playquiz.php">Play Quiz</a>
        <a href="contact.php">Contact Us</a>
        <?php if (isset($_SESSION['signedin'])) : ?>
            <a href="scores.php">View Scores</a>
            <a href="userprofile.php"><img class="user-icon" src="assets/user-regular.png" alt="user-icon"> <?php echo $_SESSION['userName']; ?></a>
            <a href="logout.php">Logout</a>
        <?php else : ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</body>

</html>
