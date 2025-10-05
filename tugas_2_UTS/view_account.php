<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'connect.php';

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<html>
<head>
    <title>My Account</title>
</head>
<body>
    <h2>Your Account</h2>
    <a href='index.php'>Home</a><br><br>
    <p>Username: <?= $row['username'] ?></p>
    <p>Full Name: <?= $row['fullname'] ?></p>
    <p>Role: <?= $row['role'] ?></p>
    <p>Status: <?= $row['status'] ?></p>
    <a href='form_edit_user.php?id=<?= $id ?>'>Edit Profile</a> | 
    <a href='change_password.php'>Change Password</a><br>
    <a href='logout.php'>Logout</a>
</body>
</html>
<?php

$conn->close();
?>
