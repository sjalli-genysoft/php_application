<?php
$conn = new mysqli("localhost", "root", "", "employee_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
