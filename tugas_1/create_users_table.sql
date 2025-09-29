-- Script SQL untuk membuat tabel users di database my5edb
-- Jalankan script ini di phpMyAdmin atau MySQL console

USE my5edb;

-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menambahkan index untuk performa yang lebih baik
CREATE INDEX idx_username ON users(username);
CREATE INDEX idx_reg_date ON users(reg_date);

-- Contoh data dummy (opsional - hapus jika tidak diperlukan)
-- INSERT INTO users (username, password, fullname) VALUES 
-- ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator'),
-- ('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'User Pertama');

SELECT 'Tabel users berhasil dibuat!' as Status;