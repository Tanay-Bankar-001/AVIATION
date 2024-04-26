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
    $aircraft_id = $_POST['aircraft_id'];
    $aircraft_type = $_POST['aircraft_type'];
    $aircraft_registration = $_POST['aircraft_registration'];

    // Prepare SQL statement to update aircraft data
    $sql = "UPDATE aircrafts SET aircraft_type = ?, aircraft_registration = ? WHERE aircraft_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $aircraft_type, $aircraft_registration, $aircraft_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: ../aircrafts.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../aircrafts.php");
        exit();
    }
}

// Check if aircraft ID is provided
if(isset($_GET['id'])) {
    $aircraft_id = $_GET['id'];

    // Query to select aircraft details
    $sql = "SELECT * FROM aircrafts WHERE aircraft_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $aircraft_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch aircraft details
        $row = $result->fetch_assoc();
        $aircraft_type = $row['aircraft_type'];
        $aircraft_registration = $row['aircraft_registration'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Aircraft Details</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
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
    <h2>Update Aircraft Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="aircraft_id" value="<?php echo $aircraft_id; ?>">
        <div class="form-group">
            <label for="aircraft_type">Aircraft Type:</label>
            <input type="text" class="form-control" id="aircraft_type" name="aircraft_type" value="<?php echo $aircraft_type; ?>" required>
        </div>
        <div class="form-group">
            <label for="aircraft_registration">Aircraft Registration:</label>
            <input type="text" class="form-control" id="aircraft_registration" name="aircraft_registration" value="<?php echo $aircraft_registration; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
<?php
    } else {
        echo "Aircraft not found";
    }
} else {
    echo "Aircraft ID not provided";
}

$stmt->close();
$conn->close();
?>
