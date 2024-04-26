<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aviation Database - Pilot Details</title>
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
    .pilot-item {
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
    }
    .pilot-item:last-child {
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
    <h2>Pilot Details</h2>

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

    // Query to select data from pilots table
    $sql = "SELECT * FROM pilots";
    $result = $con->query($sql);
    $role = isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : 'employee';

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // echo is used to print data on the website so only the below lines are rendered
            echo '<div class="pilot-item">';
            echo "<span class='btn-bold'>ID: </span>" . $row["pilot_id"] . "<br>";
            echo "<span class='btn-bold'>Name: </span>" . $row["pilot_name"] . "<br>";
            echo "<span class='btn-bold'>License Number: </span>" . $row["pilot_license_number"] . "<br>";
            echo "<span class='btn-bold'>Rating: </span>" . $row["pilot_rating"] . "<br>";
            if ($role === 'admin') {
                echo '<a class="btn update" href="./update/update_pilots.php?id=' . $row["pilot_id"] . '">Update</a>';
                echo '<a class="btn delete" href="./delete/delete_pilots.php?deleteid=' . $row["pilot_id"] . '">Delete</a>';
            }
            echo '</div>';
        }
        if($role==="admin"){
            echo '<a class="btn create" href="./create/create_pilots.php">Create</a>';
        }
    } else {
        echo "0 results";
    }

    $con->close();
    ?>
    <!-- Backend code ends -->
</div>

</body>
</html>
