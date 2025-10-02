<?php
session_start();
include 'connect.php';

$message = "";
$error = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Cari user dengan token tersebut
    $sql = "SELECT id, username, email FROM users WHERE activation_token = ? AND status = 'inactive'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Aktivasi akun
        $update_sql = "UPDATE users SET status = 'active', activation_token = NULL WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $user['id']);
        
        if ($update_stmt->execute()) {
            $message = "Account activated successfully! You can now login.";
        } else {
            $error = "Activation failed: " . $conn->error;
        }
        $update_stmt->close();
    } else {
        $error = "Invalid or expired activation token!";
    }
    $stmt->close();
} else {
    $error = "No activation token provided!";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activate Account</title>
</head>
<body>
    <h2>Account Activation</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
        <p><a href="login.php">Click here to login</a></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <hr>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
