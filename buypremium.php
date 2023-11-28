<?php
include "defaultdata.php";

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
        case 'Admin':
            $_SESSION['admin_name'] = $row['username'];
            // header('location:admin_page.php');
            break;

        case 'default':
            $_SESSION['user_name'] = $row['username'];
            // header('location:user_page.php');
            break;

        case 'Premium':
            $_SESSION['premium_name'] = $row['username'];
            // header('location:user_page.php');
            break;

        case 'Moderator':
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
        
      ?>
    
      
      
  </div>


</header>

<?php
// Assuming you already have a database connection ($conn)

// Initialize an error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered beta code
    $enteredCode = $_POST["name"];

    // Your secret beta code
    $secretCode = "forumfusionpremiumchad";

    // Check if the entered code is correct
    if ($enteredCode == $secretCode) {
        // Update user_type to "Premium" for the user in your table
        $updateQuery = "UPDATE users SET user_type = 'Premium' WHERE username = '$activeusername'";

        if ($conn->query($updateQuery) === TRUE) {
            $errorMsg = "Congratulations! You are now a premium member! Please re-sign!";
            session_destroy();
        } else {
            // Set an error message
            $errorMsg = "Error updating user: " . $conn->error;
        }
    } else {
        // Incorrect code, set an error message
        $errorMsg = "Incorrect beta code. Please try again.";
    }
}

// Close the database connection if needed
// $conn->close();
?>

<section id="contentpremium">
    <h1>ACTIVATE PREMIUM (BETA)</h1>
    <p>This feature is in BETA - if you happen to have an access code please enter it below:</p>
    <!-- Display the error message within the span with class "error-messagepremium" -->
    <span class="error-messagepremium"><?php echo $errorMsg; ?></span>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Beta Code"><br>
        <button id="premiumsubmit" type="submit" name="premiumsubmit"><i class="fa-solid fa-crown"></i></button>
    </form>
</section>

</body>
</html>
            
    

<div class="comment_area">
      <?php
      //  $showcomments = mysqli_query($conn, "SELECT * FROM tb_data WHERE reply_id = 0"); // only select comment and not select reply
      //  foreach($showcomments as $data) {
      //    require 'comment.php';
      //  }
      ?>
      <!-- <form action = "" method = "post">
        <h3 id = "title">Leave a Comment</h3>
        <input type="hidden" name="reply_id" id="reply_id">
        <input type="text" name="name" placeholder="Your name">
        <textarea name="comment" placeholder="Your comment"></textarea>
        <button class = "submit" type="submit" name="submit">Submit</button>
      </form> -->

    </section>
      
    </div>
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
    if (e.target.className === 'modal-cont' || e.target.className === "modal-contR" ||  e.target.className === "submit-postcomment-cont"){
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




    </script>
  </body>
</html>
