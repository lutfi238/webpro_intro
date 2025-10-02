<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

// Ambil data user
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, username, email, fullname, status, reg_date FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>
    <h2>My Profile</h2>
    
    <?php if ($user): ?>
        <p>ID: <?php echo $user['id']; ?></p>
        <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Full Name: <?php echo htmlspecialchars($user['fullname']); ?></p>
        <p>Status: <?php echo $user['status']; ?></p>
        <p>Registered: <?php echo date('d/m/Y H:i', strtotime($user['reg_date'])); ?></p>
    <?php else: ?>
        <p>User not found!</p>
    <?php endif; ?>
    
    <hr>
    <p><a href="edit_profile.php">Edit Profile</a></p>
    <p><a href="change_password.php">Change Password</a></p>
    <p><a href="delete_account.php">Delete Account</a></p>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
