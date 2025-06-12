<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    if (!preg_match("/^[A-Za-z ]{3,}$/", $fullname)) {
        die("Invalid full name.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    $xmlFile = "xml/employees.xml";

    if (!file_exists($xmlFile)) {
        $xml = new SimpleXMLElement("<employees></employees>");
    } else {
        $xml = simplexml_load_file($xmlFile);
    }

    // Prevent duplicates
    foreach ($xml->employee as $emp) {
        if ((string)$emp->email === $email) {
            die("Employee with this email already exists.");
        }
    }

    $employee = $xml->addChild("employee");
    $employee->addChild("fullname", $fullname);
    $employee->addChild("email", $email);

    $xml->asXML($xmlFile);

    echo "<script>alert('Employee added successfully'); window.location.href='employee-list.php';</script>";
} else {
    header("Location: employee-add.php");
}      