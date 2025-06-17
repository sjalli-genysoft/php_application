<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = trim($_POST['new_password']);
    $userId = $_SESSION['user']['id'];

    if (strlen($newPassword) < 6) {
        die("Password must be at least 6 characters.");
    }

    include "db.php";

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $newPassword, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Password updated successfully.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update password.'); window.location.href='change-password.php';</script>";
    }
}   