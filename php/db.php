<?php
$host = "localhost";
$username = "root";
$password = ""; // Update this if your MySQL has a password
$database = "php_application";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
