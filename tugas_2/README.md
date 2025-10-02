# User Management System - Tugas 2

Sistem manajemen user lengkap dengan fitur-fitur:

## Fitur-fitur:

### 1. **Registrasi Akun** (CREATE)
- File: `register.php`
- Mendaftarkan user baru dengan username, email, password, dan fullname
- Password di-hash menggunakan `password_hash()`
- Generate activation token
- Status awal: inactive

### 2. **Aktivasi Akun**
- File: `activate.php`
- Aktivasi akun melalui token
- Mengubah status dari inactive menjadi active
- User harus aktivasi sebelum bisa login

### 3. **Login & Session**
- File: `login.php`
- Login menggunakan username atau email
- Verifikasi password dengan `password_verify()`
- Cek status aktivasi
- Set session untuk user yang berhasil login

### 4. **Logout**
- File: `logout.php`
- Menghapus semua session
- Redirect ke halaman utama

### 5. **Lihat Semua User** (READ)
- File: `view_all_users.php`
- Menampilkan daftar semua user yang terdaftar
- Hanya bisa diakses oleh user yang sudah login

### 6. **Lihat Profile** (READ)
- File: `profile.php`
- Menampilkan informasi user yang sedang login
- Akses ke menu edit profile, change password, dan delete account

### 7. **Edit Profile** (UPDATE)
- File: `edit_profile.php`
- Mengubah email dan fullname
- Username tidak bisa diubah
- Validasi email unik

### 8. **Ganti Password** (UPDATE)
- File: `change_password.php`
- Mengubah password user
- Verifikasi password lama
- Password baru minimal 6 karakter

### 9. **Hapus Akun** (DELETE)
- File: `delete_account.php`
- Menghapus akun user secara permanen
- Memerlukan verifikasi password
- Konfirmasi dengan mengetik "DELETE"
- Session otomatis dihapus setelah delete

### 10. **Forgot Password**
- File: `forgot_password.php`
- Request reset password via email
- Generate reset token
- Token disimpan di tabel `password_resets`

### 11. **Reset Password**
- File: `reset_password.php`
- Reset password menggunakan token
- Token berlaku 1 jam
- Token dihapus setelah digunakan

## Database Structure:

### Tabel: `users`
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- username (VARCHAR 50, UNIQUE, NOT NULL)
- email (VARCHAR 100, UNIQUE, NOT NULL)
- password (VARCHAR 255, NOT NULL)
- fullname (VARCHAR 100, NOT NULL)
- role (VARCHAR 20, DEFAULT 'user')
- status (ENUM 'active'/'inactive', DEFAULT 'inactive')
- activation_token (VARCHAR 100)
- reg_date (TIMESTAMP)
- modified (TIMESTAMP)
```

### Tabel: `password_resets`
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- email (VARCHAR 100, NOT NULL)
- token (VARCHAR 100, NOT NULL)
- created_at (TIMESTAMP)
```

## Setup Instructions:

1. **Setup Database:**
   - Akses `setup.php` untuk membuat tabel
   - Script akan create tabel `users` dan `password_resets`

2. **Register Account:**
   - Buka `register.php`
   - Isi form registrasi
   - Klik link aktivasi yang muncul

3. **Activate Account:**
   - Klik link aktivasi dari halaman registrasi
   - Akun akan diaktifkan

4. **Login:**
   - Buka `login.php`
   - Login dengan username/email dan password
   - Hanya akun aktif yang bisa login

5. **Use Features:**
   - Setelah login, akses semua fitur dari menu di `main.php`

## Security Features:

- ✅ Password hashing dengan `password_hash()`
- ✅ Prepared statements untuk prevent SQL injection
- ✅ Session management untuk autentikasi
- ✅ Email validation
- ✅ Password minimum 6 karakter
- ✅ Activation token untuk verifikasi akun
- ✅ Reset token dengan expiry time (1 jam)
- ✅ Konfirmasi delete account dengan password

## File Structure:

```
tugas_2/
├── connect.php           # Database connection
├── setup.php            # Database setup
├── main.php             # Main page with menu
├── register.php         # User registration
├── activate.php         # Account activation
├── login.php            # User login
├── logout.php           # User logout
├── profile.php          # View profile
├── view_all_users.php   # View all users
├── edit_profile.php     # Edit profile
├── change_password.php  # Change password
├── delete_account.php   # Delete account
├── forgot_password.php  # Request password reset
├── reset_password.php   # Reset password with token
└── README.md           # This file
```

## Notes:

- Sistem menggunakan database "my5edb"
- Semua file menggunakan HTML sederhana tanpa CSS
- Testing di localhost: `http://localhost/webpro_intro/tugas_2/`
- Activation dan reset links ditampilkan di halaman untuk testing (dalam produksi harus dikirim via email)

## CRUD Operations Summary:

| Operation | File | Description |
|-----------|------|-------------|
| CREATE | register.php | Registrasi user baru |
| READ | view_all_users.php | Lihat semua user |
| READ | profile.php | Lihat profile sendiri |
| UPDATE | edit_profile.php | Update email dan fullname |
| UPDATE | change_password.php | Update password |
| DELETE | delete_account.php | Hapus akun |

## Additional Features:

- ✅ Account activation system
- ✅ Login with session management
- ✅ Logout functionality
- ✅ Forgot password with token
- ✅ Reset password with expiry
- ✅ User status (active/inactive)
- ✅ Password verification before critical actions
