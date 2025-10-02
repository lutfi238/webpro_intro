<?php
include 'connect.php';

// Drop table jika sudah ada (untuk testing)
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("DROP TABLE IF EXISTS password_resets");

// SQL untuk membuat tabel users dengan fitur lengkap
$sql_users = "CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'inactive',
    activation_token VARCHAR(100),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)";

// SQL untuk membuat tabel password_resets
$sql_resets = "CREATE TABLE password_resets (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)";

// Eksekusi query
if ($conn->query($sql_users) === TRUE) {
    echo "Table 'users' created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

if ($conn->query($sql_resets) === TRUE) {
    echo "Table 'password_resets' created successfully<br>";
} else {
    echo "Error creating password_resets table: " . $conn->error . "<br>";
}

echo "<br><a href='main.php'>Go to Main Page</a>";

$conn->close();
?>
