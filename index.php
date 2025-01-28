<?php
session_start();
include "./config/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get logged-in user's details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT full_name, email, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// If the user is an admin, fetch employee data
if ($_SESSION['role'] == 'admin') {
    $stmt = $conn->prepare("SELECT COUNT(id) AS total_employees FROM users WHERE role = 'employee'");
    $stmt->execute();
    $employee_count = $stmt->get_result()->fetch_assoc()['total_employees'];
}

?>

<?php if ($_SESSION['role'] == 'admin'): ?>
    <style>
        .quick-actions {
        background-color: #f9f9f9;
        border-radius: 5px;
        padding: 15px;
    }
    .action-btn {
        background-color: #28a745;
        color: white;
    }
    </style>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./assets/style/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header>
            <div class="user-info">
                <img src="./assets/profilePics/uploads/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="profile-img">
                <span>Welcome, <?php echo $user['full_name']; ?>!</span>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <div class="main-content">
            <!-- Quick Actions (visible to admin) -->
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <div class="quick-actions">
                    <a href="add_employee.php" class="action-btn">Add New Employee</a>
                    <a href="manage_employees.php" class="action-btn">Manage Employees</a>
                </div>

                <!-- Employee Overview -->
                <div class="overview">
                    <h3>Total Employees</h3>
                    <p><?php echo $employee_count; ?> employees</p>
                </div>
            <?php endif; ?>

            <!-- Recent Activity (optional, can be added later) -->
            <div class="recent-activity">
                <h3>Recent Activities</h3>
                <ul>
                    <li>Employee John Doe added.</li>
                    <li>Leave request from Jane Smith approved.</li>
                    <!-- Can dynamically populate this section from a "logs" table or similar -->
                </ul>
            </div>
            <div><a href="logout.php">Logout</a></div>
           
        </div>
    </div>
</body>
</html>
