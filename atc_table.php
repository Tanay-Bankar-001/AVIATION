<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aviation Database - ATC Table</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 800px;
        margin: auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }
    .atc-item {
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
    }
    .atc-item:last-child {
        margin-bottom: 0;
    }
    .btn {
        display: inline-block;
        padding: 8px 16px;
        margin-right: 10px;
        border-radius: 5px;
        text-decoration: none;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-bold {
        font-weight: bold;
    }
    .btn.update {
        background-color: transparent;
        border: 1px solid #007bff;
        color: #007bff;
    }
    .btn.update:hover {
        background-color: #007bff;
        border: 1px solid #007bff;
    }
    .btn.delete {
        background-color: transparent;
        border: 1px solid #dc3545;
        color: #dc3545;
    }
    .btn.delete:hover {
        background-color: #dc3545;
        border: 1px solid #dc3545;
    }
    .btn.create {
        background-color: transparent;
        border: 1px solid #28a745;
        color: #28a745;
    }
    .btn.create:hover {
        background-color: #28a745;
        border: 1px solid #28a745;
    }
</style>
</head>
<body>

<?php include 'index.php'; ?>

<div class="container">
    <h2>ATC Table</h2>

    <!-- Backend code starts -->
    <?php
    $HOSTNAME = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'aviation_db';

    $con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

    if ($con) {
        echo "Connection Successful<br>";
    } else {
        die(mysqli_error($con));
    }

    // Query to select data from ATC table
    $sql = "SELECT * FROM atc_table";
    $result = $con->query($sql);

    $role = isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : 'employee';

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="atc-item">';
            echo "<span class='btn-bold'>ATC ID: </span>" . $row["atc_id"] . "<br>";
            echo "<span class='btn-bold'>Name: </span>" . $row["atc_name"] . "<br>";
            echo "<span class='btn-bold'>Rank: </span>" . $row["atc_rank"] . "<br>";
            echo "<span class='btn-bold'>Shift: </span>" . $row["atc_shift"] . "<br>";
            if ($role === 'admin') {
                echo '<a class="btn update" href="./update/update_atc_table.php?id=' . $row["atc_id"] . '">Update</a>';
                echo '<a class="btn delete" href="./delete/delete_atc_table.php?deleteid=' . $row["atc_id"] . '">Delete</a>';
            }
            echo '</div>';
        }
    } else {
        echo "0 results";
    }

    if ($role === "admin") {
        echo '<a class="btn create" href="./create/create_atc_table.php">Create</a>';
    }

    $con->close();
    ?>
    <!-- Backend code ends -->
</div>

</body>
</html>
