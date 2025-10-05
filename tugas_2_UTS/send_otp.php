<?php
session_start();
include 'connect.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$usr = $_POST['usr'];

// Check if account exists
$sql_check = "SELECT * FROM users WHERE username='$usr'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // Generate 6-digit OTP
    $otp = rand(100000, 999999);
    
    // Store OTP and username in session
    $_SESSION['reset_otp'] = $otp;
    $_SESSION['reset_username'] = $usr;
    $_SESSION['otp_time'] = time(); // For expiration
    
    // Send OTP via email
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lutfifirdaus238@gmail.com'; // Your Gmail address
        $mail->Password = 'vcrg bvws zevs mozm'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('lutfifirdaus238@gmail.com', 'User Management System');
        $mail->addAddress($usr);
        
        $mail->Subject = 'Password Reset OTP - User Management System';
        $mail->Body = "Hello,\n\nYour OTP for password reset is: $otp\n\nThis OTP will expire in 5 minutes.\n\nIf you didn't request this, please ignore this email.\n\nBest regards,\nUser Management System";
        
        $mail->send();
        echo "OTP sent successfully to your email!<br><br>";
        
    } catch (Exception $e) {
        echo "Failed to send OTP. Error: " . $mail->ErrorInfo . "<br>";
        echo "Please try again later or contact support.<br><br>";
    }
    
    echo "<a href='verify_otp.html'>Enter OTP</a>";
} else {
    echo "Account not found. <a href='index.php'>Back</a>";
}

$conn->close();
?>