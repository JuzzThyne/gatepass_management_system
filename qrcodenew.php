<?php
include('libs/phpqrcode/qrlib.php'); 
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
function getUsernameFromEmail($email) {
	$find = '@';
	$pos = strpos($email, $find);
	$username = substr($email, 0, $pos);
	return $username;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="libs/css/bootstrap.min.css">
	<link rel="stylesheet" href="libs/style.css">
   <title>QR CODE</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

      <div class="profile">
         
            <?php
           if(isset($message)){
            foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
            }
            }
            if(isset($_POST['submit']) ){ 
         date_default_timezone_set('Singapore');
         $today_date = date("Y-m-d h-i-sa");
         $select = mysqli_query($conn, "SELECT * FROM `apartment` WHERE ID = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
          $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['expiredtime'] > $today_date)
         {
            // ACTIVE
            echo '<span style="color:#AFA;text-align:center;font-size:20px">ACTIVE</span>';           
         }
         else
         {     
            echo '<span style="color:#AFA;text-align:center;font-size:20px">QR CODE GENERATED</span>';
            //echo 'QR CODE EXPIRED PLEASE GENERATED';
            // EXPIRED
            //echo '<img src="images/default-avatar.png">';
            $tempDir = 'admin/qrcodeimg/'; 
	         // $tempDir = 'temp/'; 
	         //$email = $_POST['mail'];
	         $subject =  $_POST['subject']; 
	         //$filename = getUsernameFromEmail($email);
	         $body =  $_POST['msg'];
            $replaced = str_replace('-', ' ', $body);
            //$codeContents = $subject.' '.$replaced; 
	         $codeContents = $body.' '.$subject; 
            $filename = ($codeContents).'.png';
            $qrtext = $body.' '.$subject;
            date_default_timezone_set('Singapore');
            $expiredtime = date("Y-m-d H:i:sa", strtotime('+12 hours'));
            mysqli_query($conn, "UPDATE `apartment` SET qr = '$filename', qrtext = '$qrtext', expiredtime = '$expiredtime' WHERE id = '$user_id'") or die('query failed');
	         QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5); 
            
            
         }   
         }
         ?>
         <h3>STATUS</h3>
         <?php
         $select = mysqli_query($conn, "SELECT * FROM `apartment` WHERE ID = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['qr'] == ''){
            echo '<img src="admin/qrcodeimg/example.jpg">';
         }else{
            echo '<img src="admin/qrcodeimg/'.$fetch['qr'].'.png" style="width:300px; height:300px; border-radius: 1px;"><br>';
           // echo '<img src="admin/uploaded_img/'.$fetch['image'].'" height=500 width=500>';
         }
         date_default_timezone_set('Singapore');
	      // $date = date('h-i-sa');
         ?>
         <!-- <?php echo '<img src="temp/'. @$filename.'.png" style="width:300px; height:300px; border-radius: 1px;"><br>'; ?> -->
         <h3><?php echo $fetch['homeowner']; ?></h3>
         <form method="post" action=""  >
					<div class="form-group">
						<!-- <label>HOMEOWNER NAME</label> -->
						<input type="hidden" class="form-control" name="subject" style="width:20em;" placeholder="Residents Name" value="<?php echo $fetch['homeowner']; ?><?php echo @$subject; ?>" required pattern="[a-zA-Z0-9 .]+" />
						<!-- <input type="text" class="form-control" name="subject" style="width:20em;" placeholder="Residents Name" value="<?php echo $fetch['homeowner']; ?>" required pattern="[a-zA-Z0-9 .]+" disabled /> -->
					</div>
					<div class="form-group">
						<!-- <label>QR CODE DATE GENERATED</label> -->
						<input type="hidden" class="form-control" name="msg" style="width:20em;"  value="<?php echo date('h-i-sa') ?><?php echo @$body; ?>" required  placeholder="QR Date Generated" ></textarea>
						<!-- <input type="text" class="form-control" name="msg" style="width:20em;" value="<?php echo @$date; ?>" required pattern="[a-zA-Z0-9 .]+" placeholder="QR Date Generated" disabled></textarea> -->
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="GENERATE QR CODE" onclick="myFunction()" class="btn" />
					</div>
				</form>
            <script>
            function myFunction() {
            document.getElementById("myForm").reset();
            }
            </script>
			<?php
			if(!isset($filename)){
				$message[] = 'NO QR CODE GENERATE';
			}
			?>
         <a class="btn" href="download.php?file=<?php echo $filename; ?>.png ">Download QR code</a>
         <a href="profile.php" class="delete-btn">go back</a>
	   </div>  
   </div>
</body>
</html>