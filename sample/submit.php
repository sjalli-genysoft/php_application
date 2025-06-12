<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters.");
    }

    $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ? AND password = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $userEmail);
        $stmt->fetch();

        $_SESSION['user'] = [
            'id' => $id,
            'email' => $userEmail
        ];
        $_SESSION['username'] = $userEmail; // ✅ Fixed

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
    }
}
?>
