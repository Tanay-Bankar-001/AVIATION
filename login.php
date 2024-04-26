<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $HOSTNAME = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'aviation_db';

    // Establish database connection
    $con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

    // Check if connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to retrieve hashed password from the database
    $sql = "SELECT password_hash FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the hashed password from the database
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password_hash'];

        // Verify the provided password against the hashed password
        if (password_verify($password, $hashed_password)) {
            // Passwords match, set session variable and redirect to home page
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            // Passwords do not match, display error message
            $login_error = "Invalid username or password";
        }
    } else {
        // User does not exist, display error message
        $login_error = "Invalid username or password";
    }

    // Close the database connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
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
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <?php if (isset($login_error)) { ?>
        <div class="error"><?php echo $login_error; ?></div>
    <?php } ?>
</div>

</body>
</html>
