<?php include("../../includes/header.php") ?>
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/style/auth.css">
<body>
    <div class="login-container">
        <h2>Employee Management System</h2>
        <form action="login_handler.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Login</button>
            <p style="text-shadow: 2px;">New Employee? <a href="signup.php">Signup</a></p>
        </form>
    </div>
</body>
</html>


<?php include("../../includes/footer.php") ?>