<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../config/db.php";

$adminUsername = $_SESSION['admin'];
$errorMsg = $successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPass = $_POST['old_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
        $errorMsg = "All fields are required.";
    } elseif ($newPass !== $confirmPass) {
        $errorMsg = "New passwords do not match.";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/", $newPass)) {
        $errorMsg = "Password must contain upper, lower, number & be at least 6 characters.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $adminUsername);
        $stmt->execute();
        $stmt->bind_result($hashedPass);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($oldPass, $hashedPass)) {
            $errorMsg = "Old password is incorrect.";
        } else {
            $newHashed = password_hash($newPass, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE admins SET password=? WHERE username=?");
            $update->bind_param("ss", $newHashed, $adminUsername);
            if ($update->execute()) {
                $successMsg = "Password changed successfully.";
            } else {
                $errorMsg = "Error updating password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; padding: 40px; }
        form { max-width: 400px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 6px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        input { width: 100%; padding: 10px; margin: 12px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
    </style>
</head>
<body>

<form method="post">
    <h2>Change Password</h2>

    <?php if ($errorMsg): ?><p class="error"><?= $errorMsg ?></p><?php endif; ?>
    <?php if ($successMsg): ?><p class="success"><?= $successMsg ?></p><?php endif; ?>

    <input type="password" name="old_password" placeholder="Old Password" required>
    <input type="password" name="new_password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
    <button type="submit">Update Password</button>
</form>

</body>
</html>
