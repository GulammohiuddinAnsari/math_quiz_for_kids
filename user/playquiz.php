<?php
session_name("user");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['category'] = $_POST['category'];
    header('Location: quiz_page.php');
    exit();
}
?>

<html>

<head>
    <title>Quiz Start</title>
    <link rel="stylesheet" href="css/playquiz.css">
</head>

<body>
    <?php include('header.php');
    unset($_SESSION['current_question']);
    unset($_SESSION['score']);
    unset($_SESSION['answers']);
    unset($_SESSION['category']);
    unset($_SESSION['totalQuestions']);
    ?>

    <div class="quiz-container">
        <h1>Welcome to the Quiz</h1>
        <p>Test your knowledge by selecting a quiz category below:</p>
        <form action="" method="post">
            <div class="button-container">
                <button type="submit" name="category" value="easy" class="btn category-easy">Easy</button>
                <button type="submit" name="category" value="normal" class="btn category-normal">Normal</button>
                <button type="submit" name="category" value="hard" class="btn category-hard">Hard</button>
                <button type="submit" name="category" value="expert" class="btn category-expert">Expert</button>
            </div>
        </form>
        <p>Choose your challenge wisely and enjoy!</p>
        <div class="quiz-info">
            <h2>How to Play:</h2>
            <ul>
                <li>Choose your desired quiz category by clicking on one of the buttons above.</li>
                <li>Once you select a category, you'll be presented with a series of questions.</li>
                <li>Answer each question to the best of your ability.</li>
                <li>After answering all questions, submit your answers and see how well you did!</li>
            </ul>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
