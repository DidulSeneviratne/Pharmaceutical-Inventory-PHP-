<?php
session_start();
include '../db.php';

if (!isset($_SESSION['pharmacy'])) {
    header("Location: login.php");
    exit();
}

// here just show the prescription fetch data to the pharmacy side

$prescriptions = $conn->query("SELECT * FROM prescriptions ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #006064;
            margin-bottom: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 25px;
        }

        .card h3 {
            margin-top: 0;
            color: #00796b;
        }

        .card p {
            margin: 8px 0;
        }

        .card img {
            margin-right: 10px;
            border: 1px solid #b2dfdb;
            border-radius: 5px;
        }

        .quote-btn, .status-info {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .quote-btn {
            background-color: #00796b;
            color: white;
        }

        .quote-btn:hover {
            background-color: #004d40;
        }

        .status-info {
            background-color: #eeeeee;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pharmacy Dashboard - Prescriptions</h2>

        <?php while ($pres = $prescriptions->fetch_assoc()): ?>
            <div class="card">
                <h3>Prescription #<?= $pres['id'] ?> from User #<?= $pres['user_id'] ?></h3>
                <p><strong>Note:</strong> <?= htmlspecialchars($pres['note']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($pres['delivery_address']) ?></p>
                <p><strong>Time Slot:</strong> <?= htmlspecialchars($pres['delivery_time_slot']) ?></p>

                <div>
                    <?php
                    $images = json_decode($pres['images'], true);
                    foreach ($images as $img) {
                        echo "<img src='../uploads/" . htmlspecialchars($img) . "' height='100'>";
                    }
                    ?>
                </div>

                <?php
                $quoteCheck = $conn->query("SELECT * FROM quotations WHERE prescription_id = {$pres['id']}");
                if ($quoteCheck->num_rows === 0): ?>
                    <a class="quote-btn" href="send_quote.php?prescription_id=<?= $pres['id'] ?>">Send Quotation</a>
                <?php else:
                    $q = $quoteCheck->fetch_assoc(); ?>
                    <span class="status-info">Quotation already sent. Status: <?= htmlspecialchars($q['status']) ?></span>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
