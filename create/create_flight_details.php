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
    $flight_number = $_POST['flight_number'];
    $departure_airport = $_POST['departure_airport'];
    $departure_time = $_POST['departure_time'];
    $arrival_airport = $_POST['arrival_airport'];
    $arrival_time = $_POST['arrival_time'];
    $aircraft_id = $_POST['aircraft_id'];
    $pilot_id = $_POST['pilot_id'];
    $status = $_POST['status'];

    // Prepare SQL statement to insert flight details
    $sql = "INSERT INTO flight_details (flight_number, departure_airport, departure_time, arrival_airport, arrival_time, aircraft_id, pilot_id, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $flight_number, $departure_airport, $departure_time, $arrival_airport, $arrival_time, $aircraft_id, $pilot_id, $status);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable indicating successful insertion
        session_start();
        $_SESSION['flight_details_added_successfully'] = true;

        // Redirect to success page
        header("Location: ../flight_details.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../flight_details.php");
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
<title>Add Flight Details</title>
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
    input[type="datetime-local"],
    select {
        background-color: #f8f9fa;
        border: none;
        border-bottom: 2px solid #007bff;
        border-radius: 0;
        transition: border-bottom-color 0.3s;
        padding-left: 0; /* Remove default padding */
    }
    input[type="text"]:focus,
    input[type="datetime-local"]:focus,
    select:focus {
        border-bottom-color: #0056b3;
        outline: none;
    }
    input[type="text"]::placeholder,
    input[type="datetime-local"]::placeholder,
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
    <h2>Add Flight Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="flight_number">Flight Number:</label>
            <input type="text" class="form-control" id="flight_number" name="flight_number" placeholder="Enter flight number" required>
        </div>
        <div class="form-group">
            <label for="departure_airport">Departure Airport:</label>
            <input type="text" class="form-control" id="departure_airport" name="departure_airport" placeholder="Enter departure airport" required>
        </div>
        <div class="form-group">
            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
        </div>
        <div class="form-group">
            <label for="arrival_airport">Arrival Airport:</label>
            <input type="text" class="form-control" id="arrival_airport" name="arrival_airport" placeholder="Enter arrival airport" required>
        </div>
        <div class="form-group">
            <label for="arrival_time">Arrival Time:</label>
            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
        </div>
        <div class="form-group">
            <label for="aircraft_id">Aircraft ID:</label>
            <input type="number" class="form-control" id="aircraft_id" name="aircraft_id" placeholder="Enter aircraft ID" required>
        </div>
        <div class="form-group">
            <label for="pilot_id">Pilot ID:</label>
            <input type="number" class="form-control" id="pilot_id" name="pilot_id" placeholder="Enter pilot ID" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="on time">On Time</option>
                <option value="delayed">Delayed</option>
                <option value="landed">Landed</option>
                <option value="in transit">In Transit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
