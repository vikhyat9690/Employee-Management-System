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
            $value = htmlspecialchars($_POST['value'] ?? '', ENT_QUOTES, 'UTF-8');

            $allowed_fields = ['full_name', 'age', 'permanent_address_line1', 'permanent_address_line2', 'permanent_city', 'permanent_state', 'current_address_line1', 'current_address_line2', 'current_city', 'current_state'];
            if (in_array($field, $allowed_fields)) {
                // Validate specific fields
                if ($field === 'age' && (!is_numeric($value) || $value < 18 || $value > 100)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid age']);
                    exit;
                }

                // Use a prepared statement dynamically
                $stmt = $conn->prepare("UPDATE users SET " . $field . " = ? WHERE id = ?");
                $stmt->bind_param('si', $value, $user_id);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    error_log("Update failed: " . $stmt->error);
                    echo json_encode(['success' => false, 'message' => 'Failed to update field']);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid field']);
            }
            break;

        case 'add_qualification':
            $qualification = htmlspecialchars($_POST['qualification'] ?? '', ENT_QUOTES, 'UTF-8');

            if (empty($qualification) || strlen($qualification) > 255) {
                echo json_encode(['success' => false, 'message' => 'Invalid qualification']);
                exit;
            }

            $stmt = $conn->prepare("INSERT INTO qualifications (user_id, qualification) VALUES (?, ?)");
            $stmt->bind_param('is', $user_id, $qualification);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
            } else {
                error_log("Insert failed: " . $stmt->error);
                echo json_encode(['success' => false, 'message' => 'Failed to add qualification']);
            }
            $stmt->close();
            break;

        case 'remove_qualification':
            $id = intval($_POST['id']);

            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid qualification ID']);
                exit;
            }

            $stmt = $conn->prepare("DELETE FROM qualifications WHERE id = ? AND user_id = ?");
            $stmt->bind_param('ii', $id, $user_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                error_log("Delete failed: " . $stmt->error);
                echo json_encode(['success' => false, 'message' => 'Failed to remove qualification']);
            }
            $stmt->close();
            break;

        case 'update_profile_picture':
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../../assets/uploads/profilePics/uploads/'; // Change this to your actual upload directory
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                $maxFileSize = 2 * 1024 * 1024; // 2MB limit

                $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                $fileName = basename($_FILES['profile_picture']['name']);
                $fileSize = $_FILES['profile_picture']['size'];
                $fileType = mime_content_type($fileTmpPath);
                $newFileName = uniqid('profile_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $destinationPath = $uploadDir . $newFileName;

                // Validate file type
                if (!in_array($fileType, $allowedTypes)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type']);
                    exit;
                }

                // Validate file size
                if ($fileSize > $maxFileSize) {
                    echo json_encode(['success' => false, 'message' => 'File size exceeds the 2MB limit']);
                    exit;
                }

                // Move uploaded file to the destination
                if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                    // Store the new profile picture path in the database
                    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
                    $stmt->bind_param('si', $newFileName, $user_id);
                    if ($stmt->execute()) {
                        echo json_encode(['success' => true, 'profile_picture' => $newFileName]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update database']);
                    }
                    $stmt->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No file uploaded']);
            }
            break;


        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
}
