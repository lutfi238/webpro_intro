<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
</head>
<body>
    <h1>User Management System</h1>
    <ul>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<li><a href='view_account.php'>My Account</a></li>";
    echo "<li><a href='view_all_account.php'>View All Accounts</a></li>";
    echo "<li><a href='logout.php'>Logout</a></li>";
} else {
    echo "<li><a href='registration.php'>Register New Account</a></li>";
    echo "<li><a href='activate.html'>Activate Account</a></li>";
    echo "<li><a href='login.html'>Login</a></li>";
    echo "<li><a href='reset_password.html'>Reset Password</a></li>";
}
?>
    </ul>
</body>
</html></content>
<parameter name="filePath">c:\xampp\htdocs\webpro_intro\tugas_2_UTS\index.php