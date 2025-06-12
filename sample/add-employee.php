<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

$nameErr = $emailErr = "";
$name = $email = $position = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    if (empty(trim($_POST["name"]))) {
        $nameErr = "Name is required";
        $valid = false;
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    $position = htmlspecialchars($_POST["position"]);

    if ($valid) {
        $stmt = $conn->prepare("INSERT INTO employees (name, email, position) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $position);
        $stmt->execute();
        $success = "Employee added successfully!";
        $name = $email = $position = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .form-container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Add New Employee</h4>
            </div>
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="post" action="" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control <?php echo $nameErr ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" required>
                        <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" id="email" class="form-control <?php echo $emailErr ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required>
                        <div class="invalid-feedback"><?php echo $emailErr; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control" value="<?php echo $position; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                    <a href="employee-list.php" class="btn btn-secondary">Back to List</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        
        

        // Bootstrap validation style enhancement
        (() => {
            'use strict';
            const forms = document.querySelectorAll('form');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>