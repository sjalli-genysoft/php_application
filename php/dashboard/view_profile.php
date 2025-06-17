<?php
session_start();
include "db.php";

// Check if user is logged in (admin or user role)
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['user'];

$result = $conn->query("SELECT * FROM users WHERE id = $user_id");

if ($result->num_rows === 0) {
    echo "Profile not found.";
    exit();
}

$user = $result->fetch_assoc();
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
            background: #28a745;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="profile-container" align="center">
    <h2>My Profile</h2>

    <?php if (!empty($user['image']) && file_exists("uploads/" . $user['image'])): ?>
        <img src="uploads/<?= $user['image'] ?>" alt="Profile Picture">
    <?php else: ?>
        <img src="assets/default-profile.png" alt="Default Profile">
    <?php endif; ?>

    <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Gender:</strong> <?= ucfirst($user['gender']) ?></p>
    <p><strong>Date of Birth:</strong> <?= $user['dob'] ?></p>
    <p><strong>Country:</strong> <?= $user['country'] ?></p>
    <p><strong>State:</strong> <?= $user['state'] ?></p>
    <p><strong>City:</strong> <?= $user['city'] ?></p>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
