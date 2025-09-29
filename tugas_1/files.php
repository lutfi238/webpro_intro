<!DOCTYPE html>
<html>
<head>
    <title>File List - Tugas 1</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { text-align: center; color: #333; }
        .file-list { list-style: none; padding: 0; }
        .file-list li { 
            margin: 8px 0; 
            padding: 10px; 
            background: #f5f5f5; 
            border-left: 4px solid #007bff; 
        }
        .file-list a { 
            text-decoration: none; 
            color: #007bff; 
            font-weight: bold; 
        }
        .file-list a:hover { 
            text-decoration: underline; 
        }
        .description { 
            font-size: 12px; 
            color: #666; 
            margin-top: 5px; 
        }
        .main-app { 
            background: #e8f5e8; 
            border-left: 4px solid #28a745; 
            margin: 20px 0; 
            padding: 15px; 
            text-align: center; 
        }
        .main-app a { 
            background: #28a745; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 16px; 
        }
        .debug-files { 
            background: #fff3cd; 
            border-left: 4px solid #ffc107; 
            margin: 20px 0; 
            padding: 15px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📂 File List - Tugas 1</h1>
        
        <div class="main-app">
            <h3>🚀 Main Application</h3>
            <a href="main.php">Open User Management System</a>
            <div class="description">Aplikasi utama CRUD User Management</div>
        </div>

        <h3>📋 All Files in Tugas 1:</h3>
        
        <ul class="file-list">
            <li>
                <a href="main.php">📱 main.php</a>
                <div class="description">Halaman utama aplikasi dengan menu navigasi</div>
            </li>
            
            <li>
                <a href="setup.php">⚙️ setup.php</a>
                <div class="description">Script untuk setup database dan membuat tabel users</div>
            </li>
            
            <li>
                <a href="connect.php">🔗 connect.php</a>
                <div class="description">File koneksi database (kode PHP, tidak ada tampilan)</div>
            </li>
            
            <li>
                <a href="register.php">📝 register.php</a>
                <div class="description">Form registrasi user baru (CREATE)</div>
            </li>
            
            <li>
                <a href="view_users.php">👥 view_users.php</a>
                <div class="description">Tampilkan semua user dalam tabel (READ ALL)</div>
            </li>
            
            <li>
                <a href="search_user.php">🔍 search_user.php</a>
                <div class="description">Cari user berdasarkan ID atau username (READ ONE)</div>
            </li>
            
            <li>
                <a href="edit_password.php">🔑 edit_password.php</a>
                <div class="description">Form untuk mengubah password user (UPDATE)</div>
            </li>
            
            <li>
                <a href="delete_user.php">🗑️ delete_user.php</a>
                <div class="description">Form konfirmasi untuk menghapus user (DELETE)</div>
            </li>
            
            <li>
                <a href="create_users_table.sql">📄 create_users_table.sql</a>
                <div class="description">Script SQL untuk membuat tabel users (download file)</div>
            </li>
            
            <li>
                <a href="README.md">📖 README.md</a>
                <div class="description">Dokumentasi lengkap proyek (download file)</div>
            </li>
        </ul>

        <div class="debug-files">
            <h3>🛠️ Debug & Test Files:</h3>
            <ul class="file-list">
                <li>
                    <a href="test_db.php">🧪 test_db.php</a>
                    <div class="description">Test koneksi database dan cek data users</div>
                </li>
                
                <li>
                    <a href="files.php">📂 files.php</a>
                    <div class="description">File ini - daftar semua file di folder tugas_1</div>
                </li>
            </ul>
        </div>

        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 4px;">
            <h3>🎯 Quick Access</h3>
            <a href="setup.php" style="background: orange; color: white; padding: 8px 15px; text-decoration: none; margin: 5px; border-radius: 3px;">1. Setup DB</a>
            <a href="register.php" style="background: green; color: white; padding: 8px 15px; text-decoration: none; margin: 5px; border-radius: 3px;">2. Add User</a>
            <a href="main.php" style="background: blue; color: white; padding: 8px 15px; text-decoration: none; margin: 5px; border-radius: 3px;">3. Main App</a>
        </div>

        <div style="text-align: center; margin-top: 20px; color: #666;">
            <small>
                URL: <strong><?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></strong><br>
                Server Time: <strong><?php echo date('Y-m-d H:i:s'); ?></strong>
            </small>
        </div>
    </div>
</body>
</html>