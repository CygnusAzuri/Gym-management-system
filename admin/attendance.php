<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../index.php');    
    exit();
}

include 'dbcon.php';
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');
$current_time = date('h:i A');
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
<link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
<link href="../font-awesome/css/all.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page="attendance"; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
      <a href="index.php" title="Go to Home" class="tip-bottom">
        <i class="fas fa-home"></i> Home
      </a> 
      <a href="attendance.php" class="current">Manage Attendance</a> 
    </div>
    <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class='widget-box'>
          <div class='widget-title'> 
            <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'> 
            <table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Choosen Service</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $qry = "SELECT * FROM members WHERE status = 'Active'";
                $result = mysqli_query($conn, $qry);
                $cnt = 1;
                
                while($row = mysqli_fetch_assoc($result)): 
                    $user_id = $row['user_id'];
                    
                    // Check attendance for today
                    $attendance_qry = "SELECT * FROM attendance 
                                     WHERE user_id = '$user_id' 
                                     AND curr_date = '$current_date'";
                    $attendance_result = mysqli_query($conn, $attendance_qry);
                    $attendance_data = mysqli_fetch_assoc($attendance_result);
                ?>
                <tr>
                  <td><div class='text-center'><?= $cnt ?></div></td>
                  <td><div class='text-center'><?= htmlspecialchars($row['fullname']) ?></div></td>
                  <td><div class='text-center'><?= htmlspecialchars($row['contact']) ?></div></td>
                  <td><div class='text-center'><?= htmlspecialchars($row['services']) ?></div></td>
                  
                  <td>
                    <div class='text-center'>
                      <?php if($attendance_data): ?>
                        <span class="label label-success">
                          Checked In: <?= $attendance_data['curr_time'] ?>
                        </span>
                      <?php else: ?>
                        <span class="label label-important">Not Checked In</span>
                      <?php endif; ?>
                    </div>
                  </td>
                  
                  <td>
                    <div class='text-center'>
                      <?php if($attendance_data): ?>
                        <a href='actions/delete-attendance.php?id=<?= $user_id ?>'>
                          <button class='btn btn-danger'>
                            Check Out <i class='fas fa-clock'></i>
                          </button>
                        </a>
                      <?php else: ?>
                        <a href='actions/check-attendance.php?id=<?= $user_id ?>'>
                          <button class='btn btn-info'>
                            Check In <i class='fas fa-map-marker-alt'></i>
                          </button>
                        </a>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
                <?php 
                $cnt++;
                endwhile; 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 
    <?= date("Y") ?> &copy; Developed By Sakshi Jha
  </div>
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
</body>
</html>