<?php
// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection or initialization here
    include "defaultdata.php";

    // Get the post ID and user ID from the POST request
    $postId = $_POST['post_id'];
    $postUserId = $_POST['post_userid'];

    $banned = "Banned";

    // Use a prepared statement to update the forum post's rank to "Banned"
    $stmtBanPost = $conn->prepare("UPDATE forumpost SET post_rank = ? WHERE post_id = ?");
    $stmtBanPost->bind_param("si", $banned, $postId);

    // Use a prepared statement to update the user's type to "Banned"
    $stmtBanUser = $conn->prepare("UPDATE users SET user_type = ? WHERE user_id = ?");
    $stmtBanUser->bind_param("si", $banned, $postUserId);

    // Transaction to ensure both updates are applied atomically
    $conn->begin_transaction();

    try {
        // Update forum post
        if ($stmtBanPost->execute()) {
            // Update user
            if ($stmtBanUser->execute()) {
                // Commit the transaction if both updates are successful
                $conn->commit();
                echo "User and post banned successfully";
            } else {
                // Rollback the transaction if there is an error updating the user
                $conn->rollback();
                echo "Error banning user: " . $stmtBanUser->error;
            }
        } else {
            // Rollback the transaction if there is an error updating the post
            $conn->rollback();
            echo "Error banning user: " . $stmtBanPost->error;
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an exception
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close the statements
    $stmtBanPost->close();
    $stmtBanUser->close();

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
