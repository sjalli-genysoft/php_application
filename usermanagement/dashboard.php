<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";
$emp_count = $conn->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #343a40;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .buttons a {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 24px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover {
            background-color: #0056b3;
        }

        .logout {
            background-color: #dc3545;
        }

        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Admin</h2>
    <p>Total Employees: <strong><?php echo $emp_count; ?></strong></p>

    <div class="buttons">
        <a href="add-employee.php">Add New Employee</a>
        <a href="employee-list.php">View Employees</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

</body>
</html>
