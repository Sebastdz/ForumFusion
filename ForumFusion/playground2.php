<?php
    $conn = mysqli_connect("localhost", "root", "", "forumfusion");
    
    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date('F d Y, h:i:s A');
        $reply_id = $_POST["reply_id"];
      
        $query = "INSERT INTO tb_data VALUES('', '$name', '$comment', '$date', '$reply_id')";
        mysqli_query($conn, $query);
    }

    if(isset($_POST['submitR'])){

        $nameR = mysqli_real_escape_string($conn, $_POST['nameR']);
        $passR = md5($_POST['passwordR']);
        $cpass = md5($_POST['passwordRR']);
     
        $select = " SELECT * FROM users WHERE username = '$nameR' && password = '$passR' ";
     
        $result = mysqli_query($conn, $select);
     
        if(mysqli_num_rows($result) > 0){
     
           $error[] = 'user already exist!';
     
        }else{
     
           if($passR != $cpass){
              $error[] = 'password not matched!';
           }else{
              $insert = "INSERT INTO users(username, password) VALUES('$nameR','$passR')";
              mysqli_query($conn, $insert);
              // header('location:login_form.php');
           }
        }
     
     };
    
?>

<div class="modal-cont">
        <div class="modal-box">
            <span class="close">&times;</span>
            <form action="" class="login-box">
              <h1 id="LoginText"> Welcome&nbsp;back! </h1>
                <label for="">Username</label>
                <input type="text" class="name" name="nameL" required>
                <label for="">Password</label>
                <input type="password" class="password" name="passwordL" required>
              <button class="login-button" type="submit" name="submitL">Sign In</button>
                <div class="close-forgot">
                 <br> New here? <a style="text-decoration:none; cursor:pointer" class="loginR" >Create an account  </a>
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
                <div class="close-forgotR">
               <br> Already a member?  <a style="text-decoration:none; cursor:pointer" class="registertologin"  onClick="switchToLogin()"> Sign In  </a>
                    <!-- <button class="cancel"></button> -->
                </div>
            </form>
        </div>
    </div>
