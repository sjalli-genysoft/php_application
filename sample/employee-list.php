<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Employee List</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="employee-list.php">Employees</a>
            <a href="employee-add.php">Add Employee</a>
            <a href="change-password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </nav>

        <!-- <a href="export.php" target="_blank" class="btn">📁 Export Employees to CSV</a> -->

        <table id="employeeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filled via AJAX -->
            </tbody>
        </table>
    </div>

    <script>
    function loadEmployees() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "xml/employees.xml", true);
        xhr.onload = function () {
            const xml = xhr.responseXML;
            const employees = xml.getElementsByTagName("employee");
            const tbody = document.querySelector("#employeeTable tbody");
            tbody.innerHTML = "";

            for (let i = 0; i < employees.length; i++) {
                const fullname = employees[i].getElementsByTagName("fullname")[0].textContent;
                const email = employees[i].getElementsByTagName("email")[0].textContent;

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${i + 1}</td>
                    <td><input value="${fullname}" id="name_${i}"></td>
                    <td><input value="${email}" id="email_${i}"></td>
                    <td class="actions">
                        <button onclick="updateEmployee(${i}, '${email}')">Save</button>
                        <button onclick="deleteEmployee('${email}')">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            }
        };
        xhr.send();
    }

    function updateEmployee(index, originalEmail) {
        const fullname = document.getElementById(`name_${index}`).value;
        const email = document.getElementById(`email_${index}`).value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "edit-employee.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            alert(xhr.responseText);
            loadEmployees();
        };
        xhr.send(`originalEmail=${encodeURIComponent(originalEmail)}&fullname=${encodeURIComponent(fullname)}&email=${encodeURIComponent(email)}`);
    }

    function deleteEmployee(email) {
        if (!confirm("Are you sure you want to delete this employee?")) return;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete-employee.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            alert(xhr.responseText);
            loadEmployees();
        };
        xhr.send("email=" + encodeURIComponent(email));
    }

    window.onload = loadEmployees;
    </script>
</body>
</html>
