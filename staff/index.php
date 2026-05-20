<?php
session_start();
include('dbcon.php');

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: staff-pages/index.php');
    exit();
}

// Handle login attempt
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);
    
    // Use prepared statements instead of md5 (more secure)
    $query = $con->prepare("SELECT user_id, username FROM staffs WHERE username=? AND password=?");
    $hashed_password = md5($password); // Note: Recommend upgrading to password_hash()
    $query->bind_param("ss", $username, $hashed_password);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
        
        // Set session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = 'staff';
        $_SESSION['last_activity'] = time();
        
        header('Location: staff-pages/index.php');
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="loginbox">            
        <form id="loginform" method="POST" class="form-vertical" action="">
            <div class="control-group normal_text"><h3><img src="img/icontest3.png" alt="Logo" /></h3></div>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"></i></span>
                        <input type="text" name="user" placeholder="Username" required/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <input type="password" name="pass" placeholder="Password" required />
                    </div>
                </div>
            </div>
            <div class="form-actions center">
                <button type="submit" class="btn btn-block btn-large btn-warning" name="login">Staff Login</button>
            </div>
        </form>
        <div class="pull-left">
            <a href="../index.php"><h6>Admin Login</h6></a>
        </div>
        <div class="pull-right">
            <a href="../customer"><h6>Customer Login</h6></a>
        </div>
    </div>
    
    <script src="js/jquery.min.js"></script>  
    <script src="js/matrix.login.js"></script> 
    <script src="js/bootstrap.min.js"></script>
    <script src="js/matrix.js"></script>
</body>
</html>