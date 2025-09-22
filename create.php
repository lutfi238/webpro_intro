<?php
$product_name = $_POST['name'];
$product_description = $_POST['description'];
$product_price = $_POST['price'];

// echo "Product Name: " . $product_name . "<br>";
// echo "Product Description: " . $product_description . "<br>";
// echo "Product Price: " . $product_price . "<br>";

include 'connect.php';

$sql = "INSERT INTO products (name, description, price)
VALUES ('$product_name', '$product_description', '$product_price')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
  header('Location: read_one.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// $conn->close();
// ?>