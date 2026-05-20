<?php
require_once('../session.php');
//the isset function to check username is already logged in and stored on the session
if(!isset($_SESSION['user_id']) || trim($_SESSION['user_id']) == ''){
    header('location:../index.php');	
    exit();
}
if ($_SESSION['role'] !== 'staff') {
  header("Location: ../../index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/uniform.css" />
<link rel="stylesheet" href="../css/select2.css" />
<link rel="stylesheet" href="../css/matrix-style.css" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include '../includes/header.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page="attendance"; include '../includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="attendance.php" class="current">Manage Attendance</a> </div>
    <h1 class="text-center">Attendance List <i class="icon icon-calendar"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='icon-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'>
	  
	  <?php
      include "dbcon.php";
        
          echo"<table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Choosen Service</th>
                  <th>Action</th>
                </tr>
              </thead>";

              date_default_timezone_set('Asia/Kathmandu');
              $current_date = date('Y-m-d h:i A');
              $exp_date_time = explode(' ', $current_date);
              $todays_date = $exp_date_time['0'];
              $qry="SELECT * FROM members WHERE status = 'Active'";
              $result=mysqli_query($conn,$qry);
              $cnt = 1;
              
            while($row=mysqli_fetch_array($result)){ 
            
           echo '<tbody> 
                <tr>
                <td><div class="text-center">'.$cnt.'</div></td>
                <td><div class="text-center">'.$row['fullname'].'</div></td>
                <td><div class="text-center">'.$row['contact'].'</div></td>
                <td><div class="text-center">'.$row['services'].'</div></td>';

                $qry = "select * from attendance where curr_date = '$todays_date' AND user_id = '".$row['user_id']."'";
                $res = $conn->query($qry);
                $row_exist = mysqli_fetch_array($res);
                $curr_date = isset($row_exist['curr_date']) ? $row_exist['curr_date'] : '';
                
                if($curr_date == $todays_date){
                    echo '<td><div class="text-center"><span class="label label-inverse">'.$row_exist['curr_date'].' '.$row_exist['curr_time'].'</span></div>
                    <div class="text-center"><a href="actions/delete-attendance.php?id='.$row['user_id'].'"><button class="btn btn-danger">Check Out <i class="icon icon-time"></i></button> </a></div>
                    </td>';
                } else {
                    echo '<td><div class="text-center"><a href="actions/check-attendance.php?id='.$row['user_id'].'"><button class="btn btn-info">Check In <i class="icon icon-map-marker"></i></button> </a></div></td>';
                }

              echo '</tr></tbody>';
              $cnt++;
            }
            echo '</table>';
          ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By sakumal</div>
</div>

<style>
#footer {
  color: white;
}
</style>

<script src="../js/jquery.min.js"></script> 
<script src="../js/jquery.ui.custom.js"></script> 
<script src="../js/bootstrap.min.js"></script>  
<script src="../js/matrix.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 

</body>
</html>