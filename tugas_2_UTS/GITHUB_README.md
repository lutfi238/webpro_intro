# User Management System

A simple PHP-based user management system with CRUD operations, authentication, and email verification.

## Features

- ✅ User Registration with password confirmation
- ✅ Account Activation system
- ✅ Login & Session Management
- ✅ View All Users
- ✅ Edit User Profile
- ✅ Change Password (for logged-in users)
- ✅ Delete User Account
- ✅ Logout
- ✅ Password Reset with OTP via Email

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Composer
- XAMPP or similar local server

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/yourusername/user-management-system.git
cd user-management-system
```

### 2. Install dependencies
```bash
composer install
```

### 3. Configure Database
Copy the example configuration file and edit with your credentials:
```bash
cp connect.php.example connect.php
```

Edit `connect.php`:
```php
$servername = "localhost";
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "my5edb";        // Your database name
```

### 4. Configure Email (for OTP)
Copy the example email configuration:
```bash
cp email_config.php.example email_config.php
```

Edit `email_config.php`:
```php
'smtp_username' => 'your-email@gmail.com',
'smtp_password' => 'your-gmail-app-password',
'from_email' => 'your-email@gmail.com',
```

**For Gmail:**
1. Enable 2FA on your Gmail account
2. Generate App Password: https://support.google.com/accounts/answer/185833
3. Use the App Password in the configuration

### 5. Create Database Table
Run `create_tbl_users.php` once to create the users table:
```
http://localhost/webpro_intro/tugas_2_UTS/create_tbl_users.php
```

### 6. Start Using
Navigate to:
```
http://localhost/webpro_intro/tugas_2_UTS/
```

## Security Notes

⚠️ **NEVER commit these files to GitHub:**
- `connect.php` - Contains database credentials
- `email_config.php` - Contains email credentials
- `vendor/` - Can be reinstalled with composer

✅ **Safe to commit:**
- `connect.php.example` - Template without credentials
- `email_config.php.example` - Template without credentials
- All other PHP files

## Project Structure

```
├── index.php                    # Main navigation
├── connect.php                  # Database config (DO NOT COMMIT)
├── connect.php.example          # Database config template
├── email_config.php             # Email config (DO NOT COMMIT)
├── email_config.php.example     # Email config template
│
├── registration.php             # Registration form
├── create_account.php           # Handle registration
│
├── login.html                   # Login form
├── login.php                    # Handle login
├── logout.php                   # Handle logout
│
├── view_account.php             # View user profile
├── view_all_account.php         # View all users
│
├── form_edit_user.php           # Edit profile form
├── update_user.php              # Handle profile update
│
├── change_password.php          # Change password form
├── update_password.php          # Handle password change
│
├── delete_user.php              # Handle user deletion
│
├── activate.html                # Activation form
├── activate.php                 # Handle activation
│
├── reset_password.html          # Password reset request
├── send_otp.php                 # Send OTP via email
├── verify_otp.html              # OTP verification form
├── verify_otp.php               # Verify OTP
├── reset_password.php           # Reset password
│
└── README.md                    # This file
```

## Usage Workflow

1. **Register** → Create account (status: inactive)
2. **Activate** → Activate via email/username
3. **Login** → Enter credentials
4. **View Profile** → See your account details
5. **Edit Profile** → Update name and role
6. **Change Password** → Change password (requires current password)
7. **View All Users** → See all registered users
8. **Logout** → End session

### Forgot Password?
1. Click "Reset Password"
2. Enter email → Receive OTP
3. Enter OTP code
4. Set new password

## Database Schema

```sql
CREATE TABLE users(
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(100) NOT NULL,
  fullname VARCHAR(50) NOT NULL,
  role VARCHAR(20) NOT NULL,
  status ENUM('active', 'inactive') DEFAULT 'inactive',
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
```

## Technologies

- **Backend:** PHP 7.4+
- **Database:** MySQL/MariaDB
- **Email:** PHPMailer
- **Authentication:** PHP Sessions
- **Security:** Password hashing (bcrypt)

## License

This project is created for educational purposes.

## Author

Created as homework assignment for Web Programming course.
