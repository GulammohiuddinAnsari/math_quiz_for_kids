<?php
session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    if (!isset($_SESSION['score'])) {
        header('Location: index.php');
        exit();
    }

    $score = $_SESSION['score'];
    $message = $_SESSION['message'];
    $totalQuestions = $_SESSION['totalQuestions'];

    unset($_SESSION['current_question']);
    unset($_SESSION['score']);
    unset($_SESSION['answers']);
    unset($_SESSION['category']);
    unset($_SESSION['totalQuestions']);
?>

    <html>

    <head>
        <title>Quiz Results</title>
        <link rel="stylesheet" href="css/results_page.css">
    </head>

    <body>
        <?php include('header.php'); ?>

        <div class="quiz-container">
            <h1>Your Quiz Results</h1>
            <p><?php echo $message; ?></p>
            <div class="results-info">
                <h2>Your Score:</h2>
                <p><?php echo $score; ?> / <?php echo $totalQuestions ?></p>
            </div>
            <div class="button-container">
                <a href="playquiz.php" class="btn">Start New Quiz</a>
                <a href="index.php" class="btn">Exit</a>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
