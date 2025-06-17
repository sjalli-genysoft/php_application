<?php
include "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country = trim($_POST['country']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);

    // Insert country if not exists
    if (!empty($country)) {
        $checkCountry = $conn->prepare("SELECT id FROM countries WHERE name = ?");
        $checkCountry->bind_param("s", $country);
        $checkCountry->execute();
        $checkCountry->store_result();

        if ($checkCountry->num_rows === 0) {
            $insertCountry = $conn->prepare("INSERT INTO countries (name) VALUES (?)");
            $insertCountry->bind_param("s", $country);
            $insertCountry->execute();
        }
        $checkCountry->close();
    }

    // Insert state if not exists
    if (!empty($state)) {
        $checkState = $conn->prepare("SELECT id FROM states WHERE name = ?");
        $checkState->bind_param("s", $state);
        $checkState->execute();
        $checkState->store_result();

        if ($checkState->num_rows === 0) {
            $insertState = $conn->prepare("INSERT INTO states (name) VALUES (?)");
            $insertState->bind_param("s", $state);
            $insertState->execute();
        }
        $checkState->close();
    }

    // Insert city if not exists
    if (!empty($city)) {
        $checkCity = $conn->prepare("SELECT id FROM cities WHERE name = ?");
        $checkCity->bind_param("s", $city);
        $checkCity->execute();
        $checkCity->store_result();

        if ($checkCity->num_rows === 0) {
            $insertCity = $conn->prepare("INSERT INTO cities (name) VALUES (?)");
            $insertCity->bind_param("s", $city);
            $insertCity->execute();
        }
        $checkCity->close();
    }

    echo "Location updated.";
}
?>
