<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
    function validateForm() {
        const name = document.forms["empForm"]["fullname"].value.trim();
        const email = document.forms["empForm"]["email"].value.trim();
        const nameRegex = /^[A-Za-z ]{3,}$/;
        const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;

        if (!nameRegex.test(name)) {
            alert("Please enter a valid full name (letters and spaces only, at least 3 characters).");
            return false;
        }
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
    <div class="dashboard">
        <h1>Add New Employee</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="employee-list.php">Employees</a>
            <a href="employee-add.php">Add Employee</a>
            <a href="change-password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </nav>

        <form name="empForm" method="POST" action="save-employee.php" onsubmit="return validateForm();">
            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <button type="submit">Add Employee</button>
        </form>
    </div>
</body>
</html>
