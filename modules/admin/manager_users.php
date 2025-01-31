<?php
include '../../config/db.php';
session_start();

// Check if the user is an admin or manager
if (!in_array($_SESSION['role'], ['admin', 'manager'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch all users
$query = "SELECT id, full_name, email, role FROM users";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../assets/style/manage_users.css">
</head>

<body>
    <nav>
        <ul>
            <?php if ($user['role'] === 'admin') {
                echo "<li><a href = '../admin/admin_setting.php'>Admin Settings</a></li>";
            } ?>
            <?php if ($user['role'] === 'admin' || $user['role'] === 'manager') {
                echo "<li><a href = '../admin/manager_users.php'>Manage Employee</a></li>";
            } ?>
            <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="main-container">
        <h1>Manage Users</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="manage_user.php?id=<?php echo $user['id']; ?>">View/Edit</a>
                            <a href="manage_user_handler.php?action=delete&id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include_once "../../includes/footer.php"; ?>
</body>

</html>