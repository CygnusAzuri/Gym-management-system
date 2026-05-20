<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

include('../dbcon.php');

if(!isset($_GET['id'])) {
    $_SESSION['error'] = 'Invalid request';
    header("Location: ../attendance.php");
    exit();
}

$user_id = mysqli_real_escape_string($con, $_GET['id']);
$current_date = date('Y-m-d');

// Delete attendance record
$delete_qry = "DELETE FROM attendance WHERE user_id = ? AND curr_date = ?";
$stmt = $con->prepare($delete_qry);
$stmt->bind_param("is", $user_id, $current_date);

if($stmt->execute()) {
    // Only decrement count if attendance was actually recorded today
    $check_qry = "SELECT * FROM attendance WHERE user_id = ? AND curr_date = ?";
    $stmt = $con->prepare($check_qry);
    $stmt->bind_param("is", $user_id, $current_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $update_qry = "UPDATE members SET attendance_count = GREATEST(0, attendance_count - 1) WHERE user_id = ?";
        $stmt = $con->prepare($update_qry);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
    
    $_SESSION['success'] = "Check out recorded successfully";
} else {
    $_SESSION['error'] = "Error: " . $con->error;
}

header("Location: ../attendance.php");
exit();
?>