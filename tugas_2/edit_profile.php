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

// Ambil data user saat ini
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, fullname FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $fullname = trim($_POST['fullname']);
    
    // Validasi
    if (empty($email) || empty($fullname)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Cek apakah email sudah digunakan user lain
        $check_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $email, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error = "Email already used by another user!";
        } else {
            // Update profile
            $update_sql = "UPDATE users SET email = ?, fullname = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssi", $email, $fullname, $user_id);
            
            if ($update_stmt->execute()) {
                $message = "Profile updated successfully!";
                $_SESSION['email'] = $email;
                $_SESSION['fullname'] = $fullname;
                // Refresh data
                $user['email'] = $email;
                $user['fullname'] = $fullname;
            } else {
                $error = "Update failed: " . $conn->error;
            }
            $update_stmt->close();
        }
        $check_stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Username:</label><br>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            <small>Username cannot be changed</small>
        </p>
        
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </p>
        
        <p>
            <label>Full Name:</label><br>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
        </p>
        
        <p>
            <button type="submit">Update Profile</button>
        </p>
    </form>
    
    <hr>
    <p><a href="profile.php">Back to Profile</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
