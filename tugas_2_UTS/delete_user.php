<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Check if user has admin privileges
if ($_SESSION['role'] !== 'admin') {
    echo "Access denied. Only administrators can delete users.<br>";
    echo "<a href='view_all_account.php'>Back to user list</a>";
    exit();
}

// create connection
include 'connect.php';

// Validate and sanitize the ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid user ID.<br>";
    echo "<a href='view_all_account.php'>Back to user list</a>";
    exit();
}

$user_id = intval($_GET['id']);

// Prevent self-deletion
if ($user_id == $_SESSION['user_id']) {
    echo "You cannot delete your own account.<br>";
    echo "<a href='view_all_account.php'>Back to user list</a>";
    exit();
}

// Use prepared statement to prevent SQL injection
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

//check data if delete successfully
if ($stmt->execute()) {
    echo "Selected record deleted successfully";
    //redirect to view_all_account.php
    header('Location: view_all_account.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br><a href='index.php'>Back</a>";
}

// Close connection
$stmt->close();
$conn->close();
?>