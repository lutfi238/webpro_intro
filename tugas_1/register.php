<?php
$message = "";
$error = "";

if ($_POST) {
    include 'connect.php';
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $fullname = trim($_POST['fullname']);
    
    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password) || empty($fullname)) {
        $error = "Semua field harus diisi!";
    } elseif (strlen($username) < 3) {
        $error = "Username minimal 3 karakter!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        // Cek apakah username sudah ada
        $check_sql = "SELECT id FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan! Pilih username lain.";
        } else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $sql = "INSERT INTO users (username, password, fullname) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed_password, $fullname);
            
            if ($stmt->execute()) {
                $message = "Registrasi berhasil! User '$username' telah terdaftar.";
                // Reset form
                $_POST = array();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
    <h2>Register New User</h2>
        
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="post">
            <p>
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                <br><small>Minimum 3 characters, must be unique</small>
            </p>
            
            <p>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
                <br><small>Minimum 6 characters</small>
            </p>
            
            <p>
                <label for="confirm_password">Confirm Password:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <br><small>Must match password above</small>
            </p>
            
            <p>
                <label for="fullname">Full Name:</label><br>
                <input type="text" id="fullname" name="fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
            </p>
            
            <p><button type="submit">Register</button></p>
        </form>
        
        <p><a href="main.php">Back to Main Menu</a></p>
</body>
</html>