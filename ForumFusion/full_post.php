<?php
$conn = mysqli_connect("localhost", "root", "", "forumfusion");

$activeusername= NULL;

// if(isset($_POST["submit"])){
//   $name = $_POST["name"];
//   $comment = $_POST["comment"];
//   $date = date('F d Y, h:i:s A');
//   $reply_id = $_POST["reply_id"];


  
//   $comment = "INSERT INTO tb_data VALUES('', '$name', '$comment', '$date', '$reply_id')";
//   mysqli_query($conn, $comment);
// }



  if(isset($_POST['submitR'])){

        $nameR = mysqli_real_escape_string($conn, $_POST['nameR']);
        $passR = md5($_POST['passwordR']);
        $cpass = md5($_POST['passwordRR']);
     
        $select = " SELECT * FROM users WHERE username = '$nameR' && password = '$passR' ";
     
        $resultR = mysqli_query($conn, $select);
     
        if (mysqli_num_rows($resultR) > 0) {
          $errorR = 'User already exists!';
          echo "<script>isRegisterModalOpen = true;</script>";
      } else {
          if ($passR != $cpass) {
              $errorR = 'Password not matched!';
              echo "<script>isRegisterModalOpen = true;</script>";
          } else {
              if (strlen($nameR) > 20) {
                  $errorR = 'Maximum username length is 20 characters!';
                  echo "<script>isRegisterModalOpen = true;</script>";
              } else {
                  $insert = "INSERT INTO users(username, password) VALUES('$nameR','$passR')";
                  mysqli_query($conn, $insert);
                  // header('location:login_form.php');
              }
          }
      }
    }

     $errors = array();
     session_start();

if(isset($_POST['submitL'])){

   $nameL = mysqli_real_escape_string($conn, $_POST['nameL']);
   $passL = md5($_POST['passwordL']);

   $selectL = " SELECT * FROM users WHERE BINARY username = '$nameL' && password = '$passL' ";

   $resultL = mysqli_query($conn, $selectL);

   if(mysqli_num_rows($resultL) > 0){

      $row = mysqli_fetch_array($resultL);

      switch ($row['user_type']) {
        case 'admin':
            $_SESSION['admin_name'] = $row['username'];
            // header('location:admin_page.php');
            break;

        case 'default':
            $_SESSION['user_name'] = $row['username'];
            // header('location:user_page.php');
            break;

        case 'premium':
            $_SESSION['premium_name'] = $row['username'];
            // header('location:user_page.php');
            break;

        case 'moderator':
            $_SESSION['moderator_name'] = $row['username'];
            // header('location:user_page.php');
            break;

        default:
            break;
    }
      
   }else{
    $error = "Incorrect username or password!";
    echo "<script>isLoginModalOpen = true;</script>";
   }

};
//DEBUGGING ON ACCOUNTS HERE
 // session_destroy();

 

?>
<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title> Forum Fusion </title>
  </head>
  <body>
    <header id="myHeader">  
    <div class="header_title" id="myHeadertitle">
      <h1 id="headertitletext" onClick="location.href='index.php'">ForumFusion </h1>
      <?php
         if (isset($_SESSION['admin_name'])) {
          echo '<div class="header-buttons">';
          echo '<div class="user-dropdown">';
          echo '<div class="user-info" onclick="toggleUserDropdown()">';
          echo '<span class="user-info-bg"></span>';
          echo '<p class="session-name"><span class="name-text">' . $_SESSION['admin_name'] . '</span><span class="rank_admin"><i class="fa-solid fa-screwdriver-wrench"></i></span></p>';
          echo '<span class="dropdown-toggle"></span>';
          echo '</div>';
          echo '<ul class="dropdown-content" id="userDropdown">';
          echo '<li><button id="signoutbut" onclick="location.href=\'logout.php\'"><i class="fa-solid fa-right-from-bracket"></i><span class="SignOutText">&nbsp;Sign&nbsp;Out</span></button></li>';
          echo '</ul>';
          echo '</div>';
          echo "</div>";
          $rank ="Admin";
          $activeusername = $_SESSION['admin_name'];
          $get_user_id_query = "SELECT user_id FROM users WHERE username = '$activeusername'";
        $resultselectuserid = mysqli_query($conn, $get_user_id_query);
        $row = mysqli_fetch_assoc($resultselectuserid);
        $userid = $row['user_id'];
  
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['moderator_logged_in'] = false;
        $_SESSION['premium_logged_in'] = false;
        $_SESSION['user_logged_in'] = false;
  
  }  elseif (isset($_SESSION['moderator_name'])) {
    echo '<div class="header-buttons">';
    echo '<div class="user-dropdown">';
    echo '<div class="user-info" onclick="toggleUserDropdown()">';
    echo '<span class="user-info-bg"></span>';
    echo '<p class="session-name"><span class="name-text">' . $_SESSION['moderator_name'] . '</span><span class="rank_moderator"><i class="fa-solid fa-hammer"></i></span></p>';
    echo '<span class="dropdown-toggle"></span>';
    echo '</div>';
    echo '<ul class="dropdown-content" id="userDropdown">';
    echo '<li><button id="signoutbut" onclick="location.href=\'logout.php\'"><i class="fa-solid fa-right-from-bracket"></i><span class="SignOutText">&nbsp;Sign&nbsp;Out</span></button></li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    $rank ="Moderator";
    $activeusername = $_SESSION['moderator_name'];
    $get_user_id_query = "SELECT user_id FROM users WHERE username = '$activeusername'";
        $resultselectuserid = mysqli_query($conn, $get_user_id_query);
        $row = mysqli_fetch_assoc($resultselectuserid);
        $userid = $row['user_id'];

        $_SESSION['admin_logged_in'] = false;
        $_SESSION['moderator_logged_in'] = true;
        $_SESSION['premium_logged_in'] = false;
        $_SESSION['user_logged_in'] = false;
         
   } elseif (isset($_SESSION['premium_name'])) {
    echo '<div class="header-buttons">';
      echo '<div class="user-dropdown">';
      echo '<div class="user-info" onclick="toggleUserDropdown()">';
      echo '<span class="user-info-bg"></span>';
      echo '<p class="session-name"><span class="name-text">' . $_SESSION['premium_name'] . '</span><span class="rank_premium"><i class="fa-solid fa-crown"></i></span></p>';
      echo '<span class="dropdown-toggle"></span>';
      echo '</div>';
      echo '<ul class="dropdown-content" id="userDropdown">';
      echo '<li><button id="signoutbut" onclick="location.href=\'logout.php\'"><i class="fa-solid fa-right-from-bracket"></i><span class="SignOutText">&nbsp;Sign&nbsp;Out</span></button></li>';
      echo '</ul>';
      echo '</div>';
      echo '</div>';
      $rank ="Premium";
      $activeusername = $_SESSION['premium_name'];
      $get_user_id_query = "SELECT user_id FROM users WHERE username = '$activeusername'";
        $resultselectuserid = mysqli_query($conn, $get_user_id_query);
        $row = mysqli_fetch_assoc($resultselectuserid);
        $userid = $row['user_id'];
          
        $_SESSION['admin_logged_in'] = false;
        $_SESSION['moderator_logged_in'] = false;
       $_SESSION['premium_logged_in'] = true;
       $_SESSION['user_logged_in'] = false;
  
   }elseif (isset($_SESSION['user_name'])) {
        echo '<div class="header-buttons">';
        echo '<div class="user-dropdown">';
        echo '<div class="user-info" onclick="toggleUserDropdown()">';
        echo '<span class="user-info-bg"></span>';
        echo '<p class="session-name"><span class="name-text">' . $_SESSION['user_name'] . '</span><span class="rank_user"><i class="fa-solid fa-user"></i></span></p>';
        echo '<span class="dropdown-toggle"></span>';
        echo '</div>';
        echo '<ul class="dropdown-content" id="userDropdown">';
        echo '<li><button id="signoutbut" onclick="location.href=\'logout.php\'"><i class="fa-solid fa-right-from-bracket"></i><span class="SignOutText">&nbsp;Sign&nbsp;Out</span></button></li>';
        echo '</ul>';
        echo '</div>';
        echo '<button class="buypremium" onClick="location.href=\'buypremium.php\'"> <span class="button-text2">Premium </span> <i class="fa-solid fa-crown"></i></button>';
       echo "</div>";
       $activeusername = $_SESSION['user_name'];
       $get_user_id_query = "SELECT user_id FROM users WHERE username = '$activeusername'";
        $resultselectuserid = mysqli_query($conn, $get_user_id_query);
        $row = mysqli_fetch_assoc($resultselectuserid);
        $userid = $row['user_id'];

        $_SESSION['admin_logged_in'] = false;
        $_SESSION['moderator_logged_in'] = false;
        $_SESSION['premium_logged_in'] = false;
        $_SESSION['user_logged_in'] = true;

       $rank ="User";
        } else {
          echo '<button class="login" value="login"> <span class="button-text">Sign In </span><i class="fa-solid fa-right-to-bracket"></i></button>';
          echo '<button class="register" value="login"> <span class="button-text">Sign Up </span> </button>';
        }
       

     
        if(isset($_POST["submitpost"])){
          $name = $activeusername;
          $title = $_POST["post_title"];
          $date = date('F d Y, h:i:s A');
          $content = $_POST["post_content"];
        
        
          
          $submit_post = "INSERT INTO forumpost (post_userid,post_rank, post_username, post_date, post_title, post_content) VALUES (?,?, ?, ?, ?, ?)";
          $stmt = mysqli_prepare($conn, $submit_post);
          mysqli_stmt_bind_param($stmt, "isssss",$userid, $rank, $name, $date, $title, $content);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
          // mysqli_query($conn, $submit_post);
          header("index.php");
        }
        
      ?>
    
      
      
  </div>

  <button class="logged-postcomment2" onclick="newpost()"><i class="fa-solid fa-plus"></i> <span class="button-text">New Comment</span></button>


</header>
<section class="content">
<div class="comment_area">

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
      
?>
  <div class="forumpost-full">
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
      if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
        echo "<button class='deletebutton' onclick='deletePost(" . $postData['post_id'] . ")'>Delete Post</button>";
        echo "<button class='deletebutton' onclick='deletePostByStaff(" . $postData['post_id'] . ")'>Delete Content</button>";
        echo "<button class='deletebutton' onclick='banUser(\"" . $postData['post_username'] . "\")'>Ban User</button>";
    } 
    
    else if (isset($_SESSION['moderator_logged_in']) && $_SESSION['moderator_logged_in']) {
      echo "<button class='deletebutton' onclick='deletePost(" . $postData['post_id'] . ")'>Delete Post</button>";
      echo "<button class='deletebutton' onclick='deletePostByStaff(" . $postData['post_id'] . ")'>Delete Content</button>";
      echo "<button class='deletebutton' onclick='banUser(\"" . $postData['post_username'] . "\")'>Ban User</button>";
    } 
    // Check if the user is a premium user and is the owner of the post
    else if (isset($_SESSION['premium_logged_in']) && $_SESSION['premium_logged_in'] && isset($_SESSION['premium_name']) && $_SESSION['premium_name'] == $postData['post_username']) {
        echo "<button class='deletebutton' onclick='deletePostByUser(" . $postData['post_id'] . ")'>Delete My Post</button>";
    } 
    // Check if the user is a regular user and is the owner of the post
    else if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && isset($_SESSION['user_name']) && $_SESSION['user_name'] == $postData['post_username']) {
        echo "<button class='deletebutton' onclick='deletePostByUser(" . $postData['post_id'] . ")'>Delete My Post</button>";
    }
    ?>
<?php
    } else {
      echo "<div class=notfound>";
  echo "<p> <i class='fa-solid fa-file-circle-question'></i> </p>";
    echo "<p> Post Not Found </p>";
    echo "<p class='notfounddesc'>Unfortunately, the post you are trying to access does not exist or was removed.</p>";
  echo "</div>";
  exit();
  }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
  echo "<div class=notfound>";
  echo "<p> <i class='fa-solid fa-link-slash'></i> </p>";
    echo "<p> Invalid URL </p>";
    echo "<p class='notfounddesc'>Unfortunately, the link you are trying to access does not exist.</p>";
  echo "</div>";
  exit();
}

$postId = $postData['post_id']; 
    $commentsQuery = "SELECT * FROM comments WHERE post_id = ?";
    if ($commentsStmt = mysqli_prepare($conn, $commentsQuery)) {
        mysqli_stmt_bind_param($commentsStmt, "i", $postId);
        mysqli_stmt_execute($commentsStmt);
        $commentsResult = mysqli_stmt_get_result($commentsStmt);

        echo "<div class='comments-container'>";
        while ($commentData = mysqli_fetch_assoc($commentsResult)) {
            $commentId = $commentData['comment_id'];
            $commentContent = $commentData['comment_content'];
            $commentUsername = $commentData['comment_username'];
            $commentDate = $commentData['comment_date'];

            echo "<div class='comment' id='comment_$commentId'>";

            $crank = $commentData["comment_rank"];
            if($crank=="Banned")
            {
              $crank = "<i class='fa-solid fa-ban'></i>";
               $crankClass = 'rank_banned';
              echo "<p class='post-user'>" . "[deleted] <span class='$rankClass'>$rank</span>";
            }
            else 
            {
            
              $crankClass = '';
              
              switch ($crank) {
                case 'Premium':
                  $crank = "<i class='fa-solid fa-crown'></i>";
                  $crankClass = 'rank_premium';
                  break;
                case 'Moderator':
                  $crank = "<i class='fa-solid fa-hammer'></i>";
                  $crankClass = 'rank_moderator';
                  break;
                case 'Admin':
                  $crank = "<i class='fa-solid fa-screwdriver-wrench'></i>";
                  $crankClass = 'rank_admin';
                  break;
                  case 'Banned':
                    $crank = "<i class='fa-solid fa-ban'></i>";
                    $crankClass = 'rank_banned';
                    break;
                
                default:
                  $crank = "<i class='fa-solid fa-user'></i>";
                  $crankClass = 'rank_user';
                  break;
              }
        

            echo "<p class='comment-user'>$commentUsername <span class='$crankClass'>$crank</span></p>" ;
            }
            echo "<p class='post-date'>$commentDate</p>";
            echo "<p class='comment-content'>$commentContent</p>";
            echo "</div>";
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
              echo "<button class='deletebuttoncomment' onclick='deleteComment(" . $commentId . ")'>Delete Comment</button>";
              echo "<button class='deletebuttoncomment' onclick='deleteCommentByStaff(" . $commentId . ")'>Delete Content</button>";
              echo "<button class='deletebuttoncomment' onclick='banUser(" . $commentId . ")'>Ban User</button>";
            }
           else if (isset($_SESSION['moderator_logged_in']) && $_SESSION['moderator_logged_in']) {
              echo "<button class='deletebuttoncomment' onclick='deleteComment(" . $commentId . ")'>Delete Comment</button>";
              echo "<button class='deletebuttoncomment' onclick='deleteCommentByStaff(" . $commentId . ")'>Delete Content</button>";
              echo "<button class='deletebuttoncomment' onclick='banUser(" . $commentId . ")'>Ban User</button>";
            }
        
        else if (isset($_SESSION['premium_logged_in']) && $_SESSION['premium_logged_in'] && isset($_SESSION['premium_name']) && $_SESSION['premium_name'] == $commentData['comment_username']) {
          echo "<button class='deletebuttoncomment' onclick='deleteCommentByUser(" . $commentData['comment_id'] . ")'>Delete My Comment</button>";
      } 
      // Check if the user is a regular user and is the owner of the post
      else if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] && isset($_SESSION['user_name']) && $_SESSION['user_name'] == $commentData['comment_username']) {
          echo "<button class='deletebuttoncomment' onclick='deleteCommentByUser(" . $commentData['comment_id'] . ")'>Delete My Comment</button>";
      }
    }
        echo "</div>";

        mysqli_stmt_close($commentsStmt);
    }
?>

<div class="submit-postcomment-cont">
<div class="submit-postcomment">
<span class="close3" onclick="xpostcomment2()">&times;</span>
<form method="post" action="process_comment.php">
    <h1 class="h1-postcomment"> New Comment</h1>
    <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
    <input type="text" name="comment_content" placeholder="Your comment">
    <button class="submit" type="submit">Submit Comment</button>
  </form>
    </div>
      </div>
    </div>
      
    </div>
   
    </section>
    
    <div class="modal-cont">
        <div class="modal-box">
            <span class="close">&times;</span>
            <form action="" method="post" class="login-box">
              <h1 id="LoginText"> Welcome&nbsp;back! </h1>
                <label for="">Username</label>
                <input type="text" class="name" name="nameL" required>
                <label for="">Password</label>
                <input type="password" class="password" name="passwordL" required>
              <button class="login-button" type="submit" name="submitL">Sign In</button>
               <div class="error-message" id="login-error-message"><?php echo isset($error) ? $error : ''; ?></div>
                <div class="close-forgot">
                 <br> New here? <a style="text-decoration:none; cursor:pointer" class="loginR" onClick="switchToRegister()" >Create an account  </a>
                    <!-- <button class="cancel"></button> -->
                </div>
            </form>
        </div>
    </div>

    <div class="modal-contR">
        <div class="modal-boxR">
            <span class="closeR">&times;</span>
            <form action="" method="post" class="login-boxR">
              <h1 id="LoginTextR">Create&nbsp;Account</h1>
                <label for="">Username</label>
                <input type="text" class="nameR" name="nameR" required>
                <label for="">Password</label>
                <input type="password" class="passwordR" name="passwordR" required>
                <label for="">Confirm Password</label>
                <input type="password" class="passwordRR" name="passwordRR" required>
              <button class="login-buttonR" type="submit" name="submitR">Sign Up</button>
              <div class="error-message" id="register-error-message"><?php echo isset($errorR) ? $errorR : ''; ?></div>
              <div class="error-message" id="registerpass-error-message"><?php echo isset($errorRP) ? $errorRP : ''; ?></div>
                <div class="close-forgotR">
               <br> Already a member?  <a style="text-decoration:none; cursor:pointer" class="registertologin"  onClick="switchToLogin()"> Sign In  </a>
                    <!-- <button class="cancel"></button> -->
                </div>
            </form>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    ?>

 
 
 
 
 
 <script>
function toggleUserDropdown() {
  var dropdown = document.getElementById("userDropdown");
  var userDropdown = document.querySelector('.user-dropdown');

  if (dropdown.style.display === "block") {
    dropdown.style.display = "none";
    userDropdown.classList.remove('active');
  } else {
    dropdown.style.display = "block";
    userDropdown.classList.add('active');
  }
}


        var closeBut = document.getElementsByClassName('close')[0],
    modal = document.getElementsByClassName('modal-cont')[0],
    // cancelBut = document.getElementsByClassName('cancel')[0],
    loginBut = document.getElementsByClassName('login')[0];
    loginButR = document.getElementsByClassName('register')[0];
    
//close
function x () {
    modal.style.display = "none";
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    window.location.reload();
}
closeBut.onclick = x;
// cancelBut.onclick = x;

loginBut.onclick = function () {
    modal.style.display = "block";
    modalR.style.display = "none";
}

window.onclick = function (e) {
    if (e.target.className === 'modal-cont' || e.target.className === "modal-contR"){
        e.target.style.display = 'none';
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    window.location.reload();
    }
}


 function showLoginModal() {
    if (isLoginModalOpen) {
//       modal.classList.add('no-zoom');
      modal.style.display = "block";
//       console.log('no-zoom class added'); 
    }
   }

   window.addEventListener("load", showLoginModal);

   function showRegisterModal() {
    if (isRegisterModalOpen) {
//       modal.classList.add('no-zoom');
      modalR.style.display = "block";
//       console.log('no-zoom class added'); 
    }
   }

   window.addEventListener("load", showRegisterModal);

      // REGISTER ONLY


      var closeButR = document.getElementsByClassName('closeR')[0],
    modalR = document.getElementsByClassName('modal-contR')[0],
    // cancelBut = document.getElementsByClassName('cancel')[0],
    loginButR = document.getElementsByClassName('register')[0];
    
//close
function xR () {
    modalR.style.display = "none";
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    window.location.reload();
}
closeButR.onclick = xR;


// cancelBut.onclick = x;

loginButR.onclick = function () {
    modalR.style.display = "block";
    modal.style.display = "none";
}

function switchToLogin() {
  modal.style.display = "block";
    modalR.style.display = "none";
      }

      function switchToRegister() {
  modal.style.display = "none";
    modalR.style.display = "block";
      }

// window.onclick = function (e) {
//     if (e.target.className === 'modal-cont'){
//         e.target.style.display = 'none';
//     }
// }

    </script>





  
  

    <script>
      function reply(id, name){
        title = document.getElementById('title');
        title.innerHTML = "Reply to " + name;
        document.getElementById('reply_id').value = id;
      }



      window.onscroll = function() {sticky_header()};

var header = document.getElementById("myHeader");
var header_title =document.getElementById("myHeadertitle");
var content = document.querySelector('.content');
var sticky = header.offsetTop;

function sticky_header() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
    header.classList.add("scrollheader");
    // content.style.paddingTop = '50';
  } else {
    header.classList.remove("sticky");
    header.classList.remove("scrollheader");
    // content.style.paddingTop = '0';
  }
}


    function openFullScreen(postId) {
        // Redirect to the full-screen view of the post without exposing post ID in the URL
        window.location.href = 'full_screen.php?post_id=' + postId; // Encode post ID to base64
    }



    function newpost() {
    var closepostcomment = document.getElementsByClassName('submit-postcomment-cont')[0];
    closepostcomment.style.display = "block";
  }

  function xpostcomment() {
    var closepostcomment = document.getElementsByClassName('submit-postcomment-cont')[0];
    closepostcomment.style.display = "none";
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
    // window.location.reload();
  }

  document.addEventListener("DOMContentLoaded", function() {
  var closeButpostcomment2 = document.getElementsByClassName('close3')[0];
  closeButpostcomment2.onclick = xpostcomment;

  var newPostButton2 = document.getElementsByClassName('logged-postcomment2')[0];

  // Check if the session variable exists before showing the button
   if (<?php echo isset($_SESSION['user_logged_in']) ? 'true' : 'false'; ?>) {
    newPostButton2.style.display = 'block'; // Show the button
    newPostButton2.onclick = newpost;
  } else {
    newPostButton2.style.display = 'none'; // Hide the button
  }
  
});


function deleteComment(commentId) {
        if (confirm("Are you sure you want to delete this comment?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "deleteComment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("comment_id=" + commentId);
        }
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


    function deleteCommentByStaff(commentId) {
        if (confirm("Are you sure you want to delete the content of this comment?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "deleteCommentByStaff.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("comment_id=" + commentId);
        }
    }

    function deleteCommentByUser(commentId) {
        if (confirm("Are you sure you want to delete the content of this comment?")) {
            // If the user confirms the deletion, send an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload(); // This is a simple example; you may want to handle this more gracefully
                }
            };
            xhr.open("POST", "deleteCommentByUser.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("comment_id=" + commentId);
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
  </body>
</html>
