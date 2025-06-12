<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$nameErr = $emailErr = "";
$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $position = trim($_POST['position']);
    $join_date = trim($_POST['join_date']);

    $isValid = true;

    // Validate name: only letters and spaces
    if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $nameErr = "Only letters and spaces allowed in name.";
        $isValid = false;
    }

    // Validate email: must start with a letter, valid domain and allowed TLDs
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z]{2,}\.(com|org|net|in|edu|gov)$/", $email)) {
        $emailErr="Invalid email format";
        //$emailErr = "Invalid email format. It must start with a letter, have 2+ letter domain, and end in .com, .org, .net, .in, .edu, or .gov";
        $isValid = false;
    } elseif (preg_match('/\s/', $email)) {
        $emailErr = "Email must not contain spaces.";
        $isValid = false;
    }

    // Check if email already exists
    if ($isValid) {
        $check = $conn->prepare("SELECT id FROM employees WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $errorMsg = "Email already exists!";
            $isValid = false;
        }
        $check->close();
    }

    // Insert into database
    if ($isValid) {
        $stmt = $conn->prepare("INSERT INTO employees (name, email, position, join_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $position, $join_date);
        $stmt->execute();
        $stmt->close();
        $successMsg = "Employee added successfully.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f8;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            background: white;
            padding: 30px 40px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #444;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Employee</h2>

    <?php if ($successMsg) echo "<p class='success'>$successMsg</p>"; ?>
    <?php if ($errorMsg) echo "<p class='error'>$errorMsg</p>"; ?>

    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name"
               pattern="^[A-Za-z\s]+$"
               title="Only letters and spaces allowed"
               required>
        <div class="error"><?php echo $nameErr; ?></div>

        <label for="email">Email</label>
        <input type="email" name="email"
               pattern="[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z]{2,}\.(com|org|net|in|edu|gov)"
               title="Must start with a letter, have 2+ letter domain, and end in .com, .org, .net, .in, .edu, or .gov"
               required>
        <div class="error"><?php echo $emailErr; ?></div>

        <label for="position">Position</label>
        <input type="text" name="position" required>

        <label for="join_date">Join Date</label>
        <input type="date" name="join_date" required>

        <input type="submit" value="Add Employee">
    </form>

    <a class="back-link" href="employee-list.php">← Back to Employee List</a>
</div>

</body>
</html>
