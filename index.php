<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aviation Database</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 800px;
        margin: auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #007bff;
    }
    .nav-link {
        color: #007bff;
        cursor: pointer;
        transition: color 0.3s;
    }
    .nav-link:hover {
        color: #0056b3;
        text-decoration: none;
    }
    .new-user-btn, .delete-user-btn {
        text-align: center;
        margin-top: 30px;
    }
    .btn {
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: #fff;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    .nav-pills .nav-item .nav-link {
        border-radius: 20px;
        padding: 10px 20px;
        margin: 0 10px;
    }
    .nav-pills .nav-item .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }
</style>
</head>
<body>

<div class="container">
    <h2>🛫 Welcome to Aviation Database 🛬</h2>

<ul class="nav nav-pills justify-content-center">
    <li class="nav-item">
        <a class="nav-link" href="index.php">🏠 Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="aircrafts.php">✈️ Aircrafts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="flight_details.php">🛫 Flight Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="atc_table.php">👨‍✈️ Air Traffic Controller</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="pilots.php">👩‍✈️ Pilots</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="runway_status.php">🛣️ Runway Status</a>
    </li>
</ul>

<div class="d-flex justify-content-center mt-3">
    <div class="new-user-btn mr-2">
        <button class="btn btn-primary"><a href="signup_process.php" style="color: #fff; text-decoration: none;">Create a new user</a></button>
    </div>
    <div class="delete-user-btn">
        <form action='./delete/delete_user.php' method='POST'>
            <input type='hidden' name='deleteid' value='1'> <!-- Replace '1' with the appropriate user ID -->
            <button type='submit' class='btn btn-secondary'>Delete user</button>
        </form>
    </div>
</div>

</div>

</body>
</html>
