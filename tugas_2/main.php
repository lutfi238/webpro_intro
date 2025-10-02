<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management System</title>
</head>
<body>
    <h1>User Management System</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</p>
        <p>Status: <?php echo $_SESSION['status'] == 'active' ? 'Active' : 'Inactive'; ?></p>
        
        <h2>Menu</h2>
        <ul>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="view_all_users.php">View All Users</a></li>
            <li><a href="edit_profile.php">Edit Profile</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    <?php else: ?>
        <h2>Guest Menu</h2>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register New Account</a></li>
            <li><a href="forgot_password.php">Forgot Password?</a></li>
        </ul>
    <?php endif; ?>
    
    <hr>
    <p><a href="setup.php">Setup Database</a></p>
</body>
</html>
