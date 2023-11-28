<?php
include "defaultdata.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $new_rank = $_POST['new_rank'];

    // Update the user's rank in the database
    $query = "UPDATE users SET user_type = '$new_rank' WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Rank updated successfully!";
        header("location: adminUserPanel.php");
    } else {
        echo "Error updating rank: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
