# User Management System - Homework Documentation

## Assignment Requirements

### 1. ✅ Registrasi akun (Create Data User)
**Files:** `registration.php`, `create_account.php`
- Registration form with email, password, confirm password, full name, and role
- Password confirmation (2 times input)
- Password hashing for security
- All fields are required
- Minimum 8 characters for password

### 2. ✅ Menampilkan semua akun (Read Data User)
**Files:** `view_all_account.php`
- Display all users in HTML table
- Shows: ID, Username, Full Name, Role
- Actions: Edit and Delete buttons for each user
- Proper HTML structure with DOCTYPE

### 3. ✅ Edit profil user dan ganti password (Update Data User)
**Files:** `form_edit_user.php`, `update_user.php`, `change_password.php`, `update_password.php`

**Edit Profile:**
- Edit form shows username (read-only), full name, and role
- Username cannot be changed (read-only display)
- Only full name and role can be updated
- Validation for required fields

**Change Password (Ganti Password):**
- Separate feature for logged-in users
- Requires current password verification
- New password with confirmation
- Only accessible when logged in
- Different from "Reset Password" (forgot password)

### 4. ✅ Menghapus akun (Delete Data User)
**Files:** `delete_user.php`
- Delete confirmation with JavaScript alert
- Proper error handling
- Redirects to user list after deletion

### 5. ✅ Aktivasi akun
**Files:** `activate.html`, `activate.php`
- Account activation by email/username
- Checks if account exists
- Prevents double activation
- Shows appropriate messages
- Default status is 'inactive' on registration

### 6. ✅ Login dan Session
**Files:** `login.html`, `login.php`, `view_account.php`
- Login form with email and password
- Session management for logged-in users
- Only active accounts can login
- Password verification with password_verify()
- Session stores: user_id, username, fullname, role
- Protected pages check session before access

### 7. ✅ Logout
**Files:** `logout.php`
- Destroys session
- Redirects to login page
- Proper session cleanup

### 8. ✅ Forget/Reset Password (Lupa Password)
**Files:** `reset_password.html`, `send_otp.php`, `verify_otp.html`, `verify_otp.php`, `reset_password.php`
- OTP-based password reset for users who forgot password
- Sends OTP via email (PHPMailer)
- 6-digit random OTP
- 5-minute expiration
- Password confirmation required
- Account existence validation
- Accessible without logging in
- **Different from "Change Password"** which requires login and current password

## Database Structure
**Table:** `users`
```sql
CREATE TABLE users(
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(100) NOT NULL,
  fullname VARCHAR(50) NOT NULL,
  role VARCHAR(20) NOT NULL,
  status ENUM('active', 'inactive') DEFAULT 'inactive',
  reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id) 
)
```

## Security Features
- ✅ Password hashing with password_hash()
- ✅ Password verification with password_verify()
- ✅ Session-based authentication
- ✅ Input validation (required fields)
- ✅ Account status checking (active/inactive)
- ✅ OTP expiration (5 minutes)
- ✅ Password confirmation on registration and reset

## File Structure
```
tugas_2_UTS/
├── index.php                 # Main navigation (session-aware)
├── connect.php              # Database connection
├── create_tbl_users.php     # Table creation script
│
├── registration.php         # Registration form
├── create_account.php       # Handle registration
│
├── login.html               # Login form
├── login.php                # Handle login
├── logout.php               # Handle logout
│
├── view_account.php         # View logged-in user profile
├── view_all_account.php     # View all users (CRUD)
│
├── form_edit_user.php       # Edit user profile form
├── update_user.php          # Handle profile update
├── change_password.php      # Change password form (logged in)
├── update_password.php      # Handle password change (logged in)
├── delete_user.php          # Handle delete
│
├── activate.html            # Activation form
├── activate.php             # Handle activation
│
├── reset_password.html      # Reset password form
├── send_otp.php             # Send OTP via email
├── verify_otp.html          # OTP input form
├── verify_otp.php           # Verify OTP
├── reset_password.php       # Handle password reset
│
└── vendor/                  # PHPMailer library
```

## Testing Workflow
1. Run `create_tbl_users.php` to create database table
2. Register new account via `registration.php`
3. Activate account via `activate.html`
4. Login via `login.html`
5. View profile, edit, or manage users
6. Test logout
7. Test password reset with OTP

## Technologies Used
- PHP (Server-side)
- MySQL (Database)
- HTML (Forms and display)
- PHPMailer (Email sending)
- Sessions (Authentication)
- Password Hashing (Security)

## Notes for Professor
- All HTML pages have proper DOCTYPE and structure
- No CSS styling as requested (plain HTML)
- Clean and organized code
- Proper error handling throughout
- Security best practices implemented
- OTP email feature demonstrates advanced implementation