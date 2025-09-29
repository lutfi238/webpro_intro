# Copilot Instructions - User Management System

## Project Overview
This is a PHP/MySQL CRUD application for user management built for XAMPP environment. It follows a simple file-per-feature architecture with shared database connection.

## Architecture & Key Patterns

### Database Connection Pattern
- All files use `include 'connect.php'` for database access
- Connection uses MySQLi with prepared statements throughout
- Database: `user_management_db`, Table: `users` (id, username, password, fullname, reg_date)

### Security Implementation
- **Password Security**: All passwords use `password_hash(PASSWORD_DEFAULT)` and `password_verify()`
- **SQL Injection Prevention**: Every query uses prepared statements with `bind_param()`
- **Input Sanitization**: Forms use `trim()` and validation before database operations
- **Double Confirmation**: Delete operations require username confirmation matching

### File Structure & Responsibilities
- `index.php`: Main navigation hub with grid-based menu system
- `setup.php`: One-time database/table creation script
- `connect.php`: Shared database connection configuration
- CRUD operations: `register.php` (CREATE), `view_users.php` + `search_user.php` (READ), `edit_password.php` (UPDATE), `delete_user.php` (DELETE)

## Development Workflow

### Initial Setup
1. Ensure XAMPP is running (Apache + MySQL)
2. Access via `http://localhost/tugas_1/`
3. Run `setup.php` first to create database and table structure
4. Database config in `connect.php`: localhost/root/no-password/user_management_db

### Form Processing Pattern
All CRUD files follow this structure:
```php
// 1. Initialize variables
$message = ""; $error = "";

// 2. Process POST data with validation
if ($_POST) {
    include 'connect.php';
    // Validate inputs
    // Execute prepared statements
    // Set success/error messages
}

// 3. HTML form with PHP-generated feedback
```

### Validation Standards
- Username: minimum 3 characters, must be unique
- Password: minimum 6 characters, confirmation required
- All fields required with `empty()` checks
- Update operations require current password verification

## Code Conventions

### CSS Integration
- Inline styles in `<style>` blocks for self-contained pages
- Consistent design system: container max-width 1200px, border-radius 8px, box-shadow styling
- Color coding: Blue (#007bff) for navigation, Red for delete, Green for success

### Error Handling
- Database errors: Display `$conn->error` or `$stmt->error`
- User errors: Store in `$error` variable, display in red styling
- Success feedback: Store in `$message` variable, display in green styling

### URL Parameters
- Edit/Delete operations use `?id=` parameter for user selection
- ID validation with `is_numeric()` before database queries
- Fallback error messages when user ID not found

## Testing & Debugging

### Local Testing Environment
- Test on `http://localhost/tugas_1/` (assumes XAMPP htdocs placement)
- Verify MySQL service running in XAMPP control panel
- Check browser console for JavaScript validation errors

### Database Verification
- Use phpMyAdmin at `http://localhost/phpmyadmin/` to inspect database
- Verify password hashing in database (should see bcrypt hashes)
- Check table structure matches schema in README.md

## Common Modification Patterns

### Adding New Fields
1. Update database schema in `setup.php`
2. Modify forms in relevant CRUD files
3. Update validation logic in POST processing
4. Adjust display in `view_users.php`

### Extending Security
- All new queries must use prepared statements
- New password fields need `password_hash()` for storage
- Add input sanitization with `htmlspecialchars()` for display

### UI/UX Updates
- Maintain consistent `.container` styling across pages
- Use `.back-link` class for navigation consistency
- Follow color-coding system for different action types