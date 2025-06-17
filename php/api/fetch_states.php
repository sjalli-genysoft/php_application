<?php
include "../db.php";

if (isset($_GET["country_id"])) {
    $country_id = intval($_GET["country_id"]);
    $query = "SELECT id, name FROM states WHERE country_id = $country_id ORDER BY name";
    $result = $conn->query($query);

    echo '<option value="">Select State</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
?>
