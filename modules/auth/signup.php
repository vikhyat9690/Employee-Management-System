
<title>Signup</title>
<link rel="stylesheet" href="../../assets/style/signup.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Signup to Employee Management System</h2>
            <form method="POST" action="signup_handler.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" name="age" placeholder="Enter your age" required>
                </div>

                <div class="form-group">
                    <label>Qualifications:</label>
                    <div class="dynamic-fields">
                        <input type="text" name="qualifications[]" placeholder="Enter a qualification">
                        <button type="button" class="add-button">+</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Experiences:</label>
                    <div class="dynamic-fields">
                        <input type="text" name="experiences[]" placeholder="Enter an experience">
                        <button type="button" class="add-button">+</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Permanent Address:</label>
                    <input type="text" name="permanent_address_line1" placeholder="Line 1" required>
                    <input type="text" name="permanent_address_line2" placeholder="Line 2">
                    <input type="text" name="permanent_city" placeholder="City" required>
                    <input type="text" name="permanent_state" placeholder="State" required>
                </div>

                <div class="form-group">
                    <label>Current Address:</label>
                    <input type="text" name="current_address_line1" placeholder="Line 1" required>
                    <input type="text" name="current_address_line2" placeholder="Line 2">
                    <input type="text" name="current_city" placeholder="City" required>
                    <input type="text" name="current_state" placeholder="State" required>
                </div>

                <div class="form-group">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" accept="image/*" required>
                </div>

                <button type="submit" class="submit-button">Signup</button>
                <p>Already an employee? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
    <?php include_once "../../includes/footer.php"; ?>

    
