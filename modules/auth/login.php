<title>Login</title>
<link rel="stylesheet" href="../../assets/style/login.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Employee Management System</h2>
            <form action="login_handler.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role" id="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>
                
                <button type="submit" class="submit-button">Login</button>
                
                <p>New Employee? <a href="signup.php">Signup</a></p>
            </form>
        </div>
    </div>
</body>
</html>

<?php include("../../includes/footer.php"); ?>