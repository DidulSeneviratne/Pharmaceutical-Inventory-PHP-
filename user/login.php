<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword);
    
    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-box h2 {
            color: #006064;
            margin-bottom: 20px;
        }

        .login-box input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #b2dfdb;
            border-radius: 5px;
        }

        .login-box button {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            width: 100%;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #004d40;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>

<!-- below form just gets user details and checked from database -->

<body>
    <div class="login-box">
        <h2>User Login</h2>
        <form method="post">
            <input name="email" type="email" placeholder="Email" required><br>
            <input name="password" type="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
