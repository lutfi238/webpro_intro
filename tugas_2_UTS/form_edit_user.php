<?php
// create connection
include 'connect.php';


// get id from URL
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
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
    <h2>Update User Account</h2>
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?= $row['id']?>">
        Username :<br><input type="text" name="usr" value="<?= $row['username']?>"><br>
        Full Name:<br><input type="text" name="fname" value="<?= $row['fullname']?>"><br>
        Role:<br>

        <?php  
        // check role
        $admin = $operator = $visitor = ""; // initial value
        if ($row['role'] == "admin") {
            $admin = "selected";
        }
        if ($row['role'] == "operator") {
            $operator = "selected";
        }
        if ($row['role'] == "visitor") {
            $visitor = "selected";
        }
        ?>

        <select name ="role">
            <option value="admin" <?= $admin; ?>>Admin</option>
            <option value="operator" <?= $operator; ?>>Operator</option>
            <option value="visitor" <?= $visitor; ?>>Visitor</option>
        </select>
        <!-- <input type="text" name="role" value="<?= $row['role']?>"><br> -->
        <input type="submit" value="Update User">
    </form>
</html>

<?php
// Close connection
$conn->close();
?>