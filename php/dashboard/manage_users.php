<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .top-bar {
            text-align: right;
            margin-bottom: 15px;
        }

        .top-bar a {
            text-decoration: none;
            background: #28a745;
            color: #fff;
            padding: 8px 15px;
            border-radius: 4px;
            margin-left: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
            font-size: 14px;
        }

        th {
            background: #007bff;
            color: white;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
        }

        .edit-btn {
            background: #17a2b8;
        }

        .delete-btn {
            background: #dc3545;
        }
    </style>
</head>
<body>

<h2>Manage Users</h2>

<div class="top-bar">
    <a href="create_user.php">➕ Add User</a>
    <a href="export_users.php">📥 Export to Excel</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($users->num_rows > 0): ?>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
                    <?php if (!empty($row['image']) && file_exists("../uploads/" . $row['image'])): ?>
                        <img src="../uploads/<?= $row['image'] ?>" alt="Profile">
                    <?php else: ?>
                        <img src="../assets/default-profile.png" alt="Default">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= ucfirst($row['gender']) ?></td>
                <td><?= $row['dob'] ?></td>
                <td><?= $row['country'] ?></td>
                <td><?= $row['state'] ?></td>
                <td><?= $row['city'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="10">No users found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
