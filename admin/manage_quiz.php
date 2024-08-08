<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

$distinctCategories = $questionsCollection->distinct('category'); 
$filterCategory = isset($_GET['category']) ? $_GET['category'] : null;
// Construct the filter query based on the selected category
$filterQuery = [];
if ($filterCategory) {
    $filterQuery = ['category' => $filterCategory];
}

$questionsCursor = $questionsCollection->find($filterQuery);

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $result = $questionsCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($delete_id)]);
    if ($result->getDeletedCount() > 0) {
        header('Location: manage_quiz.php');
        exit();
    } else {
        echo 'Question deletion failed';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quiz</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php' ?>

    <!-- Category Filter Dropdown -->
    <div class="category-filter-container">
        <form action="manage_quiz.php" method="get">
            <label for="category">Filter by Category :</label>
            <select name="category" id="category">
                <option value="">All</option>
                <?php foreach ($distinctCategories as $category) : ?>
                    <option value="<?php echo $category; ?>" <?php echo ($category == $filterCategory) ? 'selected' : ''; ?>><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filter</button>
            <a href="add_questions.php" class="add-question-btn">Add Questions</a>
        </form>
    </div>
    


    <!-- show products section starts  -->
    <section class="show-questions">
        <div class="question-container">
            <?php foreach ($questionsCursor as $question) : ?>
                <div class="question-box">
                    <div class="question"><?php echo $question['question']; ?></div>
                    <div class="options">
                        <?php foreach ($question['options'] as $key => $option) : ?>
                            <div><?php echo $key . '. ' . $option; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="answer">Correct Answer: <?php echo $question['answer']; ?></div>
                    <div class="category">Category: <?php echo $question['category']; ?></div>
                    <div class="flex-btn">
                        <a href="update_question.php?update=<?= $question['_id']; ?>" class="option-btn">Update</a>
                        <a href="manage_quiz.php?delete=<?= $question['_id']; ?>" class="delete-btn" onclick="return confirm('Delete this question?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($questionsCursor === 0) : ?>
                <p class="empty">No questions added yet!</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- show products section ends -->

    <!-- custom js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>
