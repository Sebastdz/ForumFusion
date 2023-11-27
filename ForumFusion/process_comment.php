<?php
session_start();
include "defaultdata.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST['post_id'];
    $commentContent = $_POST['comment_content'];
    $date = date('F d Y, h:i:s A');
    

    $insertCommentQuery = "INSERT INTO comments (comment_content, comment_username, comment_rank, post_id, comment_date) VALUES (?, ?, ?, ?, ?)";
    if ($insertCommentStmt = mysqli_prepare($conn, $insertCommentQuery)) {
       

        if (isset($_SESSION['admin_name'])) {
        $activeusername = $_SESSION['admin_name'];
        $commentrank = "Admin";
        }
        else if (isset($_SESSION['moderator_name'])) {
            $activeusername = $_SESSION['moderator_name'];
            $commentrank = "Moderator";
            }
            else if (isset($_SESSION['premium_name'])) {
                $activeusername = $_SESSION['premium_name'];
                $commentrank = "Premium";
                }
                else
                {
                    $activeusername = $_SESSION['user_name'];
                    $commentrank = "User";
                }
        
        mysqli_stmt_bind_param($insertCommentStmt, "sssis", $commentContent, $activeusername,$commentrank, $postId, $date);
        mysqli_stmt_execute($insertCommentStmt);
        
        mysqli_stmt_close($insertCommentStmt);
    }
}
header("Location: full_post.php?post_id=" . $postId);
?>


