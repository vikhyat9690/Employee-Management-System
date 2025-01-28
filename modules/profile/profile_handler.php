<?php
session_start();
include "../../config/db.php";
include_once "../../config/middleware.php";

isAuthenticated();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'update_field':
            $field = $_POST['field'] ?? '';
            $value = htmlspecialchars($_POST['value'] ?? '');

            $allowed_fields = ['full_name', 'age', 'permanent_address', 'current_address'];
            if (in_array($field, $allowed_fields)) {
                $stmt = $conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
                $stmt->bind_param('si', $value, $user_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update field']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid field']);
            }
            break;

        case 'add_qualification':
            $qualification = htmlspecialchars($_POST['qualification'] ?? '');
            $stmt = $conn->prepare("INSERT INTO qualifications (user_id, qualification) VALUES (?, ?)");
            $stmt->bind_param('is', $user_id, $qualification);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add qualification']);
            }
            break;

        case 'remove_qualification':
            $id = intval($_POST['id']);
            $stmt = $conn->prepare("DELETE FROM qualifications WHERE id = ? AND user_id = ?");
            $stmt->bind_param('ii', $id, $user_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove qualification']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
}
?>
