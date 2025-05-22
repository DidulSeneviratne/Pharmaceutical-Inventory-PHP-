<?php
session_start();
include '../db.php';

if (!isset($_SESSION['pharmacy'])) {
    header("Location: login.php");
    exit();
}

// here just create quotation according to the user information and send back to the user

$prescription_id = $_GET['prescription_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $items = [];
    $total = 0;

    for ($i = 0; $i < count($_POST['drug']); $i++) {
        $drug = $_POST['drug'][$i];
        $qty = (int)$_POST['qty'][$i];
        $price = (float)$_POST['price'][$i];
        $items[] = ['drug' => $drug, 'qty' => $qty, 'price' => $price];
        $total += $qty * $price;
    }

    $items_json = json_encode($items);
    $stmt = $conn->prepare("INSERT INTO quotations (prescription_id, items, total) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $prescription_id, $items_json, $total);
    $stmt->execute();

    echo "<div class='success'>Quotation sent! <a href='dashboard.php'>Back</a></div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h3 {
            color: #006064;
            text-align: center;
            margin-top: 0;
        }

        .form-box div {
            margin-bottom: 15px;
        }

        input {
            padding: 8px;
            margin-right: 8px;
            width: calc(30% - 10px);
            border: 1px solid #b2dfdb;
            border-radius: 5px;
        }

        button {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004d40;
        }

        .success {
            background: #d0f8ce;
            padding: 15px;
            margin: 50px auto;
            text-align: center;
            border: 1px solid #388e3c;
            border-radius: 5px;
            width: fit-content;
            font-weight: bold;
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h3>Send Quotation for Prescription #<?= htmlspecialchars($prescription_id) ?></h3>

        <form method="post">
            <div id="items">
                <div>
                    Drug: <input name="drug[]" required>
                    Qty: <input name="qty[]" type="number" required>
                    Price: <input name="price[]" type="number" step="0.01" required>
                </div>
            </div>
            <button type="button" onclick="addItem()">Add More</button><br><br>
            <button type="submit">Send Quotation</button>
        </form>
    </div>

    <script>
    function addItem() {
        const div = document.createElement("div");
        div.innerHTML = `Drug: <input name="drug[]" required>
                         Qty: <input name="qty[]" type="number" required>
                         Price: <input name="price[]" type="number" step="0.01" required>`;
        document.getElementById("items").appendChild(div);
    }
    </script>
</body>
</html>
