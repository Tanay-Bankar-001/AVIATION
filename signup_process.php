<?php
// Database connection parameters
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'aviation_db';

// Establish database connection
$conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data
    $sql = "INSERT INTO users (username, password_hash, email, name, role) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password_hash, $email, $name, $role);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable indicating successful signup
        session_start();
        $_SESSION['signup_success'] = true;

        // Set the user role in a cookie
        setcookie('user_role', $role, time() + (86400 * 30), '/'); // Cookie lasts for 30 days

        // Redirect to success page
        header("Location: index.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup - Aviation Database</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        .btn-signup {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Signup</h2>
    <form action="signup_process.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role">
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-signup">Sign Up</button>
    </form>
</div>

</body>
</html>
