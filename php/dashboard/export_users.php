<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

// Set headers to prompt download
header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=users_export_" . date("Y-m-d") . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

// Open output stream
$output = fopen("php://output", "w");

// CSV Column Headers
fputcsv($output, ['ID', 'Full Name', 'Email', 'Gender', 'DOB', 'Country', 'State', 'City', 'Image']);

// Fetch data
$query = $conn->query("SELECT * FROM users ORDER BY id DESC");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['full_name'],
            $row['email'],
            $row['gender'],
            $row['dob'],
            $row['country'],
            $row['state'],
            $row['city'],
            $row['image']
        ]);
    }
}

fclose($output);
exit;
?>
