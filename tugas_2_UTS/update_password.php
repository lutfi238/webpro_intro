<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'connect.php';

$user_id = $_SESSION['user_id'];
$current_psw = $_POST['current_psw'];
$new_psw = $_POST['new_psw'];
$confirm_psw = $_POST['confirm_psw'];

// Check if new passwords match
if ($new_psw !== $confirm_psw) {
    echo "New passwords do not match. <a href='change_password.php'>Back</a>";
    exit();
}

// Get current password from database
$sql = "SELECT password FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Verify current password
if (!password_verify($current_psw, $row['password'])) {
    echo "Current password is incorrect. <a href='change_password.php'>Back</a>";
    exit();
}

// Update to new password
$hashed_psw = password_hash($new_psw, PASSWORD_DEFAULT);
$sql_update = "UPDATE users SET password='$hashed_psw' WHERE id=$user_id";

if ($conn->query($sql_update) === TRUE) {
    echo "Password changed successfully. <a href='view_account.php'>Back to My Account</a>";
} else {
    echo "Error changing password: " . $conn->error . " <a href='change_password.php'>Back</a>";
}

$conn->close();
?>