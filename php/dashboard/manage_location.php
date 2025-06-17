<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

// Fetch locations
$countries = $conn->query("SELECT * FROM countries ORDER BY name ASC");
$states = $conn->query("SELECT * FROM states ORDER BY name ASC");
$cities = $conn->query("SELECT * FROM cities ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Locations</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .box {
            flex: 1;
            min-width: 250px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .box h3 {
            margin-bottom: 10px;
            color: #007bff;
            text-align: center;
        }

        ul {
            list-style: none;
            padding-left: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        li {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<h2>Manage Location Data</h2>

<div class="container">
    <div class="box">
        <h3>Countries</h3>
        <ul>
            <?php while ($row = $countries->fetch_assoc()): ?>
                <li><?= htmlspecialchars($row['name']) ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div class="box">
        <h3>States</h3>
        <ul>
            <?php while ($row = $states->fetch_assoc()): ?>
                <li><?= htmlspecialchars($row['name']) ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div class="box">
        <h3>Cities</h3>
        <ul>
            <?php while ($row = $cities->fetch_assoc()): ?>
                <li><?= htmlspecialchars($row['name']) ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>

</body>
</html>
