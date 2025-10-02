<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (strlen($new_password) < 6) {
        $error = "New password must be at least 6 characters!";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match!";
    } else {
        // Ambil password saat ini dari database
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // Verifikasi password lama
        if (password_verify($current_password, $user['password'])) {
            // Hash password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update password
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($update_stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $error = "Password change failed: " . $conn->error;
            }
            $update_stmt->close();
        } else {
            $error = "Current password is incorrect!";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Current Password:</label><br>
            <input type="password" name="current_password" required>
        </p>
        
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
            <button type="submit">Change Password</button>
        </p>
    </form>
    
    <hr>
    <p><a href="profile.php">Back to Profile</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
