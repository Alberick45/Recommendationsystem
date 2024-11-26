<?php
// DATABASE CONNECTION DETAILS
$host = "localhost";
$port = 3307;
$db = "event-recommendation";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;port=$port;dbname=$db";

try {
    // CREATING A NEW PDO INSTANCE FOR DATABASE CONNECTION
    $conn = new PDO($dsn, $username, $password);
    // SETTING ERROR MODE TO THROW EXCEPTIONS
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // No echo here to avoid sending output before headers
} catch (PDOException $e) {
    // HANDLING CONNECTION ERRORS
    die("Database connection failed: " . $e->getMessage());
}
?>
