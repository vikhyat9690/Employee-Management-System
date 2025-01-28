<?php   
include "../../config/db.php";

$full_name = htmlspecialchars($_POST['full_name']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$age = intval($_POST['age']);
$qualifications = $_POST['qualifications'];
$experiences = $_POST['experiences'];
$permanent_address = [
    'line1' => htmlspecialchars($_POST['permanent_address_line1']),
    'line2' => htmlspecialchars($_POST['permanent_address_line2']),
    'city' => htmlspecialchars($_POST['permanent_city']),
    'state' => htmlspecialchars($_POST['permanent_state']),
];

$current_address = [
    'line1' => htmlspecialchars($_POST['current_address_line1']),
    'line2' => htmlspecialchars($_POST['current_address_line2']),
    'city' => htmlspecialchars($_POST['current_city']),
    'state' => htmlspecialchars($_POST['current_state']),
];

// Directory paths
$profile_picture = $_FILES['profile_picture'];
$upload_dir = '../../assets/profilePics/uploads/'; // Absolute path for saving files
$relative_upload_dir = 'assets/profilePics/uploads/'; // Relative path for referencing in the database

// Create the directory if it doesn't exist
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Validate and move the uploaded file
if ($profile_picture['error'] === UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($profile_picture['tmp_name']);

    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type. Only JPEG, PNG, and GIF files are allowed.");
    }

    $file_ext = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
    $unique_name = uniqid('profile_', true) . '.' . $file_ext;

    $absolute_path = $upload_dir . $unique_name; // Full path for saving
    $relative_path = $relative_upload_dir . $unique_name; // Relative path for database

    if (move_uploaded_file($profile_picture['tmp_name'], $absolute_path)) {
        $profile_picture_path = $relative_path; // Store relative path in the database
    } else {
        die("Failed to upload profile picture.");
    }
} else {
    die("Error uploading profile picture: " . $profile_picture['error']);
}


// Begin transaction
$conn->begin_transaction();

try {
    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users 
        (full_name, email, password, age, permanent_address_line1, permanent_address_line2, permanent_city, permanent_state,
        current_address_line1, current_address_line2, current_city, current_state, profile_picture) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssisssssssss",
        $full_name, $email, $password, $age,
        $permanent_address['line1'], $permanent_address['line2'], $permanent_address['city'], $permanent_address['state'],
        $current_address['line1'], $current_address['line2'], $current_address['city'], $current_address['state'],
        $profile_picture_path
    );

    $stmt->execute();
    $user_id = $stmt->insert_id;

    // Insert qualifications
    $stmt = $conn->prepare("INSERT INTO qualifications (user_id, qualification) VALUES (?, ?)");
    foreach ($qualifications as $qualification) {
        $qualification_cleaned = htmlspecialchars($qualification);
        $stmt->bind_param("is", $user_id, $qualification_cleaned);
        $stmt->execute();
    }

    // Insert experiences
    $stmt = $conn->prepare("INSERT INTO experiences (user_id, experience) VALUES (?, ?)");
    foreach ($experiences as $experience) {
        $experience_cleaned = htmlspecialchars($experience);
        $stmt->bind_param("is", $user_id, $experience_cleaned);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();
    header("Location: login.php?signup=success");
} catch (Exception $e) {
    // Rollback transaction on failure
    $conn->rollback();
    die("Error: " . $e->getMessage());
}
?>
