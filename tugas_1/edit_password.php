<?php
include 'connect.php';

$user_data = null;
$message = "";
$error = "";

// Jika ada ID di URL, ambil data user
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];
    
    $sql = "SELECT id, username, fullname FROM users WHERE id = ?";
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

// Proses update password
if ($_POST && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Semua field password harus diisi!";
    } elseif (strlen($new_password) < 6) {
        $error = "Password baru minimal 6 karakter!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Password baru dan konfirmasi tidak sama!";
    } else {
        // Verifikasi password lama
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];
            
            // Verifikasi password lama
            if (password_verify($current_password, $stored_password)) {
                // Hash password baru
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update password
                $update_sql = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $hashed_new_password, $user_id);
                
                if ($update_stmt->execute()) {
                    $message = "Password berhasil diubah!";
                    // Reset form
                    $_POST = array();
                } else {
                    $error = "Error: " . $update_stmt->error;
                }
                $update_stmt->close();
            } else {
                $error = "Password lama tidak benar!";
            }
        } else {
            $error = "User tidak ditemukan!";
        }
        $stmt->close();
        
        // Refresh user data
        $sql = "SELECT id, username, fullname FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
        }
        $stmt->close();
    }
}

// Form pencarian user
if (isset($_POST['search_user'])) {
    $search_term = trim($_POST['search_term']);
    
    if (!empty($search_term)) {
        if (is_numeric($search_term)) {
            $sql = "SELECT id, username, fullname FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $search_term);
        } else {
            $sql = "SELECT id, username, fullname FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $search_term);
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
    <title>Edit Password</title>
</head>
<body>
        
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        
        <?php if (!$user_data): ?>
            <h3>Search User</h3>
            <p>Enter ID or username to find the user whose password will be changed:</p>
            <form method="post">
                <input type="text" name="search_term" placeholder="ID atau Username..." 
                       value="<?php echo isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : ''; ?>" required>
                <button type="submit" name="search_user">Search User</button>
            </form>
        <?php else: ?>
            <p><strong>User yang akan diubah passwordnya:</strong></p>
            <p>ID: <?php echo $user_data['id']; ?></p>
            <p>Username: <?php echo htmlspecialchars($user_data['username']); ?></p>
            <p>Nama: <?php echo htmlspecialchars($user_data['fullname']); ?></p>
            
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>">
                
                <p>
                    <label for="current_password">Password Lama:</label><br>
                    <input type="password" id="current_password" name="current_password" required>
                    <small>Masukkan password yang sedang digunakan</small>
                </p>
                
                <p>
                    <label for="new_password">Password Baru:</label><br>
                    <input type="password" id="new_password" name="new_password" required>
                    <small>Minimal 6 karakter</small>
                </p>
                
                <p>
                    <label for="confirm_password">Konfirmasi Password Baru:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <small>Harus sama dengan password baru di atas</small>
                </p>
                
                <button type="submit">Ubah Password</button>
            </form>
            
            <p><a href="?">Pilih User Lain</a></p>
        <?php endif; ?>
        
        <hr>
        <p><a href="main.php">Menu Utama</a></p>
        <p><a href="view_users.php">Lihat Semua User</a></p>
</body>
</html>

<?php
$conn->close();
?>