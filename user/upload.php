<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];
    $delivery_address = $_POST['delivery_address'];
    $delivery_time_slot = $_POST['delivery_time_slot'];

    $uploaded_images = [];
    $error = '';

    // can upload images max 5

    if (count($_FILES['prescription_images']['name']) < 1 || count($_FILES['prescription_images']['name']) > 5) {
        $error = "You must upload between 1 and 5 images.";
    } else {
        foreach ($_FILES['prescription_images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['prescription_images']['error'][$index] === 0) {
                $fileName = uniqid() . '_' . basename($_FILES['prescription_images']['name'][$index]);
                move_uploaded_file($tmpName, "../uploads/" . $fileName);
                $uploaded_images[] = $fileName;
            }
        }

        $images_json = json_encode($uploaded_images);
        $stmt = $conn->prepare("INSERT INTO prescriptions (user_id, note, delivery_address, delivery_time_slot, images) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $_SESSION['user_id'], $note, $delivery_address, $delivery_time_slot, $images_json);
        $stmt->execute();

        $success = "Prescription uploaded successfully! <a href='dashboard.php'>Go back</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 450px;
        }

        h2 {
            color: #006064;
            text-align: center;
        }

        textarea, input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #b2dfdb;
            border-radius: 5px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004d40;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
    <script>
        function validateForm(event) {
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput.files.length > 5) {
                alert("You can upload a maximum of 5 images.");
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="form-box">
        <h2>Upload Prescription</h2>
        <form method="post" enctype="multipart/form-data" onsubmit="validateForm(event)">
            <label>Note:</label>
            <textarea name="note" rows="3" required></textarea>

            <label>Address:</label>
            <input name="delivery_address" required>

            <label>Time Slot:</label>
            <select name="delivery_time_slot" required>
                <option value="">--Select--</option>
                <option>8am - 10am</option>
                <option>10am - 12pm</option>
                <option>12pm - 2pm</option>
                <option>2pm - 4pm</option>
            </select>

            <label>Upload Prescription (Max 5 images):</label>
            <input type="file" name="prescription_images[]" multiple accept="image/*" required>

            <button type="submit">Submit</button>
        </form>

        <?php if (!empty($error)): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
