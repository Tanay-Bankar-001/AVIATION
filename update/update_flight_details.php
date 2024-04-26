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
    $flight_id = $_POST['flight_id'];
    $flight_number = $_POST['flight_number'];
    $departure_airport = $_POST['departure_airport'];
    $departure_time = $_POST['departure_time'];
    $arrival_airport = $_POST['arrival_airport'];
    $arrival_time = $_POST['arrival_time'];
    $aircraft_id = $_POST['aircraft_id'];
    $pilot_id = $_POST['pilot_id'];
    $status = $_POST['status'];

    // Prepare SQL statement to update flight data
    $sql = "UPDATE flight_details SET flight_number = ?, departure_airport = ?, departure_time = ?, arrival_airport = ?, arrival_time = ?, aircraft_id = ?, pilot_id = ?, status = ? WHERE flight_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $flight_number, $departure_airport, $departure_time, $arrival_airport, $arrival_time, $aircraft_id, $pilot_id, $status, $flight_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: ../flight_details.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../flight_details.php");
        exit();
    }
}

// Check if flight ID is provided
if(isset($_GET['id'])) {
    $flight_id = $_GET['id'];

    // Query to select flight details
    $sql = "SELECT * FROM flight_details WHERE flight_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch flight details
        $row = $result->fetch_assoc();
        $flight_number = $row['flight_number'];
        $departure_airport = $row['departure_airport'];
        $departure_time = $row['departure_time'];
        $arrival_airport = $row['arrival_airport'];
        $arrival_time = $row['arrival_time'];
        $aircraft_id = $row['aircraft_id'];
        $pilot_id = $row['pilot_id'];
        $status = $row['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Flight Details</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Update Flight Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
        <div class="form-group">
            <label for="flight_number">Flight Number:</label>
            <input type="text" class="form-control" id="flight_number" name="flight_number" value="<?php echo $flight_number; ?>" required>
        </div>
        <div class="form-group">
            <label for="departure_airport">Departure Airport:</label>
            <input type="text" class="form-control" id="departure_airport" name="departure_airport" value="<?php echo $departure_airport; ?>" required>
        </div>
        <div class="form-group">
            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" value="<?php echo date('Y-m-d\TH:i', strtotime($departure_time)); ?>" required>
        </div>
        <div class="form-group">
            <label for="arrival_airport">Arrival Airport:</label>
            <input type="text" class="form-control" id="arrival_airport" name="arrival_airport" value="<?php echo $arrival_airport; ?>" required>
        </div>
        <div class="form-group">
            <label for="arrival_time">Arrival Time:</label>
            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" value="<?php echo date('Y-m-d\TH:i', strtotime($arrival_time)); ?>" required>
        </div>
        <div class="form-group">
            <label for="aircraft_id">Aircraft ID:</label>
            <input type="text" class="form-control" id="aircraft_id" name="aircraft_id" value="<?php echo $aircraft_id; ?>" required>
        </div>
        <div class="form-group">
            <label for="pilot_id">Pilot ID:</label>
            <input type="text" class="form-control" id="pilot_id" name="pilot_id" value="<?php echo $pilot_id; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="Scheduled" <?php if($status == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                <option value="On Time" <?php if($status == 'On Time') echo 'selected'; ?>>On Time</option>
                <option value="Delayed" <?php if($status == 'Delayed') echo 'selected'; ?>>Delayed</option>
                <option value="Cancelled" <?php if($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
<?php
    } else {
        echo "Flight not found";
    }
} else {
    echo "Flight ID not provided";
}

$stmt->close();
$conn->close();
?>
