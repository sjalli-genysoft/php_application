<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    echo "No ID provided";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM employees WHERE id = $id");

if ($result->num_rows == 0) {
    echo "Employee not found";
    exit;
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $position = $conn->real_escape_string($_POST['position']);
    $join_date = $conn->real_escape_string($_POST['join_date']);

    $conn->query("UPDATE employees SET 
        name = '$name', 
        email = '$email', 
        position = '$position', 
        join_date = '$join_date' 
        WHERE id = $id");

    header("Location: employee-list.php");
    exit;
}
?>

<h2>Edit Employee</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
    Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
    Position: <input type="text" name="position" value="<?php echo $row['position']; ?>" required><br><br>
    Join Date: <input type="date" name="join_date" value="<?php echo $row['join_date']; ?>" required><br><br>
    <input type="submit" value="Update">
</form>
<a href="employee-list.php">Back</a>
