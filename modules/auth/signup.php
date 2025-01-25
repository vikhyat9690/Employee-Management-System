<?php
include('../../includes/header.php');
?>

<title>Signup</title>
<link rel="stylesheet" href="../../assets/style/auth.css">
<div class="main-container">
    <h1> Signup </h1>
    <form id="signupForm" method="POST" action="signup_handler.php" enctype="multipart/form-data">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br>

        <label>Qualifications:</label>
        <div id="qualifications">
            <input type="text" name="qualifications[]" placeholder="Qualification">
            <button type="button" id="addQualification">Add</button>
        </div><br>

        <label>Experiences:</label>
        <div id="experiences">
            <input type="text" name="experiences[]" placeholder="Experience">
            <button type="button" id="addExperience">Add</button>
        </div><br>

        <div class="address">
            <label for="permanent_address">Permanent Address:</label>
            <div class="permanent">
                <input type="text" name="permanent_address_line1" placeholder="Line 1" required>
                <input type="text" name="permanent_address_line2" placeholder="Line 2">
                <input type="text" name="permanent_city" placeholder="City" required>
                <input type="text" name="permanent_state" placeholder="State" required><br>
            </div>

            <label for="permanent_address">Permanent Address:</label>
            <div class="current">
                <input type="text" name="permanent_address_line1" placeholder="Line 1" required>
                <input type="text" name="permanent_address_line2" placeholder="Line 2">
                <input type="text" name="permanent_city" placeholder="City" required>
                <input type="text" name="permanent_state" placeholder="State" required><br>
            </div>
        </div>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required><br>

        <button type="submit">Signup</button>
        <p style="text-align: center;">Already an employee? <a href="login.php">Login</a></p>
    </form>
</div>

<script src="../../assets/js/script.js"></script>

<?php include('../../includes/footer.php'); ?>