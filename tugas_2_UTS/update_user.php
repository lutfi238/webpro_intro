<?php
//get data from the edit form
$userID = $_POST['id'];
$fname = $_POST['fname'];
$role = $_POST['role'];

// echo "Product Name: " . $product_name . "<br>";
// echo "Product Description: " . $product_description . "<br>";
// echo "Product Price: " . $product_price . "<br>";
include 'connect.php';

// update database
$sql = "UPDATE users 
        SET fullname='$fname', 
        role='$role' 
        WHERE id=$userID";

//check data if update succesfully
if ($conn->query($sql) === TRUE) {
  echo "Updated record successfully";
  //redirect to view_all_account.php (view 1 record data)
  header('Location: view_all_account.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>