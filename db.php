<?php
$host = 'localhost';
$db = 'prescription_app';
$user = 'root';
$pass = ''; // currently no password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>