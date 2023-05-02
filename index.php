<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `apartment` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['ID'];
      header('location:profile.php');

      
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <!-- LOGIN FORM -->
          <form action="" method="post" enctype="multipart/form-data" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <?php
           if(isset($message)){
            foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
             }
              }
            ?>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="email" name="email" placeholder="enter email" required>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="enter password" required>
            </div>
            <input type="submit" name="submit" value="login now" class="btn solid" />
          </form>

<?php
include 'config.php';

if(isset($_POST['submitsignup'])){

   $housenumber = mysqli_real_escape_string($conn, $_POST['housenumber']);
   $street = mysqli_real_escape_string($conn, $_POST['street']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
  //  $image = $_FILES['image']['name'];
  //  $image_size = $_FILES['image']['size'];
  //  $image_tmp_name = $_FILES['image']['tmp_name'];
  //  $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `apartment` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }
      // elseif($image_size > 2000000){
      //    $message[] = 'image size is too large!';
      // }
      else{
         $insert = mysqli_query($conn, "INSERT INTO `apartment`(apartment_number,building_number,homeowner, email, password) VALUES('$housenumber','$street','$name', '$email', '$pass')") or die('query failed');

         if($insert){
            // move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }
}
?>
          <!-- SIGN UP FORM -->
          <form action="" method="post" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <?php
      //       if(isset($message)){
      //       foreach($message as $message){
      //       echo '<div class="message">'.$message.'</div>';
      //      }
      // }
      ?>
            <div class="input-field">
              <i class=""></i>
              <input type="text" name="housenumber" placeholder="House Number ('block 1 lot 1')" required>
            </div>   
            <div class="input-field">
              <i class="fas fa-user"></i>
              <select type="text" name="street" placeholder="Select Street" required>
                      <option selected="">Choose Street</option>
                      <option value="61 Palm Drive">61 Palm Drive</option>
                      <option value="Cedar Dr">Cedar Dr</option>
                      <option value="Cypress Dr">Cypress Dr</option>
                      <option value="Golden Ville HOA">Golden Ville HOA</option>
                      <option value="Linden Dr">Linden Dr</option>
                      <option value="Maple Dr">Maple Dr</option>
                      <option value="Mulberry Dr">Mulberry Dr</option>
                      <option value="Oak Ln">Oak Ln</option>
                      <option value="Willow Dr">Willow Dr</option>
                      <option value="Pine Dr">Pine Dr</option>
                      <option value="Palm Dr">Palm Dr</option>
                    </select>
            </div>      
            <div class="input-field">
              <i class=""></i>
              <input type="text" name="name" placeholder="Enter Fullname" required>
            </div>
            <div class="input-field">
              <i class=""></i>
              <input type="email" name="email" placeholder="Enter Email"  required>
            </div>
            <div class="input-field">
              <i class=""></i>
              <input type="password" name="password" placeholder="Enter Password"  required>
            </div>
            <div class="input-field">
              <i class=""></i>
              <input type="password" name="cpassword" placeholder="Confirm Password"  required>
            </div>
            <input type="submit" name= "submitsignup" value="Sign up" class="btn solid"  >         
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Not Register ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/sub.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/sub.png" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  </body>
</html>
