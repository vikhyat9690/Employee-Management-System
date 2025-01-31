<?php
include '../../config/db.php';
session_start();

if (!in_array($_SESSION['role'], ['admin', 'manager'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = intval($_GET['id']);
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" href="../../assets/style/manage_users.css">
</head>

<body>
    <nav>
        <ul>
            <?php if ($user['role'] === 'admin') {
                echo "<li><a href = './admin_setting.php'>Admin Settings</a></li>";
            } ?>
            <?php if ($user['role'] === 'admin' || $user['role'] === 'manager') {
                echo "<li><a href = '../admin/manager_users.php'>Manage Employee</a></li>";
            } ?>
            <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="main-container">
        <form action="manage_user_handler.php" method="POST">
            <h1>Manage User</h1>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br>
            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="manager" <?php if ($user['role'] == 'manager') echo 'selected'; ?>>Manager</option>
                <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
            </select><br>
            <button type="submit" name="action" value="update">Update User</button>
        </form>
    </div>
</body>

</html>