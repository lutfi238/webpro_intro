<?php
include 'connect.php';

$usr = $_POST['usr'];

// First, check if the account exists
$sql_check = "SELECT * FROM users WHERE username='$usr'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] == 'active') {
        echo "Account is already activated. <a href='index.php'>Back</a>";
    } else {
        // Activate the account
        $sql = "UPDATE users SET status='active' WHERE username='$usr'";
        if ($conn->query($sql) === TRUE) {
            echo "Account activated successfully. <a href='login.html'>Login Now</a> | <a href='index.php'>Home</a>";
        } else {
            echo "Error activating account: " . $conn->error . " <a href='index.php'>Back</a>";
        }
    }
} else {
    echo "Account not found. <a href='index.php'>Back</a>";
}

$conn->close();
?>