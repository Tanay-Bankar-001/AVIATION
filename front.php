<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aviation Database Interface</title>
<style>
    /* Add your CSS styles here */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 800px;
        margin: auto;
    }
    h2 {
        text-align: center;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Flight Management</h2>
    <div class="form-group">
        <label for="flightNumber">Flight Number:</label>
        <input type="text" id="flightNumber">
    </div>
    <div class="form-group">
        <button class="btn" onclick="updateFlightStatus('Arrived')">Arrive Flight</button>
        <button class="btn" onclick="updateFlightStatus('Departed')">Depart Flight</button>
    </div>

</div>

<script>
    // Function to send AJAX request to update flight status
    function updateFlightStatus(status) {
        var flightNumber = document.getElementById('flightNumber').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_flight_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
            }
        };
        xhr.send('flightNumber=' + flightNumber + '&status=' + status);
    }
</script>
</body>
</html>
