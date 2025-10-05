<?php
session_start();

if (!isset($_SESSION['reset_username'])) {
    echo "Session expired. Please start over. <a href='reset_password.html'>Back</a>";
    exit();
}

$usr = $_SESSION['reset_username'];
$new_psw = $_POST['new_psw'];
$confirm_psw = $_POST['confirm_psw'];

if ($new_psw !== $confirm_psw) {
    echo "Passwords do not match. <a href='verify_otp.php'>Back</a>";
    exit();
}

include 'connect.php';

$hashed_psw = password_hash($new_psw, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password='$hashed_psw' WHERE username='$usr'";

if ($conn->query($sql) === TRUE) {
    // Clear session
    unset($_SESSION['reset_otp']);
    unset($_SESSION['reset_username']);
    unset($_SESSION['otp_time']);
    
    echo "Password reset successfully. <a href='login.html'>Login</a>";
} else {
    echo "Error resetting password: " . $conn->error . " <a href='index.php'>Back</a>";
}

$conn->close();
?>