<?php
// create connection
include 'connect.php';

// get id from URL
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User Account</title>
</head>
<body>
    <h2>Update User Account</h2>
    <a href="index.php">Back</a>
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?= $row['id']?>">
        Username: <?= $row['username']?><br><br>
        Full Name:<br><input type="text" name="fname" value="<?= $row['fullname']?>" required><br>
        Role:<br>

        <?php  
        // check role
        $admin = $operator = $visitor = ""; // initial value
        if ($row['role'] == "admin") {
            $admin = "selected";
        }
        if ($row['role'] == "operator") {
            $operator = "selected";
        }
        if ($row['role'] == "visitor") {
            $visitor = "selected";
        }
        ?>

        <select name="role" required>
            <option value="admin" <?= $admin; ?>>Admin</option>
            <option value="operator" <?= $operator; ?>>Operator</option>
            <option value="visitor" <?= $visitor; ?>>Visitor</option>
        </select>
        <br><br>
        <input type="submit" value="Update User">
    </form>
</body>
</html>

<?php
// Close connection
$conn->close();
?>