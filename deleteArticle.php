<?php
// Include database connection
include('db.php');

// Check if task ID is provided and valid
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute delete statement
    $query = "DELETE FROM articles WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $success = mysqli_stmt_execute($stmt);

    // Check if delete was successful
    if ($success) {
        echo "Task deleted successfully.";
    } else {
        echo "Error deleting task: " . mysqli_error($connection);
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($connection);
?>
