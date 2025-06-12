<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $sql = "SELECT * FROM users WHERE email=? AND password=MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $_SESSION["user"] = $result->fetch_assoc();
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST" onsubmit="return validateLoginForm()">
        <input type="email" name="email" id="email" placeholder="Email">
        <input type="password" name="password" id="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
</div>
<script src="validation.js"></script>
</body>
</html>




<!-- sql -->
<!-- CREATE DATABASE IF NOT EXISTS project_db;
USE project_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert an admin user: admin@example.com / admin123
INSERT INTO users (fullname, email, password)
VALUES ('Admin User', 'admin@example.com', MD5('admin123'));
-->