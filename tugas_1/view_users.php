<?php
include 'connect.php';

// Query untuk mengambil semua user
$sql = "SELECT id, username, fullname, reg_date FROM users ORDER BY reg_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <h2>All Users List</h2>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <p>Total Registered Users: <?php echo $result->num_rows; ?></p>
            
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Register Date</th>
                    <th>Actions</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['reg_date'])); ?></td>
                    <td>
                        <a href="edit_password.php?id=<?php echo $row['id']; ?>">Edit Password</a> | 
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete user <?php echo htmlspecialchars($row['username']); ?>?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No users registered yet</p>
            <p><a href="register.php">Register a new user</a></p>
        <?php endif; ?>
        
        <hr>
        <p><a href="main.php">Back to Main Menu</a></p>
        <p><a href="register.php">Add New User</a></p>
</body>
</html>

<?php
$conn->close();
?>