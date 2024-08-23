<?php

include 'connectmongo.php';
session_start();

$users = iterator_to_array($userCollection->find());

// Calculate the total number of users
$totalUsers = count($users);

?>

<html>
<head>
    <title>User Report</title>
    <style>
        table {border-collapse: collapse; width: 100%;}
        th, td {border: 1px solid #464343; text-align: left; padding: 8px;}
        tr:nth-child(even) {background-color: #f2f2f2;}
        @media print {
            .print-hide { display: none; }
        }
    </style>
</head>
<body>
    <h1>User Report</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Address</th>
            <th>Mobile No</th> 
            <th class="print-hide">Sec_question</th>
            <th class="print-hide">Sec_answer</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->_id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->age ?></td>
                <td><?= $user->address_line . ', ' . $user->city ?></td>
                <td><?= $user->mobile_number ?></td>
                <td class="print-hide"><?= $user->security_question ?></td>
                <td class="print-hide"><?= $user->security_answer ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>Total Users: <?= $totalUsers ?></p>

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
