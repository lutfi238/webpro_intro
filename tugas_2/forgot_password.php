<?php
session_start();
include 'connect.php';

$message = "";
$error = "";
$step = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        // Step 1: Request reset
        $email = trim($_POST['email']);
        
        if (empty($email)) {
            $error = "Email is required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } else {
            // Cek apakah email terdaftar
            $sql = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                
                // Simpan token ke database
                $insert_sql = "INSERT INTO password_resets (email, token) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ss", $email, $token);
                
                if ($insert_stmt->execute()) {
                    $reset_link = "http://localhost/webpro_intro/tugas_2/reset_password.php?token=" . $token;
                    $message = "Password reset link has been sent!<br><br>Reset link (for testing): <a href='$reset_link'>Click here to reset password</a>";
                } else {
                    $error = "Failed to create reset request: " . $conn->error;
                }
                $insert_stmt->close();
            } else {
                // Untuk keamanan, jangan beritahu kalau email tidak terdaftar
                $message = "If the email exists, a reset link has been sent.";
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if (!$message): ?>
        <p>Enter your email address and we'll send you a link to reset your password.</p>
        
        <form method="POST">
            <p>
                <label>Email:</label><br>
                <input type="email" name="email" required>
            </p>
            
            <p>
                <button type="submit">Send Reset Link</button>
            </p>
        </form>
    <?php endif; ?>
    
    <hr>
    <p><a href="login.php">Back to Login</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
