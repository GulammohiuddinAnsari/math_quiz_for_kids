<?php

include 'connectmongo.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    // Delete user from the users collection
    $userCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($delete_id)]);
    // Delete Quiz scores associated with the user
    //$scoreCollection->deleteMany(['user_id' => $delete_id]);

    header('location:users_accounts.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Accounts</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/users.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

<?php include 'admin_header.php' ?>

<!-- Users accounts section starts  -->

<section class="accounts">
    <h1 class="heading">Users Accounts</h1>

    <div class="search-box">
        <input type="text" id="searchInput" onkeyup="searchUser()" placeholder="Search by username...">
    </div>

    <div class="table-container">
        <table id="userTable">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Age</th>
                <th>Address</th>
                <th>Mobile No</th>
                <th>Sec_question</th>
                <th>Sec_answer</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $usersCursor = $userCollection->find();
            $count = 0;
            foreach ($usersCursor as $user) :
                $count++;
                ?>
                <tr>
                    <td><?= $user['_id']; ?></td>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['age']; ?></td>
                    <td><?= $user['address_line'] . ', ' . $user['city']; ?></td>
                    <td><?= $user['mobile_number']; ?></td>
                    <td><?= $user['security_question']; ?></td>
                    <td><?= $user['security_answer']; ?></td>
                    <td>
                        <a href="users_accounts.php?delete=<?= $user['_id']; ?>"
                           class="delete-btn"
                           onclick="return confirm('Delete this account?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach;
            if ($count === 0) :
                ?>
                <tr>
                    <td colspan="11" class="empty">No accounts available</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php
    $totalUsers = $count;
    $perPage = 10;
    $totalPages = ceil($totalUsers / $perPage);
    ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i; ?>" <?= ($i === 1) ? 'class="active"' : ''; ?>><?= $i; ?></a>
        <?php endfor; ?>
    </div>


</section>
<!-- Users accounts section ends -->

<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

<script>
    function searchUser() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("userTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                tr[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? "" : "none";
            }
        }
    }
</script>

</body>
</html>
