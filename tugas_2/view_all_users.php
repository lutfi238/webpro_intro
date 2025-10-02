<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

// Ambil semua user
$sql = "SELECT id, username, email, fullname, status, reg_date FROM users ORDER BY reg_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
</head>
<body>
    <h2>All Registered Users</h2>
    
    <p>Total Users: <?php echo $result->num_rows; ?></p>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Registered</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['reg_date'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
    
    <hr>
    <p><a href="main.php">Back to Home</a></p>
</body>
</html>
<?php
$conn->close();
?>
