<?php
include '../../config/db.php';
session_start();

if (!in_array($_SESSION['role'], ['admin', 'manager'])) {
    header('Location: ../../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id']);

    if ($action === 'update') {
        $full_name = htmlspecialchars($_POST['full_name']);
        $role = htmlspecialchars($_POST['role']);

        $stmt = $conn->prepare("UPDATE users SET full_name = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $full_name, $role, $id);

        if ($stmt->execute()) {
            header("Location: manager_users.php?update=success");
        } else {
            echo "Error updating user.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'delete') {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manager_users.php?delete=success");
    } else {
        echo "Error deleting user.";
    }
}
?>
