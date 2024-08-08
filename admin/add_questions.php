<?php
include 'connectmongo.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $questionText = $_POST['question'];
    $options = [
        'A' => $_POST['optionA'],
        'B' => $_POST['optionB'],
        'C' => $_POST['optionC'],
        'D' => $_POST['optionD']
    ];
    $answer = $_POST['answer'];
    $category = $_POST['category'];

    $existingQuestion = $questionsCollection->findOne(['question' => $questionText]);
    if ($existingQuestion) {
        $message[] = 'Question already exists!'; 
    } else {
        // Insert the new question
        $insertResult = $questionsCollection->insertOne([
            'question' => $questionText,
            'options' => $options,
            'answer' => $answer,
            'category' => $category
        ]);

        if ($insertResult->getInsertedCount() == 1) {
            $message[] = 'Question inserted successfully!';
        } else {
            $message[] = 'Failed to add question.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Insert Quiz Question</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>
    <section class="add-questions">
    
    <form action="" method="post">
    <h3>Insert a new MCQ Question</h3><br>
        <input type="text" id="question" name="question" placeholder="Enter question" class="box" required><br>
        <input type="text" id="optionA" name="optionA" placeholder="Option A" class="box" required><br>
        <input type="text" id="optionB" name="optionB" placeholder="Option B" class="box" required><br>
        <input type="text" id="optionC" name="optionC" placeholder="Option C" class="box" required><br>
        <input type="text" id="optionD" name="optionD" placeholder="Option D" class="box" required><br>
        <select id="answer" name="answer" class="box" required>
            <option value="" disabled selected>--Select Correct Answer --</option>
            <option value="A">Option A</option>
            <option value="B">Option B</option>
            <option value="C">Option C</option>
            <option value="D">Option D</option>
        </select><br>
        <select id="category" name="category" class="box" required>
            <option value="" disabled selected>--Select Category --</option>
            <option value="easy">Easy</option>
            <option value="normal">Normal</option>
            <option value="hard">Hard</option>
            <option value="expert">Expert</option>
        </select><br>

        <input type="submit" value="Insert Question" class="btn">
        <a href="manage_quiz.php" class="option-btn">Go Back</a><br><br>
    </form>
    </section>
    <script src="js/admin_script.js"></script>
</body>

</html>
