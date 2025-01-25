<?php   
    include "../../config/db.php";
    include "../../includes/function.php";


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

    //Handle profile picture upload
    $profile_picture = $_FILES['profile_picture'];
    $upload_dir = '../../assets/profilePics/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory with appropriate permissions
    }
    $profile_picture_path = uploadFile($profile_picture, $upload_dir);
    

    //Insert user data into database
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO users 
        (full_name, email, password, age, permanent_address_line1, permanent_address_line2, permanent_city, permanent_state,
        current_address_line1, current_address_line2, current_city, current_state, profile_picture) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $full_name, $email, $password, $age,
            $permanent_address['line1'], $permanent_address['line2'], $permanent_address['city'],
            $permanent_address['state'], $current_address['line1'], $current_address['line2'], $current_address['city'], $current_address['state'], $profile_picture_path
        ]);

        $user_id = $conn->lastInsertId();


        //Insert qualifications
        $stmt = $conn->prepare("INSERT INTO qualifications (user_id, qualification) VALUES (?, ?)");
        foreach($qualifications as $qualification) {
            $stmt->execute([$user_id, htmlspecialchars($qualification)]);
        }


        //Insert experiences
        $stmt = $conn->prepare("INSERT INTO experiences (user_id, experience) VALUES (?, ?)");
        foreach($experiences as $experience) {
            $stmt->execute([$user_id, htmlspecialchars($experience)]);
        }

        $conn->commit();
        header("Location: login.php?signup=success");
    } catch (Exception $e) {
        $conn->rollBack();
        die("Error : ". $e->getMessage());
    }