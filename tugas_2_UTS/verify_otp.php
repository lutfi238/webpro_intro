<?php
session_start();

// Check if OTP session exists
if (!isset($_SESSION['reset_otp']) || !isset($_SESSION['reset_username'])) {
    echo "Session expired. Please start over. <a href='reset_password.html'>Back</a>";
    exit();
}

// Check OTP expiration (5 minutes)
if (time() - $_SESSION['otp_time'] > 300) {
    unset($_SESSION['reset_otp']);
    unset($_SESSION['reset_username']);
    unset($_SESSION['otp_time']);
    echo "OTP expired. Please try again. <a href='reset_password.html'>Back</a>";
    exit();
}

$entered_otp = $_POST['otp'];
$stored_otp = $_SESSION['reset_otp'];

if ($entered_otp == $stored_otp) {
    // OTP correct, show password reset form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Set New Password</title>
    </head>
    <body>
        <h2>Set New Password</h2>
        <form action="reset_password.php" method="post">
            <label for="new_psw">New Password:</label><br>
            <input type="password" name="new_psw" minlength="8" required><br>
            <label for="confirm_psw">Confirm Password:</label><br>
            <input type="password" name="confirm_psw" minlength="8" required><br>
            <input type="submit" value="Reset Password">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "Invalid OTP. <a href='verify_otp.html'>Try Again</a> | <a href='index.php'>Back</a>";
}
?>