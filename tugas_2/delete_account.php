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
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    // Validasi
    if (empty($password)) {
        $error = "Please enter your password!";
    } elseif ($confirm !== 'DELETE') {
        $error = "Please type DELETE to confirm!";
    } else {
        // Verifikasi password
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Hapus akun
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $user_id);
            
            if ($delete_stmt->execute()) {
                // Hapus session dan redirect
                session_unset();
                session_destroy();
                header("Location: main.php?deleted=1");
                exit();
            } else {
                $error = "Delete failed: " . $conn->error;
            }
            $delete_stmt->close();
        } else {
            $error = "Incorrect password!";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
</head>
<body>
    <h2>Delete Account</h2>
    
    <p><strong>WARNING!</strong></p>
    <p>This action cannot be undone. All your data will be permanently deleted.</p>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Enter Your Password:</label><br>
            <input type="password" name="password" required>
        </p>
        
        <p>
            <label>Type DELETE to confirm:</label><br>
            <input type="text" name="confirm" placeholder="Type: DELETE" required>
        </p>
        
        <p>
            <button type="submit" onclick="return confirm('Are you absolutely sure you want to delete your account?')">Delete My Account Forever</button>
        </p>
    </form>
    
    <hr>
    <p><a href="profile.php">Back to Profile</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
