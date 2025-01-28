<?php
session_start();

// Include the database connection
include('../../config/db.php');
include_once "../../config/middleware.php";

isAuthenticated();

// Fetch employees from the database
$sql = "SELECT * FROM users";  // Assuming 'employees' is the table where employee information is stored
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Table header
    echo "<h2>Manage Employees</h2>";
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>";
    
    // Display employee records
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['full_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['role'] . "</td>
                <td>
                    <a href='edit_employee.php?id=" . $row['id'] . "'>Edit</a> | 
                    <a href='delete_employee.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this employee?\");'>Delete</a>
                </td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "No employees found.";
}

$conn->close();
?>
