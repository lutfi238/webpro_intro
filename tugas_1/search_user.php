<?php
include 'connect.php';

$user_data = null;
$error = "";
$search_performed = false;

if ($_GET && isset($_GET['search'])) {
    $search_term = trim($_GET['search']);
    $search_performed = true;
    
    if (!empty($search_term)) {
        // Cari berdasarkan ID atau username
        if (is_numeric($search_term)) {
            $sql = "SELECT id, username, fullname, reg_date FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $search_term);
        } else {
            $sql = "SELECT id, username, fullname, reg_date FROM users WHERE username LIKE ?";
            $search_param = "%$search_term%";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $search_param);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
        } else {
            $error = "User dengan ID/username '$search_term' tidak ditemukan.";
        }
        $stmt->close();
    } else {
        $error = "Masukkan ID atau username untuk pencarian.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search User</title>
</head>
<body>
    <h2>Search User</h2> 
            border: 2px solid black; 
        }
        .user-card { 
            background: white; 
            border: 2px solid black; 
            padding: 15px; 
            margin: 10px 0; 
        }
        .user-info { margin: 5px 0; }
        .label { font-weight: bold; }
        .error { 
            background: white; 
            border: 2px solid black; 
            padding: 10px; 
            text-align: center; 
            margin: 10px 0; 
        }
        .no-search { 
            text-align: center; 
            padding: 20px; 
            border: 2px solid black; 
            margin: 10px 0; 
        }
        .back-link { 
            text-align: center; 
            margin-top: 20px; 
            border-top: 1px solid black; 
            padding-top: 15px; 
        }
        .back-link a { 
            margin: 5px; 
            padding: 5px 10px; 
            border: 1px solid black; 
            text-decoration: none; 
            color: black; 
        }
        .back-link a:hover { 
            background: black; 
            color: white; 
        }
        .actions { margin-top: 10px; text-align: center; }
        .btn-action { 
            padding: 5px 10px; 
            text-decoration: none; 
            margin: 2px; 
            border: 1px solid black; 
            color: black; 
        }
        .btn-edit { background: white; }
        .btn-delete { background: black; color: white; }
        .btn-action:hover { 
            background: black; 
            color: white; 
        }
        .btn-delete:hover { 
            background: white; 
            color: black; 
        }
        .search-tips { 
            background: white; 
            border: 2px solid black; 
            padding: 10px; 
            margin-bottom: 10px; 
        
        <p><strong>Tips:</strong> Enter ID (number) or username to search for user. Username search uses partial matching.</p>
        
        <form method="get">
            <input type="text" name="search" placeholder="Enter ID or username..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
            <button type="submit">Search</button>
        </form>
        
        <?php if ($search_performed): ?>
            <?php if ($error): ?>
                <p><?php echo $error; ?></p>
            <?php elseif ($user_data): ?>
                <h3>User Found</h3>
                <p>ID: <?php echo $user_data['id']; ?></p>
                <p>Username: <?php echo htmlspecialchars($user_data['username']); ?></p>
                <p>Full Name: <?php echo htmlspecialchars($user_data['fullname']); ?></p>
                <p>Register Date: <?php echo date('d/m/Y H:i:s', strtotime($user_data['reg_date'])); ?></p>
                
                <p>
                    <a href="edit_password.php?id=<?php echo $user_data['id']; ?>">Edit Password</a> | 
                    <a href="delete_user.php?id=<?php echo $user_data['id']; ?>" onclick="return confirm('Are you sure you want to delete user <?php echo htmlspecialchars($user_data['username']); ?>?')">Delete User</a>
                </p>
            <?php endif; ?>
        <?php else: ?>
            <p>Enter ID or username in the form above to search for a specific user.</p>
        <?php endif; ?>
        
        <hr>
        <p><a href="main.php">Main Menu</a></p>
        <p><a href="view_users.php">View All Users</a></p>
</body>
</html>

<?php
$conn->close();
?>