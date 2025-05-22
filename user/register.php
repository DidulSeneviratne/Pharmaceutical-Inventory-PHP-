<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, address, contact, dob) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $password, $address, $contact, $dob);
    if ($stmt->execute()) {
        $success = "Registered successfully. <a href='login.php'>Login</a>";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #006064;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #b2dfdb;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004d40;
        }

        .message {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <!-- from here new user can register for the system -->    

    <div class="form-box">
        <h2>User Registration</h2>
        <form method="post">
            <input name="name" placeholder="Name" required>
            <input name="email" type="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password" required>
            <input name="address" placeholder="Address">
            <input name="contact" placeholder="Contact">
            <input name="dob" type="date" placeholder="Date of Birth">
            <button type="submit">Register</button>
        </form>

        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
