<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";
 
// get the q parameter from URL
$q = $_REQUEST["q"];

//$hint = "";
$con = mysqli_connect('localhost','root','','gatepass_db');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// lookup all hints from array if $q is different from ""
if ($q !="") {
  /*$q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }*/
  //$random = rand();


$result=mysqli_query($con,"SELECT * FROM apartment WHERE qrtext='$q'");
$rowcount=mysqli_num_rows($result);
if($rowcount==0)
{
// not registered
echo 'employee is not registered';  

}
else
{
date_default_timezone_set('Singapore');
$today_date = date("Y-m-d h-i-sa");
  $select = mysqli_query($con, "SELECT * FROM `apartment` WHERE qrtext = '$q'") or die('query failed');
  if(mysqli_num_rows($select) > 0){
          $fetch = mysqli_fetch_assoc($select);
    }
    date_default_timezone_set('Singapore');
      $today_date = date("Y-m-d h-i-sa");
      if($fetch['expiredtime'] > $today_date)
      {
         $resultGetStat = mysqli_query($con,"SELECT stat FROM apartment WHERE qrtext='$q' AND stat = '0'");
         $resultGetStat=mysqli_num_rows($resultGetStat);
         if($resultGetStat==1)
           {
            // getting stat where status is 1
            // get stat with corresponding qrcode
             $resultUpdate = mysqli_query($con,"UPDATE apartment SET stat = '1' WHERE qrtext='$q'");
            if($resultUpdate)
             {
                 // insert to tblvisitor
                $ret=mysqli_query($con,"INSERT INTO tblvisitor (VisitorName, MobileNumber, Address, Gender,Apartment, BuildingNo, EnterDate) SELECT homeowner, mobilenumber, addresss,gender,apartment_number,building_number,Now() FROM apartment WHERE qrtext='$q'");
               if($ret)
               {
                  echo '<div class="alert alert-success"><strong>Success!</strong> resident successfully time-in</div>';
                 }
                else
                {
               }    
            }
          }
           else
          {
          echo '<div class="alert alert-info"><strong>QR CODE!</strong> ALREADY TIME IN </div>';  
          }
      }
      else
      {
        echo '<div class="alert alert-danger"><strong>Failed!</strong> QR CODE EXPIRED</div>';
        
        
      }
        


  // $ret=mysqli_query($con,"INSERT INTO tblvisitor (VisitorName, MobileNumber, Address, Gender,Apartment, BuildingNo, EnterDate) SELECT homeowner, mobilenumber, addresss,gender,apartment_number,building_number,Now() FROM apartment WHERE qr='$q'");
  // if($ret)
  // {
  // echo '<div class="alert alert-success"><strong>Success!</strong> employee successfully time-in</div>';
  // 
  //  }
  // else
  // {
  // }

}

}

// Output "no suggestion" if no hint was found or output correct values
//echo $hint === "" ? "no suggestion" : $hint;
?>