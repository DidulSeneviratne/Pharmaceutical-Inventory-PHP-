<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription System</title>
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

        h2 {
            color: #006064;
            margin-bottom: 30px;
        }

        .link-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .link-container a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #00796b;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .link-container a:hover {
            background-color: #004d40;
        }
    </style>

    <!-- from here we select the pathways of user flow -->

</head>
<body>
    <div class="link-container">
        <h2>Welcome to Medical Prescription System</h2>
        <a href="user/register.php">User Register</a><br>
        <a href="user/login.php">User Login</a><br><br>
        <a href="pharmacy/login.php">Pharmacy Login</a>
    </div>
</body>
</html>

