<?php
include 'connect.php';

// $id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Product ID: " . $row['id'] . "<br>";
echo "Product Name: " . $row['name'] .   "<br>";
echo "Product Description: " . $row['description'] . "<br>";
echo "Product Price: " . $row['price'] . "<br>";
echo "Created: " . $row['created'] . "<br><br>";
//Path to add data
echo "<a href='form_input_product.php'>Add Product</a>";
//View data using table
echo"<table border = 'bold'>
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Description</th>
        <th>Product Price</th>
        <th>Created</th>
    </tr>
    <tr>
        <td>" .$row['id'] . "</td>
        <td>" .$row['name'] . "</td>
        <td>" .$row['description'] . "</td>
        <td>" .$row['price'] . "</td>
        <td>" .$row['created'] . "</td>
    </tr>
    </table><br>";


echo "Product ID: " . $row['id'] . " Product Name: " . $row['name'] . " Product Description: " . $row['description'] . " Product Price: " . $row['price'] . " Created: " . $row['created'];
$conn->close();
?>