<?php
    session_start();
    error_reporting(0);
    include('includes/dbconn.php');

    if (strlen($_SESSION['avmsaid']==0)) {
    header('location:logout.php');
    } else {
        if(isset($_POST['submit'])){

    $eid=$_GET['editid'];
    $apartmentstatus=$_POST['apartmentstatus'];
    $homeowner=$_POST['homeowner'];
    $addresss=$_POST['addresss'];
    $gender=$_POST['gender'];
    $mobilenumber=$_POST['mobilenumber'];

    $query=mysqli_query($con,"UPDATE apartment set apartment_status='$apartmentstatus', homeowner='$homeowner',mobilenumber='$mobilenumber', addresss = '$addresss', gender = '$gender' where  ID='$eid'");
 
    if ($query){
        $msg="Resident has been updated";
    } else {
        $msg="Something Went Wrong";}
    }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include 'includes/header.php'?>
  
    <?php $page='apartment'; include 'includes/sidebar.php'?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Apartment Details
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage House and Lot</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      
      <?php if($msg){ echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-info-circle'></i> Alert!</h4>
                $msg
    </div>";}  ?>

         <!-- Forms -->
     
      
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Please make changes per requirements</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <?php
            $eid=$_GET['editid'];
            $ret=mysqli_query($con,"SELECT * from  apartment where ID='$eid'");
            
            while ($row=mysqli_fetch_array($ret)) {

            ?>
            <div class="box-body">
              <div class="row">
                <form method="POST" class="">
                <div class="col-md-4">
                  <div class="form-group">
                    <h3> IMAGE</h3>
                    <?php
                     $select = mysqli_query($con, "SELECT image FROM `apartment` WHERE ID = '$eid'") or die('query failed4');
                    if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                    }?>
                    <?php
                    if($fetch['image'] == '')
                    {
                     echo '<img src="uploaded_img//default-avatar.png" height = "500" width = "355">';
                    }else{
                      header("Content-type: image/jpeg");
                      echo '<img src="uploaded_img/'.$fetch['image'].'" height = "500" width = "355">';
                    //  echo '<img src="uploaded_img/'.$fetch['image'].'" height = "500" width = "355">';
                    }?>
                  </div>
                  <!-- /.form-group -->
                </div>
                
                <div class="col-md-6">
                <?php
                     $select = mysqli_query($con, "SELECT * FROM `apartment` WHERE ID = '$eid'") or die('query failed4');
                    if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                    // $latitude = $fetch['latitude'];
                    // $longtitude = $fetch['longtitude'];
                    }
                ?>
                <div class="form-group">
                    <label>Residential's Map</label><br>
                    <td style = "width: 450px; height: 450px;"><iframe style = "width: 75%; height: 100%;" src="https://www.google.com/maps?q=<?php echo $fetch['latitude'];?>,<?php echo $fetch['longtitude'];?>&hl=es;z=14&output=embed"></iframe></td>
                </div>
                <div class="form-group">
                    <label>Residential's Fullname</label>
                    <input type="text" class="form-control" value="<?php  echo $row['homeowner'];?>" name="homeowner" id="homeowner" >
                </div>
                  <div class="form-group">
                    <label>Residential's Address</label>
                    <input type="text" class="form-control" value="<?php  echo $row['addresss'];?>" name="addresss" id="addresss">
                </div>
                  <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="number" class="form-control" value="<?php  echo $row['mobilenumber'];?>"name="mobilenumber" id="mobilenumber">
                </div>
                
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                <div class="form-group">
                    <label>Gender</label>
                    <input type="text" class="form-control" value="<?php  echo $row['gender'];?>" name="gender" id="gender">
                </div>
                  <!-- /.form-group -->
                  
                <div class="form-group">
                    <label>House Number</label>
                    <input type="text" class="form-control" value="<?php  echo $row['apartment_number'];?>" disabled>
                  </div>
                  <div class="form-group">
                    <label>Street</label>
                    <input type="text" value="<?php  echo $row['building_number'];?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <label>House and Lot Status</label>
                    <select class="form-control select2" name="apartmentstatus" id="apartmentstatus" style="width: 100%;" required>
                      <option selected="<?php  echo $row['apartment_status'];?>"><?php  echo $row['apartment_status'];?></option>
                      <option value="Owned">Owned</option>
                      <option value="Empty">Empty</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>

            <?php }?>
              
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Make Changes</button>
            </div>
          </div>
          </form>
      
      <!-- /Form -->
        
    
	  
      <!-- Main row -->
      
      <!-- / Main row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php include 'includes/footer.php'?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Create the tabs -->
    
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->

      <div class="tab-pane" id="control-sidebar-home-tab">
       
      </div>
 
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php }?>