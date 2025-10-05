<?php
$usr = $_POST['usr'];
$psw = $_POST['psw'];
$confirm_psw = $_POST['confirm_psw'];
$fname = $_POST['fname'];
$role = $_POST['role'];

// Check if passwords match
if ($psw !== $confirm_psw) {
    echo "Passwords do not match. <a href='registration.php'>Back</a>";
    exit();
}

// echo "Product Name: " . $product_name . "<br>";
// echo "Product Description: " . $product_description . "<br>";
// echo "Product Price: " . $product_price . "<br>";

include 'connect.php';

// hash password
$hashed_psw = password_hash($psw, PASSWORD_DEFAULT);

// insert data user
$sql = "INSERT INTO users (username, password, fullname, role)
VALUES ('$usr', '$hashed_psw', '$fname', '$role')";

if ($conn->query($sql) === TRUE) {
  echo "<h2>Registration Successful!</h2>";
  echo "<p>Your account has been created successfully.</p>";
  echo "<p><strong>Next steps:</strong></p>";
  echo "<ol>";
  echo "<li>Activate your account via <a href='activate.html'>Activation Page</a></li>";
  echo "<li>Then <a href='login.html'>Login</a> to access the system</li>";
  echo "</ol>";
  echo "<a href='index.php'>Back to Home</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . "<br><a href='index.php'>Back</a>";
}

// $conn->close();
// ?>