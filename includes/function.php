<?php
function uploadFile($file, $upload_dir) {
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $file['error']);
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        die("Invalid file type. Only JPEG, PNG, and GIF files are allowed.");
    }

    // Validate file size (e.g., max 2MB)
    $max_size = 2 * 1024 * 1024; // 2MB
    if ($file['size'] > $max_size) {
        die("File size exceeds the maximum limit of 2MB.");
    }

    // Generate a unique file name
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $unique_name = uniqid('profile_', true) . '.' . $file_ext;

    // Construct the full file path
    $target_file = $upload_dir . $unique_name;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        die("Failed to upload file.");
    }

    // Return the file path for storage in the database
    return $target_file;
}
?>
