<?php
//get data from the edit form
$prodID = $_POST['id'];
$prodName = $_POST['name'];
$prodDesc = $_POST['description'];
$prodPrice = $_POST['price'];

// echo "Product Name: " . $product_name . "<br>";
// echo "Product Description: " . $product_description . "<br>";
// echo "Product Price: " . $product_price . "<br>";
include 'connect.php';

// update database
$sql = "update products set name = '$prodName',
 description = '$prodDesc', 
 price = '$prodPrice' 
 where id = $prodID";

//check data if update succesfully
if ($conn->query($sql) === TRUE) {
  echo "Updated record successfully";
  //redirect to read_all.php (view 1 record data)
  header('Location: read_all.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>