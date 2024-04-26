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
    $runway_id = $_POST['runway_id'];
    $runway_name = $_POST['runway_name'];
    $status = $_POST['status'];

    // Prepare SQL statement to update runway data
    $sql = "UPDATE runway_status SET runway_name = ?, status = ? WHERE runway_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $runway_name, $status, $runway_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: ../runway_status.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../runway_status.php");
        exit();
    }
}

// Check if runway ID is provided
if(isset($_GET['id'])) {
    $runway_id = $_GET['id'];

    // Query to select runway details
    $sql = "SELECT * FROM runway_status WHERE runway_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $runway_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch runway details
        $row = $result->fetch_assoc();
        $runway_name = $row['runway_name'];
        $status = $row['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Runway Details</title>
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
    <h2>Update Runway Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="runway_id" value="<?php echo $runway_id; ?>">
        <div class="form-group">
            <label for="runway_name">Runway Name:</label>
            <input type="text" class="form-control" id="runway_name" name="runway_name" value="<?php echo $runway_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="Occupied" <?php if($status == 'Occupied') echo 'selected'; ?>>Occupied</option>
                <option value="Available" <?php if($status == 'Available') echo 'selected'; ?>>Available</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
<?php
    } else {
        echo "Runway not found";
    }
} else {
    echo "Runway ID not provided";
}

$stmt->close();
$conn->close();
?>
