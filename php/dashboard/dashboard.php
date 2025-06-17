<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        nav ul li {
            margin: 10px;
        }

        nav ul li a {
            display: inline-block;
            padding: 10px 18px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
    <p style="text-align:center;">You are logged in as <strong><?= htmlspecialchars($_SESSION["user_role"]) ?></strong>.</p>

    <nav>
        <ul>
            <li><a href="create_user.php">Create User</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <?php if ($_SESSION["user_role"] == "admin"): ?>
                <li><a href="manage_location.php">Manage Locations</a></li>
                <li><a href="export_users.php">Export Users</a></li>
                <li><a href="../create_admin.php">Create Admin</a></li>
            <?php endif; ?>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>

</body>
</html>
