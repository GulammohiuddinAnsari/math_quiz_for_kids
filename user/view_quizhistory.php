<?php

session_name("user");
session_start();

if (!isset($_SESSION["signedin"]) || $_SESSION["signedin"] !== true || !isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

require '../vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->mathsquiz->scores;

if (!isset($_GET['score_id'])) {
    echo "Score ID is not provided.";
    exit();
}

$scoreId = $_GET['score_id'];
$score = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($scoreId)]);

if (!$score) {
    echo "Score not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Maths Quiz History</title>
    <link rel="stylesheet" href="css/scores.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h2>Quiz Score Details</h2>
        <p><strong>_id : </strong><?= $score['_id'] ?></p>
        <p><strong>Category : </strong><?= $score['category'] ?></p>
        <p><strong>Score : </strong><?= $score['score'] ?></p>
        <p><strong>Date : </strong><?= $score['date'] ?></p>
        <div>
            <h2>Quiz Question History</h2>
            <table border="1">
                <tr>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Correct Answer</th>
                    <th>User Answer</th>
                </tr>
                <?php foreach ($score['questions'] as $index => $question) : ?>
                    <tr>
                        <td><?= $question['question'] ?></td>
                        <td>
                            <ul>
                                <?php foreach ($question['options'] as $key => $value) : ?>
                                    <li><?= $key ?>. <?= $value ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?= $question['answer'] ?></td>
                        <td><?= isset($score['answers'][$index]) ? $score['answers'][$index] : 'Not answered' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
