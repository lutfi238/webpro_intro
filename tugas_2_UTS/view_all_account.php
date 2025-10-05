<?php
// Read all
include 'connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<html>
<head>
    <title>All User Accounts</title>
</head>
<body>
    <h2>Users Account</h2>
    <a href='index.php'>Home</a> | <a href='registration.php'>Add New User</a><br><br>
<?php

// if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>";
    // output data of each row
    $no = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $no++ . "</td>
            <td>" . $row['username'] . "</td>
            <td>" . $row['fullname'] . "</td>
            <td>" . $row['role'] . "</td>
            <td><a href='form_edit_user.php?id=$row[id]'>Edit</a> | 
            <a href='delete_user.php?id=$row[id]'onclick='return confirm(\"Are you sure to delete this account?\")'>Delete</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "0 results - Table is empty";
}

$conn->close();
?>
</body>
</html>