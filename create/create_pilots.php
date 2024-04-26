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
    $license_number = $_POST['license_number'];
    $rating = $_POST['rating'];

    // Prepare SQL statement to insert pilot data
    $sql = "INSERT INTO pilots (pilot_name, pilot_license_number, pilot_rating) VALUES (?, ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $license_number, $rating);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable indicating successful insertion
        session_start();
        $_SESSION['pilots_added_successfully'] = true;

        // Redirect to success page
        header("Location: ../pilots.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../pilots.php");
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
<title>Add Pilot</title>
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
    <h2>Add Pilot</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="name">Pilot Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter pilot name" required>
        </div>
        <div class="form-group">
            <label for="license_number">License Number:</label>
            <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter license number" required>
        </div>
        <div class="form-group">
            <label for="rating">Rating:</label>
            <select class="form-control" id="rating" name="rating" required>
                <option value="first officer">First Officer (Co-pilot)</option>
                <option value="second officer">Second Officer</option>
                <option value="captain">Captain</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
