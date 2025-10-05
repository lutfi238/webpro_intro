<?php
session_start();
include 'connect.php';

$usr = $_POST['usr'];
$psw = $_POST['psw'];

$sql = "SELECT * FROM users WHERE username = '$usr' AND status = 'active'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($psw, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];
        header('Location: index.php');
    } else {
        echo "Invalid password. <a href='index.php'>Back</a>";
    }
} else {
    echo "User not found or account not activated. <a href='index.php'>Back</a>";
}

$conn->close();
?>