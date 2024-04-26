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
    $atc_id = $_POST['atc_id'];
    $atc_name = $_POST['atc_name'];
    $atc_rank = $_POST['atc_rank'];
    $atc_shift = $_POST['atc_shift'];

    // Prepare SQL statement to update ATC data
    $sql = "UPDATE atc_table SET atc_name = ?, atc_rank = ?, atc_shift = ? WHERE atc_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $atc_name, $atc_rank, $atc_shift, $atc_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: ../atc_table.php");
        exit();
    } else {
        // Redirect to error page or display error message
        header("Location: ../atc_table.php");
        exit();
    }
}

// Check if ATC ID is provided
if(isset($_GET['id'])) {
    $atc_id = $_GET['id'];

    // Query to select ATC details
    $sql = "SELECT * FROM atc_table WHERE atc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $atc_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch ATC details
        $row = $result->fetch_assoc();
        $atc_name = $row['atc_name'];
        $atc_rank = $row['atc_rank'];
        $atc_shift = $row['atc_shift'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update ATC Details</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Update ATC Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="atc_id" value="<?php echo $atc_id; ?>">
        <div class="form-group">
            <label for="atc_name">Name:</label>
            <input type="text" class="form-control" id="atc_name" name="atc_name" value="<?php echo $atc_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="atc_rank">Rank:</label>
            <select class="form-control" id="atc_rank" name="atc_rank">
                <option value="Junior Controller" <?php if($atc_rank == 'Junior Controller') echo 'selected'; ?>>Junior Controller</option>
                <option value="Senior Controller" <?php if($atc_rank == 'Senior Controller') echo 'selected'; ?>>Senior Controller</option>
                <option value="Chief Controller" <?php if($atc_rank == 'Chief Controller') echo 'selected'; ?>>Chief Controller</option>
            </select>
        </div>
        <div class="form-group">
            <label for="atc_shift">Shift:</label>
            <input type="text" class="form-control" id="atc_shift" name="atc_shift" value="<?php echo $atc_shift; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
<?php
    } else {
        echo "ATC not found";
    }
} else {
    echo "ATC ID not provided";
}

$stmt->close();
$conn->close();
?>
