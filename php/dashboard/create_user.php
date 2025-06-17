<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "admin") {
    header("Location: index.php");
    exit;
}

include "../db.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role     = $_POST["role"];
    $country  = $_POST["country"];
    $state    = $_POST["state"];
    $city     = $_POST["city"];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed, $role);

        if ($stmt->execute()) {
            $success = "User created successfully!";
        } else {
            $error = "Error: Email might already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-user-plus"></i> Create New User</h2>

        <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

        <form method="POST" action="">
            <label><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="name" required>

            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" required>

            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" required>

            <label><i class="fas fa-user-tag"></i> Role</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <label><i class="fas fa-flag"></i> Country</label>
            <select name="country" id="country" required>
                <option value="">Select Country</option>
            </select>

            <label><i class="fas fa-map-marker-alt"></i> State</label>
            <select name="state" id="state" required>
                <option value="">Select Country First</option>
            </select>

            <label><i class="fas fa-city"></i> City</label>
            <select name="city" id="city" required>
                <option value="">Select State First</option>
            </select>

            <button type="submit"><i class="fas fa-plus-circle"></i> Create User</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/ajax_location.js"></script>
</body>
</html>
