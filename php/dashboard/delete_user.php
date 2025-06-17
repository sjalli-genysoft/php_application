<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = (int) $_GET['id'];

// Get user to delete associated image
$user = $conn->query("SELECT image FROM users WHERE id = $id")->fetch_assoc();

if ($user) {
    // Delete image if exists
    if (!empty($user['image']) && file_exists("../uploads/" . $user['image'])) {
        unlink("../uploads/" . $user['image']);
    }

    // Delete user record
    $conn->query("DELETE FROM users WHERE id = $id");
}

header("Location: manage_users.php");
exit();
?>
