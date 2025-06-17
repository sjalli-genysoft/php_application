<?php
include "../db.php";

if (isset($_GET["state_id"])) {
    $state_id = intval($_GET["state_id"]);
    $query = "SELECT id, name FROM cities WHERE state_id = $state_id ORDER BY name";
    $result = $conn->query($query);

    echo '<option value="">Select City</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
?>
