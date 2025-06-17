<?php
include "../db.php";

if ($_GET['type'] == 'country') {
    $query = "SELECT id, name FROM countries ORDER BY name";
    $result = $conn->query($query);

    echo '<option value="">Select Country</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
?>
