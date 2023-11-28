<?php
$conn = mysqli_connect("localhost", "root", "", "forumfusion");

?>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title> Forum Fusion </title>
  </head>
  <body>
    <header>  
    <div class="header_title">
      <h1 onClick="location.href='index.php'">ForumFusion </h1>
      <button class="login" value="login">Login</button>
      <button class="buypremium" onClick="location.href='buypremium.php'" value="Buy Premium">Buy Premium</button>
  </div>
  
 
    <div class="modal-cont">
        <div class="modal-box">
            <span class="close">&times;</span>
            <form action="" class="login-box">
              <h1 id="LoginText"> Login Page </h1>
                <label for="">Username</label>
                <input type="text" class="name" required>
                <label for="">Password</label>
                <input type="password" class="password" required>
              <button class="login-button">Login</button>
                <div class="close-forgot">
                  Forgot your password? Click here
                    <!-- <button class="cancel"></button> -->
                </div>
            </form>
        </div>
    </div>

    <div class="modal-contR">
        <div class="modal-boxR">
            <span class="closeR">&times;</span>
            <form action="" class="login-boxR">
              <h1 id="RegisterText"> Register </h1>
                <label for="">Username</label>
                <input type="text" class="nameR" required>
                <label for="">Password</label>
                <input type="password" class="passwordR" required>
                <label for="">Password</label>
                <input type="password" class="passwordRR" required>
              <button class="login-buttonR">Login</button>
                <div class="close-forgotR">
                  Forgot your password? Click here
                    <!-- <button class="cancel"></button> -->
                </div>
            </form>
        </div>
    </div>
</header>
    <script>
        var closeBut = document.getElementsByClassName('close')[0],
    modal = document.getElementsByClassName('modal-cont')[0],
    // cancelBut = document.getElementsByClassName('cancel')[0],
    loginBut = document.getElementsByClassName('login')[0];
    
//close
function x () {
    modal.style.display = "none";
}
closeBut.onclick = x;
// cancelBut.onclick = x;

loginBut.onclick = function () {
    modal.style.display = "block";
}

window.onclick = function (e) {
    if (e.target.className === 'modal-cont'){
        e.target.style.display = 'none';
    }
}

// REGISTER ONLY


var closeButR = document.getElementsByClassName('closeR')[0],
    modalR = document.getElementsByClassName('modal-contR')[0],
    // cancelBut = document.getElementsByClassName('cancel')[0],
    loginButR = document.getElementsByClassName('loginR')[0];
    
//close
function xR () {
    modal.style.display = "none";
}
closeButR.onclick = xR;
// cancelBut.onclick = x;

loginButR.onclick = function () {
    modal.style.display = "block";
}

window.onclick = function (eR) {
    if (eR.target.className === 'modal-contR'){
        eR.target.style.display = 'none';
    }
}
    </script>

  </body>
</html>










<?php
include "defaultdata.php";

// Check if the 'post_id' key is set in the $_GET array
if (isset($_GET['post_id'])) {
    // Use prepared statements to prevent SQL injection
    $postId = $_GET['post_id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM forumpost WHERE post_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && $postData = mysqli_fetch_assoc($result)) {
        // Display the post content
?>
       <div class="forumpost">
  <?php 
    $rank = $postData["post_rank"];
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

      echo "<p class='post-user'>" . $postData['post_username'] . " <span class='$rankClass'>$rank</span>";
    }
    ?>
  </p>
  <p class="post-date"><?php echo $postData['post_date']; ?></p><br>
  <h2><?php echo $postData['post_title']; ?></h2>
  <p><?php echo $postData['post_content']; ?></p>
</div>
<?php
    } else {
        echo "Post not found!";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid URL!";
}
?>
