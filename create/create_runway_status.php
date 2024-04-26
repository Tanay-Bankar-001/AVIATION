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
    $name = $_POST['name'];
    $status = $_POST['status'];

    // Prepare SQL statement to insert runway data
    $sql = "INSERT INTO runway_status (runway_name, status) VALUES (?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $status);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable indicating successful insertion
        session_start();
        $_SESSION['runway_status_successful'] = true;

        // Redirect to success page
        header("Location: ../runway_status.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../runway_status.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Runway Status</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
    }
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }
    label {
        color: #343a40;
    }
    input[type="text"],
    select {
        background-color: #f8f9fa;
        border: none;
        border-bottom: 2px solid #007bff;
        border-radius: 0;
        transition: border-bottom-color 0.3s;
        padding-left: 0; /* Remove default padding */
    }
    input[type="text"]:focus,
    select:focus {
        border-bottom-color: #0056b3;
        outline: none;
    }
    input[type="text"]::placeholder,
    select::placeholder {
        opacity: 0.6;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Add Runway Status</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="name">Runway Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="occupied">Occupied</option>
                <option value="available">Available</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
