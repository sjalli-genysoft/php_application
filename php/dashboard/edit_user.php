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

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Image handling
    $image = $user['image'];
    if (!empty($_FILES['image']['name'])) {
        $img_name = basename($_FILES['image']['name']);
        $target = "../uploads/" . $img_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $image = $img_name;
    }

    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, gender=?, dob=?, country=?, state=?, city=?, image=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $full_name, $email, $gender, $dob, $country, $state, $city, $image, $id);

    if ($stmt->execute()) {
        header("Location: manage_users.php");
        exit();
    } else {
        $error = "Failed to update user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="form-container">
    <h2>Edit User</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Full Name:</label>
        <input type="text" name="full_name" required value="<?= htmlspecialchars($user['full_name']) ?>">

        <label>Email:</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>">

        <label>Gender:</label>
        <select name="gender" required>
            <option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
        </select>

        <label>DOB:</label>
        <input type="date" name="dob" value="<?= $user['dob'] ?>">

        <label>Country:</label>
        <input type="text" name="country" value="<?= htmlspecialchars($user['country']) ?>">

        <label>State:</label>
        <input type="text" name="state" value="<?= htmlspecialchars($user['state']) ?>">

        <label>City:</label>
        <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>">

        <label>Profile Image:</label>
        <input type="file" name="image">
        <?php if (!empty($user['image']) && file_exists("../uploads/" . $user['image'])): ?>
            <img src="../uploads/<?= $user['image'] ?>" width="100" style="margin-top:10px;">
        <?php endif; ?>

        <br><br>
        <button type="submit">Update User</button>
        <a href="manage_users.php" class="btn-cancel">Cancel</a>
    </form>
</div>
</body>
</html>
