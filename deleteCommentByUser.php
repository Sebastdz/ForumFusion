<?php
// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection or initialization here
    include "defaultdata.php";

    // Get the post ID from the POST request
    $commentId = $_POST['comment_id'];

    // Validate and sanitize the input if needed

    $replacementText = "[Removed by User]";
    $deletedUsername = "[deleted]";

    // Use a prepared statement to update the post
    $stmtUpdatePost = $conn->prepare("UPDATE comments SET comment_content = ? WHERE comment_id = ?");
    $stmtUpdatePost->bind_param("si", $replacementText, $commentId);

    if ($stmtUpdatePost->execute()) {
        // Post updated successfully
        $conn->commit();
        echo "Post updated successfully";
        header("index.php");
    } else {
        // Error updating post
        $conn->rollback(); // Rollback the transaction
        echo "Error updating post: " . $stmtUpdatePost->error;
    }

    // Close the statement
    $stmtUpdatePost->close();

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
