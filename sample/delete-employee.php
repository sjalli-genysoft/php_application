<?php
session_start();
if (!isset($_SESSION['user'])) {
    exit("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailToDelete = trim($_POST['email']);
    $xmlFile = "xml/employees.xml";

    if (!file_exists($xmlFile)) {
        exit("Employee data not found.");
    }

    $xml = simplexml_load_file($xmlFile);
    $indexToRemove = -1;

    foreach ($xml->employee as $index => $emp) {
        if ((string)$emp->email === $emailToDelete) {
            $indexToRemove = $index;
            break;
        }
    }

    if ($indexToRemove >= 0) {
        unset($xml->employee[$indexToRemove]);
        $xml->asXML($xmlFile);
        echo "Employee deleted successfully.";
    } else {
        echo "Employee not found.";
    }
} else {
    echo "Invalid request.";
}
