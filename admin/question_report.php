<?php

include 'connectmongo.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}

// Fetch all questions
$questions = iterator_to_array($questionsCollection->find());

$totalQuestions = count($questions);

// Calculate the total number of questions per category
$totalQuestionsPerCategory = array();
foreach ($questions as $question) {
    $category = $question->category;
    if (!isset($totalQuestionsPerCategory[$category])) {
        $totalQuestionsPerCategory[$category] = 1;
    } else {
        $totalQuestionsPerCategory[$category]++;
    }
}

$categories = array_keys($totalQuestionsPerCategory);

if (isset($_GET['category']) && $_GET['category'] != 'all') {
    $selectedCategory = $_GET['category'];
    $filteredQuestions = array_filter($questions, function ($question) use ($selectedCategory) {
        return $question->category == $selectedCategory;
    });
    $totalQuestionsForSelectedCategory = count($filteredQuestions);
} else {
    $filteredQuestions = $questions;
    $totalQuestionsForSelectedCategory = $totalQuestions;
}
?>

<html>

<head>
    <title>Question Report</title>
    <style>
        table {border-collapse: collapse; width: 100%;}
        th, td {border: 1px solid #464343; text-align: left; padding: 8px;}
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>

<body>
    <h1>Question Report</h1>

    <form method="GET" action="">
        <label for="category">Select Category:</label>
        <select name="category" id="category">
            <option value="all">All Categories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category ?>" <?= isset($_GET['category']) && $_GET['category'] == $category ? 'selected' : '' ?>>
                    <?= $category ?> (<?= $totalQuestionsPerCategory[$category] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Filter">
    </form>

    <table>
        <tr>
            <!-- <th>Question ID</th> -->
            <th>Question</th>
            <th>Options</th>
            <th>Answer</th>
            <th>Category</th>
        </tr>
        <?php foreach ($filteredQuestions as $question) : ?>
            <tr>
                <!-- <td><?= $question->_id ?></td> -->
                <td><?= $question->question ?></td>
                <td>
                    <?php foreach ($question->options as $key => $option) : ?>
                        <?= $key . '. ' . $option ?><br>
                    <?php endforeach; ?>
                </td>
                <td><?= $question->answer ?></td>
                <td><?= $question->category ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>Total Questions: <?= $totalQuestions ?></p>
    <?php if (!isset($_GET['category']) || $_GET['category'] == 'all') : ?>
        <p>Total Questions for Each Category:</p>
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li><?= $category ?>: <?= isset($totalQuestionsPerCategory[$category]) ? $totalQuestionsPerCategory[$category] : 0 ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Total Questions for <?= $_GET['category'] ?>: <?= $totalQuestionsForSelectedCategory ?></p>
    <?php endif; ?>


    <p>
        <button onclick="closeReport()">Close</button>
        <button onclick="printReport()">Print</button>
    </p>
</body>

</html>

<script>
    function closeReport() {
        window.history.back();
        alert("Closing the Report..."); 
    }

    function printReport() {
        window.print();
        alert("Printing the Report..."); 
    }
</script>
