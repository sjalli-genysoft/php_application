<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=employees.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Column headings
fputcsv($output, ['ID', 'Name', 'Email', 'Position', 'Created At']);

// Fetch employee data
$result = $conn->query("SELECT id, name, email, position, created_at FROM employees");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
