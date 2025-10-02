<?php
session_start();
include 'connect.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $fullname = trim($_POST['fullname']);
    
    // Validasi
    if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
        $error = "All fields are required!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Cek username atau email sudah ada
        $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username or email already exists!";
        } else {
            // Hash password dan buat activation token
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $activation_token = bin2hex(random_bytes(32));
            
            // Insert user
            $sql = "INSERT INTO users (username, email, password, fullname, activation_token) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $fullname, $activation_token);
            
            if ($stmt->execute()) {
                $message = "Registration successful! Please activate your account.";
                // Dalam produksi, kirim email dengan link aktivasi
                $activation_link = "http://localhost/webpro_intro/tugas_2/activate.php?token=" . $activation_token;
                $message .= "<br><br>Activation link (for testing): <a href='$activation_link'>Click here to activate</a>";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register New Account</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Username:</label><br>
            <input type="text" name="username" required>
        </p>
        
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </p>
        
        <p>
            <label>Full Name:</label><br>
            <input type="text" name="fullname" required>
        </p>
        
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
            <small>Minimum 6 characters</small>
        </p>
        
        <p>
            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required>
        </p>
        
        <p>
            <button type="submit">Register</button>
        </p>
    </form>
    
    <hr>
    <p><a href="main.php">Back to Home</a></p>
    <p><a href="login.php">Already have an account? Login</a></p>
</body>
</html>
