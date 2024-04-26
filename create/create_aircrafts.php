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
    $type = $_POST['aircraft_type'];
    $registration = $_POST['aircraft_registration'];
    $seats = $_POST['seating_capacity'];
    $fuel = $_POST['current_fuel_quantity'];

    // Prepare SQL statement to insert aircraft data
    $sql = "INSERT INTO aircrafts (aircraft_type, aircraft_registration, seating_capacity, current_fuel_quantity) VALUES (?, ?, ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $type, $registration, $seats, $fuel);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable indicating successful insertion
        session_start();
        $_SESSION['aircraft_added_successfully'] = true;

        // Redirect to success page
        header("Location: ../aircrafts.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../aircrafts.php");
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
<title>Add Aircraft</title>
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
    input[type="number"] {
        background-color: #f8f9fa;
        border: none;
        border-bottom: 2px solid #007bff;
        border-radius: 0;
        transition: border-bottom-color 0.3s;
        padding-left: 0; /* Remove default padding */
    }
    input[type="text"]:focus,
    input[type="number"]:focus {
        border-bottom-color: #0056b3;
        outline: none;
    }
    input[type="text"]::placeholder,
    input[type="number"]::placeholder {
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
    <h2>Add Aircraft</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="aircraft_type">Aircraft Type:</label>
            <input type="text" class="form-control" id="aircraft_type" name="aircraft_type" placeholder="E.g., AIRBUS 380" required>
        </div>
        <div class="form-group">
            <label for="aircraft_registration">Registration:</label>
            <input type="text" class="form-control" id="aircraft_registration" name="aircraft_registration" placeholder="E.g., IX 1598" required>
        </div>
        <div class="form-group">
            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" class="form-control" id="seating_capacity" name="seating_capacity" placeholder="E.g., 150" required>
        </div>
        <div class="form-group">
            <label for="current_fuel_quantity">Current Fuel Quantity:</label>
            <input type="number" class="form-control" id="current_fuel_quantity" name="current_fuel_quantity" placeholder="E.g., 5000" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
