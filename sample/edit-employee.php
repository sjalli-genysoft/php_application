<?php
session_start();
if (!isset($_SESSION['user'])) {
    exit("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalEmail = trim($_POST['originalEmail']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    if (!preg_match("/^[A-Za-z ]{3,}$/", $fullname)) {
        exit("Invalid full name.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format.");
    }

    $xmlFile = "xml/employees.xml";

    if (!file_exists($xmlFile)) {
        exit("Employee data not found.");
    }

    $xml = simplexml_load_file($xmlFile);
    $found = false;

    foreach ($xml->employee as $emp) {
        if ((string)$emp->email === $originalEmail) {
            $emp->fullname = $fullname;
            $emp->email = $email;
            $found = true;
            break;
        }
    }

    if ($found) {
        $xml->asXML($xmlFile);
        echo "Employee updated successfully.";
    } else {
        echo "Employee not found.";
    }
} else {
    echo "Invalid request.";
}
