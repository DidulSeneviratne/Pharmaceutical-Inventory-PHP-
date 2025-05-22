<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user_id'];
?>

<!-- after successfull login user directly go to this dashboard.php file -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .dashboard {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dashboard h2 {
            color: #006064;
        }

        .dashboard a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard a:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, User #<?= htmlspecialchars($userId) ?></h2>
        <a href="upload.php">Upload Prescription</a>
        <a href="quotation.php">View Quotation</a>
    </div>
</body>
</html>

