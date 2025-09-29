<?php
// File test untuk debugging
include 'connect.php';

echo "<h2>Test Database Connection</h2>";

// Test koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Database connected successfully<br><br>";
}

// Cek apakah tabel users ada
$sql = "SHOW TABLES LIKE 'users'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "✅ Table 'users' exists<br><br>";
    
    // Tampilkan struktur tabel
    echo "<h3>Table Structure:</h3>";
    $sql = "DESCRIBE users";
    $result = $conn->query($sql);
    
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
    // Tampilkan data users
    echo "<h3>Users Data:</h3>";
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Fullname</th><th>Reg Date</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['fullname'] . "</td>";
            echo "<td>" . $row['reg_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ No users found in table<br>";
    }
    
} else {
    echo "❌ Table 'users' does not exist<br>";
    echo "Please run <a href='setup.php'>setup.php</a> first<br>";
}

$conn->close();
?>

<br><br>
<a href="main.php">← Back to Main Menu</a>
<a href="register.php">Add Test User</a>