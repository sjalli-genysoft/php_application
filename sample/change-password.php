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
    <title>Change Password</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
    function validatePasswordForm() {
        const newPassword = document.forms["passForm"]["new_password"].value.trim();
        const confirmPassword = document.forms["passForm"]["confirm_password"].value.trim();

        if (newPassword.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }
    </script>
</head>
<body>
    <div class="dashboard">
        <h1>Change Password</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="employee-list.php">Employees</a>
            <a href="employee-add.php">Add Employee</a>
            <a href="change-password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </nav>

        <form name="passForm" method="POST" action="update-password.php" onsubmit="return validatePasswordForm();">
            <label>New Password</label>
            <input type="password" name="new_password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
