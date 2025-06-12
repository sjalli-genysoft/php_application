<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $position = trim($_POST['position']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (!preg_match("/^[A-Za-z ]{3,}$/", $name)) {
        echo "Invalid name format.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO employees (name, email, position) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $position);
        if ($stmt->execute()) {
            echo "Employee added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Database error.";
    }
}
?>
