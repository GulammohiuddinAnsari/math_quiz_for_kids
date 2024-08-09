<?php
session_name("user");
session_start();
?>

<html>

<head>
    <title>Maths Quiz for Kids</title>
    <link rel="stylesheet" href="css/Home.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <header>
            <h1 class="main-heading">Maths is Fun!</h1>
            <p class="main-para">Test your math skills and have fun learning!</p>
        </header>
        <a href="playquiz.php" class="quiz-button">Start the Quiz!</a>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
