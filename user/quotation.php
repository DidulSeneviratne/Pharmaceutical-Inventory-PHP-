<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// from here user can update the status wheather accept or not
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'] === 'accept' ? 'accepted' : 'rejected';
    $conn->query("UPDATE quotations SET status = '$action' WHERE id = $id");
    header("Refresh:0; url=quotation.php");
    exit();
}

// Fetch prescriptions relavant to the logged-in user
$prescriptions = $conn->query("SELECT * FROM prescriptions WHERE user_id = $user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Quotations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
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
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        h3 {
            color: #00796b;
            margin-top: 0;
        }

        ul {
            padding-left: 20px;
        }

        .total, .status {
            font-weight: bold;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .accept {
            background-color: #388e3c;
        }

        .reject {
            background-color: #d32f2f;
        }

        .accept:hover {
            background-color: #2e7d32;
        }

        .reject:hover {
            background-color: #c62828;
        }

        .no-quote {
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Quotations</h2>

    <?php while ($pres = $prescriptions->fetch_assoc()): ?>
        <div class="card">
            <h3>Prescription #<?= htmlspecialchars($pres['id']) ?></h3>

            <?php
            $pres_id = (int)$pres['id'];
            $quote = $conn->query("SELECT * FROM quotations WHERE prescription_id = $pres_id")->fetch_assoc();

            if ($quote):
                $items = json_decode($quote['items'], true);
            ?>
                <ul>
                    <?php foreach ($items as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['drug']) ?> - 
                            <?= (int)$item['qty'] ?> @ Rs.<?= number_format($item['price'], 2) ?> = 
                            Rs.<?= number_format($item['qty'] * $item['price'], 2) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="total">Total: Rs. <?= number_format($quote['total'], 2) ?></div>
                <div class="status">Status: <?= htmlspecialchars($quote['status']) ?></div>

                <?php if ($quote['status'] === 'sent'): ?>
                    <a href="?action=accept&id=<?= $quote['id'] ?>" class="btn accept">Accept</a>
                    <a href="?action=reject&id=<?= $quote['id'] ?>" class="btn reject">Reject</a>
                <?php endif; ?>
            <?php else: ?>
                <p class="no-quote">No quotation yet for this prescription.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>

