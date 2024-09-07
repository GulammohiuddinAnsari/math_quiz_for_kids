<?php
session_name("user");
session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 'yes') {
    session_unset();
    session_destroy();
    echo "<script>
        alert('You have been logged out!');
        window.location.href = 'index.php';
    </script>";
}
?>

<html>

<head>
    <title>Logout</title>
</head>

<body>
    <script>
        window.onload = function() {
            var logout = confirm('Are you sure you want to log out?');
            if (logout) {
                window.location.href = '?logout=yes';
            } else {
                window.location.href = 'index.php';
            }
        }
    </script>
</body>

</html>
