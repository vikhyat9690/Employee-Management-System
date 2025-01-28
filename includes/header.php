<!-- header.php -->
<nav>
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
</nav>
