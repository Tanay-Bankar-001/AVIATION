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
    $pilot_id = $_POST['pilot_id'];
    $pilot_name = $_POST['pilot_name'];
    $pilot_license_number = $_POST['pilot_license_number'];
    $pilot_rating = $_POST['pilot_rating'];

    // Prepare SQL statement to update pilot data
    $sql = "UPDATE pilots SET pilot_name = ?, pilot_license_number = ?, pilot_rating = ? WHERE pilot_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $pilot_name, $pilot_license_number, $pilot_rating, $pilot_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: ../pilots.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../pilots.php");
        exit();
    }
}

// Check if pilot ID is provided
if(isset($_GET['id'])) {
    $pilot_id = $_GET['id'];

    // Query to select pilot details
    $sql = "SELECT * FROM pilots WHERE pilot_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pilot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch pilot details
        $row = $result->fetch_assoc();
        $pilot_name = $row['pilot_name'];
        $pilot_license_number = $row['pilot_license_number'];
        $pilot_rating = $row['pilot_rating'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Pilot Details</title>
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
    <h2>Update Pilot Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="pilot_id" value="<?php echo $pilot_id; ?>">
        <div class="form-group">
            <label for="pilot_name">Pilot Name:</label>
            <input type="text" class="form-control" id="pilot_name" name="pilot_name" value="<?php echo $pilot_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="pilot_license_number">License Number:</label>
            <input type="text" class="form-control" id="pilot_license_number" name="pilot_license_number" value="<?php echo $pilot_license_number; ?>" required>
        </div>
        <div class="form-group">
            <label for="pilot_rating">Pilot Rating:</label>
            <select class="form-control" id="pilot_rating" name="pilot_rating">
                <option value="First Officer" <?php if($pilot_rating == 'First Officer') echo 'selected'; ?>>First Officer (Co-pilot)</option>
                <option value="Second Officer" <?php if($pilot_rating == 'Second Officer') echo 'selected'; ?>>Second Officer</option>
                <option value="Captain" <?php if($pilot_rating == 'Captain') echo 'selected'; ?>>Captain</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
<?php
    } else {
        echo "Pilot not found";
    }
} else {
    echo "Pilot ID not provided";
}

$stmt->close();
$conn->close();
?>
