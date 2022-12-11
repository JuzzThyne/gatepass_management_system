<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    

</head>
<body>
   
<div class="container">

   <div class="profile">
   <?php
   ?>
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `apartment` WHERE ID = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="admin/uploaded_img/default-avatar.png">';
         }else{
            echo '<img src="admin/uploaded_img/'.$fetch['image'].'" height=500 width=500>';
         }
      ?>
      <h3><?php echo $fetch['homeowner']; ?></h3>
      <a href="update_profile.php" class="btn">update profile</a>
      <a href="qrcodenew.php" class="btn">generate QR code</a>
      <a href="index.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
      <p>new <a href="index.php">login</a> or <a href="index.php">register</a></p>
   </div>

</div>

</body>
</html>