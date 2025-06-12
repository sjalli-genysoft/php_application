<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($fullname) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $error = "Name must only contain letters and spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format. Format: string@string.com";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/", $password)) {
        $error = "Password must be at least 8 characters, include upper/lowercase, number, and special character.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, MD5(?))");
        $stmt->bind_param("sss", $fullname, $email, $password);
        if ($stmt->execute()) {
            $success = "User created successfully.";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 400px;
            background: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper i {
            position: absolute;
            top: 14px;
            right: 15px;
            cursor: pointer;
            color: #555;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #333;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Create New User</h2>
    <form method="POST" onsubmit="return validateCreateUserForm()">
        <input type="text" name="fullname" id="fullname" placeholder="Full Name">
        <input type="email" name="email" id="new_email" placeholder="Email">

        <div class="password-wrapper">
            <input type="password" name="password" id="new_password" placeholder="Password">
            <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>

        <button type="submit">Create</button>
    </form>
    <p class="success"><?= $success ?></p>
    <p class="error"><?= $error ?></p>
</div>

<script>
function validateCreateUserForm() {
    const name = document.getElementById("fullname").value.trim();
    const email = document.getElementById("new_email").value.trim();
    const password = document.getElementById("new_password").value.trim();

    if (!name || !email || !password) {
        alert("All fields are required.");
        return false;
    }

    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Full name should contain only letters and spaces.");
        return false;
    }

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Invalid email format. Format: string@string.com");
        return false;
    }

    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/;
    if (!passwordPattern.test(password)) {
        alert("Password must be 8+ characters with uppercase, lowercase, number, and special character.");
        return false;
    }

    return true;
}

document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("new_password");

    toggle.addEventListener("click", () => {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        toggle.classList.toggle("fa-eye");
        toggle.classList.toggle("fa-eye-slash");
    });
});
</script>
</body>
</html>