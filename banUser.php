<?php
// Assuming $conn is already defined and connected to your database

include "defaultdata.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["post_id"])) {
    // Get post_id from the AJAX request
    $postId = $_POST["post_id"];

    // Find post_username and post_rank from forumpost table
    $getPostInfoQuery = "SELECT post_username, post_rank FROM forumpost WHERE post_id = ?";
    $getPostInfoStmt = $conn->prepare($getPostInfoQuery);
    $getPostInfoStmt->bind_param("i", $postId);
    $getPostInfoStmt->execute();
    $getPostInfoResult = $getPostInfoStmt->get_result();

    if ($getPostInfoResult->num_rows > 0) {
        $postInfoRow = $getPostInfoResult->fetch_assoc();
        $postUsername = $postInfoRow["post_username"];
        $postRank = $postInfoRow["post_rank"];

        // Check if the post_rank is "Admin"
        if ($postRank !== "Admin") {
            // Update post_rank to "Banned" in forumpost table
            $updatePostRankQuery = "UPDATE forumpost SET post_rank = 'Banned' WHERE post_username = ?";
            $updatePostRankStmt = $conn->prepare($updatePostRankQuery);
            $updatePostRankStmt->bind_param("s", $postUsername);
            $updatePostRankStmt->execute();

            // Update user_type in users table
            $updateUserTypeQuery = "UPDATE users SET user_type = 'Banned', banned = 'Yes' WHERE username = ?";
            $updateUserTypeStmt = $conn->prepare($updateUserTypeQuery);
            $updateUserTypeStmt->bind_param("s", $postUsername);
            $updateUserTypeStmt->execute();

            // Update comment_rank in comments table
            $updateCommentRankQuery = "UPDATE comments SET comment_rank = 'Banned' WHERE comment_username = ?";
            $updateCommentRankStmt = $conn->prepare($updateCommentRankQuery);
            $updateCommentRankStmt->bind_param("s", $postUsername);
            $updateCommentRankStmt->execute();

            // Close prepared statements
            $updatePostRankStmt->close();
            $updateUserTypeStmt->close();
            $updateCommentRankStmt->close();

            echo "User banned successfully.";
        } else {
            echo "Error: Admin cannot be banned.";
        }
    } else {
        echo "Error: Post not found.";
    }

    // Close the prepared statement for retrieving post information
    $getPostInfoStmt->close();
} else {
    echo "Invalid request.";
}

// Close database connection
$conn->close();
?>
