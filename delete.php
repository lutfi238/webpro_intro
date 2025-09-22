<?php
// create connection
include 'connect.php';

$sql = "DELETE FROM products WHERE id = $_GET[id]";

//check data if update succesfully
if ($conn->query($sql) === TRUE) {
    echo "Selected record deleted successfully";
    //redirect to read_all.php (view 1 record data)
    header('Location: read_all.php');
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

// Close connection
$conn->close();
?>