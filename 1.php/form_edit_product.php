<?php
// create connection
include 'connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


// //Path to add data
// echo "<a href='form_input_product.php'>Add Product</a>";

// //View data using table
// echo"<table border = 'bold'>
//     <tr>
//         <th>Product ID</th>
//         <th>Product Name</th>
//         <th>Product Description</th>
//         <th>Product Price</th>
//         <th>Created</th>
//     </tr>
//     <tr>
//         <td>" .$row['id'] . "</td>
//         <td>" .$row['name'] . "</td>
//         <td>" .$row['description'] . "</td>
//         <td>" .$row['price'] . "</td>
//         <td>" .$row['created'] . "</td>
//     </tr>
//     </table><br>";

?>

<html>
    <h2>Update Product</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $row['id']?>"><br>
        Name: <br><input type="text" name="name" value="<?= $row['name']?>"><br>
        Desciption: <br><textarea name="description"><?= $row['description']?></textarea><br>
        price: <br><input type="text" name="price" value="<?= $row['price']?>"><br> <br>
        <input type="submit" value="Update Product">
    </form>
</html>

<?php
// Close connection
$conn->close();
?>