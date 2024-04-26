<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Management</h2>
    <?php
    // Establish database connection
    $HOSTNAME = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'aviation_db';

    $con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

    // Check if connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if delete request is made
    if(isset($_GET['deleteid'])) {
        // Get user ID to delete
        $deleteid = $_GET['deleteid'];

        // Query to delete user
        $deleteQuery = "DELETE FROM users WHERE user_id=$deleteid";

        // Execute the query
        if(mysqli_query($con, $deleteQuery)) {
            echo "<div class='alert alert-success' role='alert'>
                    User deleted successfully!
                  </div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                    Error deleting user: " . mysqli_error($con) . "
                  </div>";
        }
    }

    // Query to select data from users table
    $sql = "SELECT * FROM users";
    $result = $con->query($sql);

    // Check if there are users
    if ($result->num_rows > 0) {
        // Output table
        echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Get the actual role from the database
            $role = $row['role'];

            // Display 'N/A' if role is empty
            if(empty($role)) {
                $role = 'N/A';
            }

            echo "<tr>
                    <td>" . $row["user_id"]. "</td>
                    <td>" . $row["username"]. "</td>
                    <td>" . $row["email"]. "</td>
                    <td>" . $role . "</td>
                    <td><a href='delete_user.php?deleteid=" . $row["user_id"] . "' style='color: #dc3545;'>Delete</a></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Close the database connection
    $con->close();
    ?>
</div>

</body>
</html>
