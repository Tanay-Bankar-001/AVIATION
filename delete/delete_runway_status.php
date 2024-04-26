<?php
    $HOSTNAME = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'aviation_db';

    $con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        echo "Connection Successful<br>";
    }

    // Check user role
    $role = isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : 'employee';

    // Query to select data from runway_status table
    $sql = "SELECT * FROM runway_status";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["runway_id"]. " - Status: " . $row["status"]. "<br>";
        }
    } else {
        echo "0 results";
    }

    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        // Prepared statement for delete query
        $stmt = $con->prepare("DELETE FROM runway_status WHERE runway_id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    }

    $con->close();
?>
