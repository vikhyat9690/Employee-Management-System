<?php
session_start();
include("../../config/db.php");
include_once "../../config/middleware.php";

isAuthenticated();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Check user role
$role = $user['role'];  // 'admin', 'manager', or 'employee'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../assets/style/dashboard.css">
</head>
<body>
    <?php include_once "../../includes/header.php"; ?>
    <div class="container">

        <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>

        <!-- <nav>
            <ul>
                <li><a href="../profile/profile.php">Profile</a></li>
                <?php if ($role == 'admin' || $role == 'manager') : ?>
                    <li><a href="../admin/manager_users.php">Manage Users</a></li>
                <?php endif; ?>
                <?php if ($role == 'admin') : ?>
                    <li><a href="../admin/admin_setting.php">Admin Settings</a></li>
                <?php endif; ?>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav> -->

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <?php if ($role == 'admin') : ?>
                <div class="admin-dashboard">
                    <h2>Admin Dashboard</h2>
                    <p>Welcome, Admin! You can manage users and settings.</p>
                </div>
            <?php elseif ($role == 'manager') : ?>
                <div class="manager-dashboard">
                    <h2>Manager Dashboard</h2>
                    <p>Welcome, Manager! You can manage certain aspects of the system.</p>
                </div>
            <?php else : ?>
                <div class="employee-dashboard">
                    <h2>Employee Dashboard</h2>
                    <p>Welcome, Employee! You have access to your profile and basic features.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
<?php include_once "../../includes/footer.php"; ?>
</html>
