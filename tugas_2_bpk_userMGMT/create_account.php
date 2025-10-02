<?php
$usr = $_POST['usr'];
$psw = $_POST['psw'];
$fname = $_POST['fname'];
$role = $_POST['role'];

// echo "Product Name: " . $product_name . "<br>";
// echo "Product Description: " . $product_description . "<br>";
// echo "Product Price: " . $product_price . "<br>";

include 'connect.php';

// insert data user
$sql = "INSERT INTO users (username, password, fullname, role)
VALUES ('$usr', '$psw', '$fname', '$role')";

if ($conn->query($sql) === TRUE) {
  echo "New account added successfully";
  // redirect to the file view_all_account.php (view all data)
  header('Location: view_all_account.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// $conn->close();
// ?>