<?php
session_start();
include 'connect.php';

$error = "";

// Jika sudah login, redirect ke main
if (isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Username and password are required!";
    } else {
        // Cari user
        $sql = "SELECT id, username, email, password, fullname, status FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Cek status aktivasi
                if ($user['status'] == 'inactive') {
                    $error = "Your account is not activated yet! Please check your email for activation link.";
                } else {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['status'] = $user['status'];
                    
                    header("Location: main.php");
                    exit();
                }
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Username or Email:</label><br>
            <input type="text" name="username" required>
        </p>
        
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </p>
        
        <p>
            <button type="submit">Login</button>
        </p>
    </form>
    
    <hr>
    <p><a href="forgot_password.php">Forgot Password?</a></p>
    <p><a href="register.php">Don't have an account? Register</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
