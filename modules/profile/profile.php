<?php
include('../../config/db.php'); // Include the MySQLi connection
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php'); // Redirect to login if not authenticated
    exit;
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch qualifications and experiences
$qualifications_query = "SELECT * FROM qualifications WHERE user_id = ?";
$stmt = $conn->prepare($qualifications_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$qualifications = $stmt->get_result();

$experiences_query = "SELECT * FROM experiences WHERE user_id = ?";
$stmt = $conn->prepare($experiences_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$experiences = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../assets/style/profle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <nav>
        <ul>
            <?php if($user['role'] === 'admin' ) {
                echo "<li><a href = '../admin/admin_setting.php'>Admin Settings</a></li>";
            } ?>
            <?php if($user['role'] === 'admin' || $user['role'] === 'manager') {
                echo "<li><a href = '../admin/manager_users.php'>Manage Employee</a></li>";
            } ?>
            <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="profile-container">

        <h1>My Profile</h1>


        <!-- Profile Picture -->
        <div class="section profile-picture">
            <img src="../../<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
            <form id="updatePictureForm" method="POST" action="profile_handler.php" enctype="multipart/form-data">
                <input type="file" name="profile_picture" accept="image/*" required>
                <button type="submit" id="updatePictureBtn" name="update_picture">Update Picture</button>
            </form>
        </div>

        <!-- User Details -->
        <div class="section user-info">
            <h2>Personal Information</h2>
            <p>Full Name: <span id="fullName"><?php echo htmlspecialchars($user['full_name']); ?></span>
                <button class="edit-btn" data-field="full_name">Edit</button>
            </p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?> (Cannot Edit)</p>
            <p>Age: <span id="age"><?php echo htmlspecialchars($user['age']); ?></span>
                <button class="edit-btn" data-field="age">Edit</button>
            </p>
        </div>

        <!-- Address -->
        <div class="section address">
            <h2>Permanent Address</h2>
            <p>
                <?php echo htmlspecialchars($user['permanent_address_line1']); ?><br>
                <?php echo htmlspecialchars($user['permanent_address_line2']); ?><br>
                <?php echo htmlspecialchars($user['permanent_city']); ?>, <?php echo htmlspecialchars($user['permanent_state']); ?>
            </p>
            <button class="edit-btn" data-field="permanent_address">Edit</button>
        </div>

        <!-- Current Address -->
        <div class="section address">
            <h2>Current Address</h2>
            <p>
                <?php echo htmlspecialchars($user['current_address_line1']); ?><br>
                <?php echo htmlspecialchars($user['current_address_line2']); ?><br>
                <?php echo htmlspecialchars($user['current_city']); ?>, <?php echo htmlspecialchars($user['current_state']); ?>
            </p>
            <button class="edit-btn" data-field="current_address">Edit</button>
        </div>

        <!-- Qualifications -->
        <div class="section list-section">
            <h2>Qualifications</h2>
            <ul id="qualificationsList">
                <?php while ($qualification = $qualifications->fetch_assoc()) : ?>
                    <li><?php echo htmlspecialchars($qualification['qualification']); ?>
                        <button class="remove-btn" data-id="<?php echo $qualification['id']; ?>">Remove</button>
                    </li>
                <?php endwhile; ?>
            </ul>
            <input type="text" id="newQualification" placeholder="Add Qualification">
            <button id="addQualificationBtn">Add</button>
        </div>

        <!-- Experiences -->
        <div class="section list-section">
            <h2>Experiences</h2>
            <ul id="experiencesList">
                <?php while ($experience = $experiences->fetch_assoc()) : ?>
                    <li><?php echo htmlspecialchars($experience['experience']); ?>
                        <button class="remove-btn" data-id="<?php echo $experience['id']; ?>">Remove</button>
                    </li>
                <?php endwhile; ?>
            </ul>
            <input type="text" id="newExperience" placeholder="Add Experience">
            <button id="addExperienceBtn">Add</button>
        </div>
        
    </div>
    <script src="../../scripts/profile.js"></script>
    <?php include_once "../../includes/footer.php"; ?>
</body>
</html>
