<?php
// Assuming $conn is already defined and connected to your database

include "defaultdata.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_id"])) {
    // Get comment_id from the AJAX request
    $commentId = $_POST["comment_id"];

    // Find comment_username and comment_rank from comments table
    $getCommentInfoQuery = "SELECT comment_username, comment_rank FROM comments WHERE comment_id = ?";
    $getCommentInfoStmt = $conn->prepare($getCommentInfoQuery);
    $getCommentInfoStmt->bind_param("i", $commentId);
    $getCommentInfoStmt->execute();
    $getCommentInfoResult = $getCommentInfoStmt->get_result();

    if ($getCommentInfoResult->num_rows > 0) {
        $commentInfoRow = $getCommentInfoResult->fetch_assoc();
        $commentUsername = $commentInfoRow["comment_username"];
        $commentRank = $commentInfoRow["comment_rank"];

        // Check if the comment_rank is not "Admin"
        if ($commentRank !== "Admin") {
            // Update post_rank to "Banned" in forumpost table
            $updatePostRankQuery = "UPDATE forumpost SET post_rank = 'Banned' WHERE post_username = ?";
            $updatePostRankStmt = $conn->prepare($updatePostRankQuery);
            $updatePostRankStmt->bind_param("s", $commentUsername);
            $updatePostRankStmt->execute();

            // Update user_type in users table
            $updateUserTypeQuery = "UPDATE users SET user_type = 'Banned', banned = 'Yes' WHERE username = ?";
            $updateUserTypeStmt = $conn->prepare($updateUserTypeQuery);
            $updateUserTypeStmt->bind_param("s", $commentUsername);
            $updateUserTypeStmt->execute();

            // Update comment_rank in comments table
            $updateCommentRankQuery = "UPDATE comments SET comment_rank = 'Banned' WHERE comment_username = ?";
            $updateCommentRankStmt = $conn->prepare($updateCommentRankQuery);
            $updateCommentRankStmt->bind_param("s", $commentUsername);
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
        echo "Error: Comment not found.";
    }

    // Close the prepared statement for retrieving comment information
    $getCommentInfoStmt->close();
} else {
    echo "Invalid request.";
}

// Close database connection
$conn->close();
?>
