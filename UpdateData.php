<?php
include 'db_connect.php';

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
    $id = $_POST['id'];
    $updateTitle = $_POST['updateTitle'];
    $updateDescription = $_POST['updateDescription'];
    $updateCategory = $_POST['updateCategory'];
    $updateSlug = $_POST['updateSlug'];

    $sql = "UPDATE articles SET updateTitle='$updateTitle',updateDescription='$updateDescription',updateCategory='$updateCategory',updateSlug='$updateSlug', WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Missing parameters";
}
?>
