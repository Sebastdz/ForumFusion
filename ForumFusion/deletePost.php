<?php
// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection or initialization here
    include "defaultdata.php";

    // Get the post ID from the POST request
    $postId = $_POST['post_id'];

    // Validate and sanitize the input if needed


    $stmtDeleteComments = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
    $stmtDeleteComments->bind_param("i", $postId);

    // Use a prepared statement to delete the post

     if ($stmtDeleteComments->execute()) {
        // Comments deleted successfully, now delete the post
        $stmtDeletePost = $conn->prepare("DELETE FROM forumpost WHERE post_id = ?");
        $stmtDeletePost->bind_param("i", $postId);

        if ($stmtDeletePost->execute()) {
            // Post and comments deleted successfully
            $conn->commit();
            echo "Post and associated comments deleted successfully";
    } else {
        // Error deleting post
        $conn->rollback(); // Rollback the transaction
        echo "Error deleting post: " . $stmtDeletePost->error;
    }

} else {
    // Error deleting comments
    $your_db_connection->rollback(); // Rollback the transaction
    echo "Error deleting comments: " . $stmtDeleteComments->error;
}

// Close the statement and database connection
$stmtDeleteComments->close();
$your_db_connection->close();
} else {
echo "Invalid request method";
}
?>
