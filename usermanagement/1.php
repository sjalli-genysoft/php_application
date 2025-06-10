<?php
session_start();
include "db.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-light: #f0f2f5;
            --bg-dark: #1e1e2f;
            --text-light: #333;
            --text-dark: #f1f1f1;
            --box-light: #fff;
            --box-dark: #2c2f4a;
            --primary: #007bff;
            --primary-dark: #0056b3;
            --danger: #dc3545;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-light);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        body.dark {
            background-color: var(--bg-dark);
            color: var(--text-dark);
        }

        .login-box {
            background-color: var(--box-light);
            border-radius: 10px;
            padding: 40px 50px;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: background-color 0.3s ease;
        }

        body.dark .login-box {
            background-color: var(--box-dark);
        }

        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: var(--primary-dark);
        }

        .error-message {
            color: var(--danger);
            margin-top: 10px;
        }

        .toggle-container {
            margin-top: 20px;
            font-size: 14px;
        }

        .toggle-container button {
            background-color: transparent;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-weight: bold;
        }

        body.dark .toggle-container button {
            color: #66ccff;
        }
    </style>
</head>
<body>

<div class="login-box">
    <!-- Logo -->
    <img src="logo.png" alt="Company Logo" class="logo"> <!-- Replace with your logo file -->
    
    <h2>Admin Login</h2>
    <form method="post">
        <input type="text" name="username" required placeholder="Username">
        <input type="password" name="password" required placeholder="Password">
        <input type="submit" value="Login">
        <div class="error-message"><?php echo $error; ?></div>
    </form>

    <div class="toggle-container">
        <span>Toggle Dark Mode:</span>
        <button onclick="toggleDarkMode()">Switch</button>
    </div>
</div>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle("dark");
        localStorage.setItem("darkMode", document.body.classList.contains("dark"));
    }

    // Load saved theme preference
    window.onload = () => {
        if (localStorage.getItem("darkMode") === "true") {
            document.body.classList.add("dark");
        }
    };
</script>

</body>
</html>
