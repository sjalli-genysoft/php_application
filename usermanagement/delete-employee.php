<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    echo "No ID provided";
    exit;
}

$id = intval($_GET['id']);
$conn->query("DELETE FROM employees WHERE id = $id");

header("Location: employee-list.php");
exit;  