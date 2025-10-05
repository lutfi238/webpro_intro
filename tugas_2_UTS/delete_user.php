<?php
// create connection
include 'connect.php';

$sql = "DELETE FROM users WHERE id = $_GET[id]";

//check data if update succesfully
if ($conn->query($sql) === TRUE) {
    echo "Selected record deleted successfully";
    //redirect to view_all_account.php (view 1 record data)
    header('Location: view_all_account.php');
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br><a href='index.php'>Back</a>";
  }

// Close connection
$conn->close();
?>