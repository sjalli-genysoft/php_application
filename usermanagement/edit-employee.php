<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";

$nameErr = $emailErr = "";
$successMsg = $errorMsg = "";
$isValid = true;

if (!isset($_GET['id'])) {
    echo "No employee ID specified.";
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Employee not found.";
    exit();
}
$employee = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $position = trim($_POST['position']);
    $join_date = trim($_POST['join_date']);

    // Name validation
    if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $nameErr = "Only letters and spaces allowed in name.";
        $isValid = false;
    }

    // Email validation
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z]{2,}\.(com|org|net|in|edu|gov)$/", $email)) {
        $emailErr = "Invalid email format.";
        $isValid = false;
    } elseif (preg_match('/\s/', $email)) {
        $emailErr = "Email must not contain spaces.";
        $isValid = false;
    }

    // Check if email is used by another employee
    $check = $conn->prepare("SELECT id FROM employees WHERE email = ? AND id != ?");
    $check->bind_param("si", $email, $id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $emailErr = "Email already taken by another employee.";
        $isValid = false;
    }
    $check->close();

    // If valid, update
    if ($isValid) {
        $update = $conn->prepare("UPDATE employees SET name=?, email=?, position=?, join_date=? WHERE id=?");
        $update->bind_param("ssssi", $name, $email, $position, $join_date, $id);
        if ($update->execute()) {
            $successMsg = "Employee updated successfully.";
            // Refresh values
            $employee['name'] = $name;
            $employee['email'] = $email;
            $employee['position'] = $position;
            $employee['join_date'] = $join_date;
        } else {
            $errorMsg = "Failed to update employee.";
        }
        $update->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
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
    <h2>Edit Employee</h2>

    <?php if ($successMsg) echo "<p class='success'>$successMsg</p>"; ?>
    <?php if ($errorMsg) echo "<p class='error'>$errorMsg</p>"; ?>

    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name"
               pattern="^[A-Za-z\s]+$"
               title="Only letters and spaces allowed"
               value="<?php echo htmlspecialchars($employee['name']); ?>"
               required>
        <div class="error"><?php echo $nameErr; ?></div>

        <label for="email">Email</label>
        <input type="email" name="email"
               pattern="[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z]{2,}\.(com|org|net|in|edu|gov)"
               title="Valid email required"
               value="<?php echo htmlspecialchars($employee['email']); ?>"
               required>
        <div class="error"><?php echo $emailErr; ?></div>

        <label for="position">Position</label>
        <input type="text" name="position"
               value="<?php echo htmlspecialchars($employee['position']); ?>" required>

        <label for="join_date">Join Date</label>
        <input type="date" name="join_date"
               value="<?php echo htmlspecialchars($employee['join_date']); ?>" required>

        <input type="submit" value="Update Employee">
    </form>

    <a class="back-link" href="employee-list.php">← Back to Employee List</a>
</div>

</body>
</html>