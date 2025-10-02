<?php
session_start();
include 'connect.php';

$message = "";
$error = "";
$valid_token = false;
$email = "";

// Verifikasi token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Cek token (valid dalam 1 jam)
    $sql = "SELECT email, created_at FROM password_resets WHERE token = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $valid_token = true;
        $reset = $result->fetch_assoc();
        $email = $reset['email'];
    } else {
        $error = "Invalid or expired reset token!";
    }
    $stmt->close();
} else {
    $error = "No reset token provided!";
}

// Proses reset password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $valid_token) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password
        $update_sql = "UPDATE users SET password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_password, $email);
        
        if ($update_stmt->execute()) {
            // Hapus token yang sudah digunakan
            $delete_sql = "DELETE FROM password_resets WHERE token = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("s", $token);
            $delete_stmt->execute();
            $delete_stmt->close();
            
            $message = "Password has been reset successfully! You can now login with your new password.";
            $valid_token = false; // Hide form
        } else {
            $error = "Password reset failed: " . $conn->error;
        }
        $update_stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
        <p><a href="login.php">Click here to login</a></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if ($valid_token): ?>
        <p>Enter your new password below:</p>
        
        <form method="POST">
            <p>
                <label>New Password:</label><br>
                <input type="password" name="new_password" required>
                <small>Minimum 6 characters</small>
            </p>
            
            <p>
                <label>Confirm New Password:</label><br>
                <input type="password" name="confirm_password" required>
            </p>
            
            <p>
                <button type="submit">Reset Password</button>
            </p>
        </form>
    <?php endif; ?>
    
    <hr>
    <p><a href="login.php">Back to Login</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
