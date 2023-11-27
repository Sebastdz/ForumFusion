<link rel="stylesheet" href="style.css">


<div class="forumpost" onclick="openFullScreen(<?php echo $data['post_id']; ?>)">
  <?php 
  include "defaultdata.php";

    $rank = $data["post_rank"];
    if($rank=="Banned")
    {
      $rank = "<i class='fa-solid fa-ban'></i>";
       $rankClass = 'rank_banned';
      echo "<p class='post-user'>" . "[deleted] <span class='$rankClass'>$rank</span>";
    }
    else 
    {
    
      $rankClass = '';
      
      switch ($rank) {
        case 'Premium':
          $rank = "<i class='fa-solid fa-crown'></i>";
          $rankClass = 'rank_premium';
          break;
        case 'Moderator':
          $rank = "<i class='fa-solid fa-hammer'></i>";
          $rankClass = 'rank_moderator';
          break;
        case 'Admin':
          $rank = "<i class='fa-solid fa-screwdriver-wrench'></i>";
          $rankClass = 'rank_admin';
          break;
          case 'Banned':
            $rank = "<i class='fa-solid fa-ban'></i>";
            $rankClass = 'rank_banned';
            break;
        
        default:
          $rank = "<i class='fa-solid fa-user'></i>";
          $rankClass = 'rank_user';
          break;
      }

      echo "<p class='post-user'>" . $data['post_username'] . " <span class='$rankClass'>$rank</span>";

    
    }
    ?>
  </p>
  <p class="post-date"><?php echo $data['post_date']; ?></p><br>
  <h2><?php echo $data['post_title']; ?></h2>
  <p><?php echo $data['post_content']; ?></p>
</div>

<?php

// Assuming $data contains the post information fetched from the database

// Check if the user is an admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    echo "<button class='deletebutton' onclick='deletePost(" . $data['post_id'] . ")'>Delete Post</button>";
    echo "<button class='deletebutton' onclick='deletePostByStaff(" . $data['post_id'] . ")'>Delete Content</button>";
    echo "<button class='deletebutton' onclick='banUser(\"" . $data['post_id'] . "\")'>Ban User</button>";
} 

else if (isset($_SESSION['moderator_logged_in']) && $_SESSION['moderator_logged_in']) {
  echo "<button class='deletebutton' onclick='deletePost(" . $data['post_id'] . ")'>Delete Post</button>";
  echo "<button class='deletebutton' onclick='deletePostByStaff(" . $data['post_id'] . ")'>Delete Content</button>";
  echo "<button class='deletebutton' onclick='banUser(\"" . $data['post_id'] . "\")'>Ban User</button>";
} 
// Check if the user is a premium user and is the owner of the post
else if (isset($_SESSION['premium_logged_in']) && $_SESSION['premium_logged_in'] && isset($_SESSION['premium_name']) && $_SESSION['premium_name'] == $data['post_username']) {
    echo "<button class='deletebutton' onclick='deletePostByUser(" . $data['post_id'] . ")'>Delete My Post</button>";
} 
// Check if the user is a regular user and is the owner of the post
else if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && isset($_SESSION['user_name']) && $_SESSION['user_name'] == $data['post_username']) {
    echo "<button class='deletebutton' onclick='deletePostByUser(" . $data['post_id'] . ")'>Delete My Post</button>";
}



?>


<script>
    function openFullScreen(postId) {
        window.location.href = 'full_screen.php?post_id=' + postId;
    }

    function deletePost(postId) {
        if (confirm("Are you sure you want to delete this post?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "deletePost.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("post_id=" + postId);
        }
    }

    function deletePostByStaff(postId) {
        if (confirm("Are you sure you want to delete the content of this post?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "deletePostByStaff.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("post_id=" + postId);
        }
    }

    function deletePostByUser(postId) {
    if (confirm("Are you sure you want to delete your post?")) {
        // If the user confirms the deletion, send an AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reload the page or update the UI as needed
                location.reload(); // This is a simple example; you may want to handle this more gracefully
            }
        };
        xhr.open("POST", "deletePostByUser.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("post_id=" + postId);
    }
}

function banUser(postId) {
        if (confirm("Are you sure you want to ban this user?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "banUser.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("post_id=" + postId);
        }
    }


if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>
