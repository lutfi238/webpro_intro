<?php
// Read One
include 'connect.php';

// get id from url
$id = isset($_GET['id']);
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// if there are results
if ($result->num_rows > 0) {

    echo "<a href='form_input_product.php'>Add Product</a>";
    echo "<table border='bold'>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Description</th>    
            <th>Product Price</th>
            <th>Created</th>
            <th>Action</th>
        </tr>";
    // output data of each row
    $no = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $no++ . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>" . $row['price'] . "</td>
            <td>" . $row['created'] . "</td>
            <td><a href='form_edit_product.php?id=$row[id]'>Edit</a> | 
            <a href='delete.php?id=$row[id]'onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "0 results - Table is empty";
}

$conn->close();
?>