<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$admin_id = $_SESSION['admin'];
$result = $conn->query("SELECT * FROM users WHERE id = $admin_id");

if ($result->num_rows === 0) {
    echo "Admin not found.";
    exit();
}

$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .profile-container img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile-container h2 {
            margin-bottom: 10px;
        }

        .profile-container p {
            margin: 8px 0;
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="profile-container" align="center">
    <h2>Admin Profile</h2>

    <?php if (!empty($admin['image']) && file_exists("uploads/" . $admin['image'])): ?>
        <img src="uploads/<?= $admin['image'] ?>" alt="Profile Picture">
    <?php else: ?>
        <img src="assets/default-profile.png" alt="Default Profile">
    <?php endif; ?>

    <p><strong>Name:</strong> <?= htmlspecialchars($admin['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>
    <p><strong>Gender:</strong> <?= ucfirst($admin['gender']) ?></p>
    <p><strong>Date of Birth:</strong> <?= $admin['dob'] ?></p>
    <p><strong>Country:</strong> <?= $admin['country'] ?></p>
    <p><strong>State:</strong> <?= $admin['state'] ?></p>
    <p><strong>City:</strong> <?= $admin['city'] ?></p>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
