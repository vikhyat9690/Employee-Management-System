<?php
session_start();
include "../../config/db.php";

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = trim($_POST['password']);
$role = trim($_POST['role']); // Get role from the form

// Validate input
if (empty($email) || empty($password) || empty($role)) {
    die("All fields are required.");
}

try {
    $conn->begin_transaction();

    // Fetch user data based on email and role
    $stmt = $conn->prepare("SELECT id, full_name, email, password, profile_picture, role FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_picture'] = $user['profile_picture'];
            $_SESSION['role'] = $user['role'];

            $conn->commit();

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: ../dashboard/dashboard.php");
            } elseif ($user['role'] === 'manager') {
                header("Location: ../dashboard/dashboard.php");
            } elseif ($user['role'] === 'employee') {
                header("Location: ../dashboard/dashboard.php");
            }

            exit();
        } else {
            $conn->rollback();
            die("Invalid email or password.");
        }
    } else {
        $conn->rollback();
        die("Invalid email, role, or password.");
    }
} catch (Exception $e) {
    $conn->rollback();
    die("Error: " . $e->getMessage());
}
?>
