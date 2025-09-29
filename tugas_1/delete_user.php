<?php
include 'connect.php';

$user_data = null;
$message = "";
$error = "";
$deleted = false;

// Jika ada ID di URL, ambil data user
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];
    
    $sql = "SELECT id, username, fullname, reg_date FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        $error = "User dengan ID $user_id tidak ditemukan.";
    }
    $stmt->close();
}

// Proses konfirmasi delete
if ($_POST && isset($_POST['confirm_delete']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $entered_username = trim($_POST['username_confirmation']);
    
    // Ambil data user untuk verifikasi
    $sql = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $actual_username = $row['username'];
        
        // Verifikasi username
        if ($entered_username === $actual_username) {
            // Hapus user
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $user_id);
            
            if ($delete_stmt->execute()) {
                $message = "User '$actual_username' berhasil dihapus dari sistem!";
                $deleted = true;
                $user_data = null; // Clear user data
            } else {
                $error = "Error: " . $delete_stmt->error;
            }
            $delete_stmt->close();
        } else {
            $error = "Username yang dimasukkan tidak sesuai! Penghapusan dibatalkan.";
        }
    } else {
        $error = "User tidak ditemukan!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
</head>
<body>
    <h2>Delete User</h2>
        h2 { 
            text-align: center; 
            border-bottom: 2px solid black; 
            padding-bottom: 10px; 
        }
        .user-info { 
            background: white; 
            border: 2px solid black; 
            padding: 15px; 
            margin-bottom: 15px; 
        }
        .user-details { margin: 5px 0; }
        .label { font-weight: bold; }
        .warning { 
            background: white; 
            border: 2px solid black; 
            padding: 10px; 
            margin-bottom: 15px; 
        }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"] { width: 100%; padding: 8px; }
        .btn-danger { background: red; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; }
        .btn-cancel { background: gray; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; margin-bottom: 10px; }
        .success { background: lightgreen; padding: 10px; text-align: center; margin: 10px 0; }
        .error { background: pink; padding: 10px; margin: 10px 0; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { margin: 5px; padding: 5px 10px; border: 1px solid blue; text-decoration: none; }
        .confirmation-text { font-size: 12px; color: gray; }
        .deleted-success { text-align: center; padding: 20px; }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h2>🗑️ Hapus User</h2>
        
        <?php if ($message): ?>
            <div class="success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($deleted): ?>
            <div class="deleted-success">
                <h3>✅ User Berhasil Dihapus</h3>
                <p>User telah dihapus dari sistem dan tidak dapat dikembalikan.</p>
            </div>
        <?php elseif (!$user_data): ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <h3>❌ User Tidak Ditemukan</h3>
                <p>Silakan pilih user yang ingin dihapus dari <a href="view_users.php">daftar user</a>.</p>
            </div>
        <?php else: ?>
            <!-- Informasi User yang akan dihapus -->
            <div class="user-info">
                <h3>⚠️ User yang akan dihapus:</h3>
                <div class="user-details">
                    <div class="label">ID:</div>
                    <div class="value"><?php echo $user_data['id']; ?></div>
                    
                    <div class="label">Username:</div>
                    <div class="value"><strong><?php echo htmlspecialchars($user_data['username']); ?></strong></div>
                    
                    <div class="label">Nama Lengkap:</div>
                    <div class="value"><?php echo htmlspecialchars($user_data['fullname']); ?></div>
                    
                    <div class="label">Terdaftar:</div>
                    <div class="value"><?php echo date('d/m/Y H:i', strtotime($user_data['reg_date'])); ?></div>
                </div>
            </div>
            
            <div class="warning">
                <strong>⚠️ PERINGATAN!</strong><br>
            <p>Tindakan ini tidak dapat dibatalkan. Semua data user akan dihapus secara permanen dari sistem.</p>
            
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>">
                
                <p>
                    <label for="username_confirmation">Konfirmasi dengan mengetik username:</label><br>
                    <input type="text" id="username_confirmation" name="username_confirmation" 
                           placeholder="Ketik: <?php echo htmlspecialchars($user_data['username']); ?>" required><br>
                    <small>Ketik username "<?php echo htmlspecialchars($user_data['username']); ?>" untuk mengkonfirmasi penghapusan</small>
                </p>
                
                <p>
                    <button type="button" onclick="window.location.href='view_users.php'">Batal</button>
                    <button type="submit" name="confirm_delete" onclick="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')">Hapus User Selamanya</button>
                </p>
            </form>
        <?php endif; ?>
        
        <hr>
        <p><a href="main.php">Menu Utama</a></p>
        <p><a href="view_users.php">Daftar User</a></p>
</body>
</html>

<?php
$conn->close();
?>