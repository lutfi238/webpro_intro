<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my5edb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

echo "Connected to database 'my5edb' successfully<br>";

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table 'users' created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .container { max-width: 500px; margin: 0 auto; }
        .success { color: green; }
        .error { color: red; }
        .btn { background: green; color: white; padding: 10px 20px; text-decoration: none; margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Database Setup Complete</h2>
        <p>Tabel 'users' telah berhasil dibuat di database 'my5edb'.</p>
        <a href="main.php" class="btn">Ke Halaman Utama</a>
    </div>
</body>
</html>