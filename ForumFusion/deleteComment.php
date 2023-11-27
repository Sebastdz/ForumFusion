<?php
// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection or initialization here
    include "defaultdata.php";

    // Get the post ID from the POST request
    $commentId = $_POST['comment_id'];

    // Validate and sanitize the input if needed

    // Use a prepared statement to delete the post
    $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = ?");
    $stmt->bind_param("i", $commentId);

    if ($stmt->execute()) {
        // Deletion was successful
        echo "Post deleted successfully";
    } else {
        // Error handling
        echo "Error deleting post: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle non-POST requests (optional)
    echo "Invalid request method";
}
?>
