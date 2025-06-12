<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 80px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .actions a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

        .logout {
            background-color: #dc3545 !important;
        }

        .logout:hover {
            background-color: #bd2130 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user["fullname"]) ?></h2>
    <div class="actions">
        <a href="create_user.php">Create New User</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>
</body>
</html>
