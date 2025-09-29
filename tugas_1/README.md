# User Management System - CRUD PHP & MySQL

Sistem manajemen user sederhana dengan fitur CRUD (Create, Read, Update, Delete) menggunakan PHP dan MySQL.

## 🔥 Fitur Utama

### 1. **CREATE - Registrasi User**
- Form registrasi dengan validasi lengkap
- Username harus unik dalam sistem
- Password minimal 6 karakter
- Konfirmasi password untuk menghindari kesalahan
- Enkripsi password menggunakan `password_hash()`

### 2. **READ - Tampilkan Data User**
- **Lihat Semua User**: Tabel lengkap dengan informasi semua user
- **Cari User**: Pencarian berdasarkan ID atau username
- Password tidak ditampilkan (keamanan data)
- Informasi waktu registrasi

### 3. **UPDATE - Ubah Password**
- Prioritas untuk mengubah password user
- Verifikasi password lama sebelum update
- Validasi password baru
- Enkripsi password baru

### 4. **DELETE - Hapus User**
- Konfirmasi ganda sebelum penghapusan
- User harus mengetik username untuk konfirmasi
- Peringatan bahwa data tidak dapat dikembalikan
- Penghapusan permanen dari database

## 📋 Struktur Database

```sql
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 📁 Struktur File

```
tugas_1/
├── index.php              # Halaman utama dengan menu navigasi
├── setup.php              # Script setup database dan tabel
├── connect.php            # Koneksi database
├── register.php           # Form registrasi user baru (CREATE)
├── view_users.php         # Tampilkan semua user (READ ALL)
├── search_user.php        # Cari user tertentu (READ ONE)
├── edit_password.php      # Ubah password user (UPDATE)
├── delete_user.php        # Hapus user (DELETE)
├── create_users_table.sql # SQL script untuk membuat tabel
└── README.md              # Dokumentasi ini
```

## 🚀 Cara Instalasi

### 1. Persiapan Environment
- **XAMPP/WAMPP/LAMPP** sudah terinstall
- **Apache** dan **MySQL** berjalan
- **PHP** versi 7.0 atau lebih tinggi

### 2. Setup Project
1. Copy folder `tugas_1` ke dalam `htdocs` (XAMPP) atau `www` (WAMPP)
2. Buka browser dan akses: `http://localhost/webpro_intro/tugas_1/`
3. Jalankan setup database: `http://localhost/webpro_intro/tugas_1/setup.php`

### 3. Konfigurasi Database
Database yang digunakan adalah `my5edb` (sesuai konfigurasi existing):
```php
$servername = "localhost";
$username = "root";  
$password = "";
$dbname = "my5edb";  // Database yang sudah ada
```

**Opsi Setup:**
- **Opsi 1**: Jalankan `setup.php` melalui browser
- **Opsi 2**: Import `create_users_table.sql` ke phpMyAdmin
- **Opsi 3**: Jalankan SQL manual di phpMyAdmin

## 🔧 Penggunaan

### 1. Setup Awal
- Akses `setup.php` untuk membuat database dan tabel
- Pastikan tidak ada error saat setup

### 2. Registrasi User
- Pilih "Registrasi User" dari menu utama
- Isi form dengan data yang valid
- Username harus unik, password minimal 6 karakter

### 3. Lihat Data User
- "Lihat Semua User" untuk melihat tabel lengkap
- "Cari User" untuk mencari berdasarkan ID/username

### 4. Ubah Password
- Pilih user dari daftar atau cari manual
- Masukkan password lama untuk verifikasi
- Masukkan password baru (minimal 6 karakter)

### 5. Hapus User
- Pilih user yang ingin dihapus
- Konfirmasi dengan mengetik username
- Data akan dihapus permanen

## 🔒 Fitur Keamanan

### 1. Enkripsi Password
```php
// Saat registrasi
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Saat verifikasi
if (password_verify($input_password, $stored_password)) {
    // Password benar
}
```

### 2. Prepared Statements
- Mencegah SQL Injection
- Semua query menggunakan prepared statements

### 3. Input Validation
- Validasi di sisi client dan server
- Sanitasi input menggunakan `htmlspecialchars()`

### 4. Konfirmasi Penghapusan
- Double confirmation untuk delete
- User harus mengetik username untuk konfirmasi

## 🎨 Fitur UI/UX

### 1. Design Responsif
- Mobile-friendly design
- Grid layout yang fleksibel
- Hover effects dan transitions

### 2. User Experience
- Pesan feedback untuk setiap aksi
- Loading states dan confirmations
- Error handling yang user-friendly

### 3. Color Coding
- 🔴 Merah: Aksi berbahaya (delete)
- 🟡 Kuning: Aksi edit/update
- 🔵 Biru: Aksi navigasi
- 🟢 Hijau: Aksi create/success

## 📝 Validasi Form

### Registrasi User
- ✅ Username minimal 3 karakter, harus unik
- ✅ Password minimal 6 karakter
- ✅ Konfirmasi password harus sama
- ✅ Fullname tidak boleh kosong

### Update Password
- ✅ Password lama harus benar
- ✅ Password baru minimal 6 karakter
- ✅ Konfirmasi password baru harus sama

### Delete User
- ✅ Username confirmation untuk keamanan
- ✅ Double confirmation dengan JavaScript

## 🚨 Error Handling

### Database Errors
- Connection error handling
- Query error reporting
- Transaction rollback jika diperlukan

### User Input Errors
- Field validation
- Type checking
- Length validation

### Security Errors
- Unauthorized access prevention
- Input sanitization
- SQL injection prevention

## 📊 Testing Checklist

### ✅ CREATE (Registrasi)
- [ ] Registrasi dengan data valid
- [ ] Validasi username unik
- [ ] Validasi password minimal 6 karakter
- [ ] Konfirmasi password sama
- [ ] Error handling untuk input kosong

### ✅ READ (Tampil Data)
- [ ] Tampilkan semua user
- [ ] Pencarian berdasarkan ID
- [ ] Pencarian berdasarkan username
- [ ] Password tidak ditampilkan
- [ ] Format tanggal yang benar

### ✅ UPDATE (Ubah Password)
- [ ] Verifikasi password lama
- [ ] Update password baru
- [ ] Enkripsi password baru
- [ ] Error untuk password salah

### ✅ DELETE (Hapus User)
- [ ] Konfirmasi username
- [ ] Penghapusan data dari database
- [ ] Pesan konfirmasi berhasil
- [ ] Error handling jika user tidak ada

## 🌟 Bonus Features

### 1. Search & Filter
- Pencarian real-time
- Filter berdasarkan tanggal registrasi
- Sorting data dalam tabel

### 2. User Statistics
- Total user terdaftar
- User terbaru
- Grafik registrasi (jika diperlukan)

### 3. Export Data
- Export ke CSV/Excel
- Print-friendly layout
- Backup data user

## 🔄 Future Improvements

1. **Authentication System**: Login/logout functionality
2. **Role Management**: Admin dan user roles
3. **Profile Management**: Edit nama lengkap, email, dll
4. **Password Recovery**: Reset password via email
5. **Activity Logs**: Tracking user activities
6. **API Endpoints**: RESTful API untuk mobile app

## 📞 Support

Jika ada pertanyaan atau issues:
1. Check dokumentasi ini terlebih dahulu
2. Test di environment lokal XAMPP
3. Pastikan MySQL service berjalan
4. Check error logs di browser console

## 📄 License

Free to use for educational purposes.

---

**Dibuat dengan ❤️ menggunakan PHP & MySQL**