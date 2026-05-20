<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

include('../dbcon.php');
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');
$current_time = date('h:i A');

if(!isset($_GET['id'])) {
    $_SESSION['error'] = 'Invalid request';
    header("Location: ../attendance.php");
    exit();
}

$user_id = mysqli_real_escape_string($con, $_GET['id']);

// Check if already checked in today
$check_qry = "SELECT * FROM attendance WHERE user_id = ? AND curr_date = ?";
$stmt = $con->prepare($check_qry);
$stmt->bind_param("is", $user_id, $current_date);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $_SESSION['error'] = 'Member already checked in today';
    header("Location: ../attendance.php");
    exit();
}

// Record attendance
$insert_qry = "INSERT INTO attendance (user_id, curr_date, curr_time, present) VALUES (?, ?, ?, 1)";
$stmt = $con->prepare($insert_qry);
$stmt->bind_param("iss", $user_id, $current_date, $current_time);

if($stmt->execute()) {
    // Update attendance count
    $update_qry = "UPDATE members SET attendance_count = attendance_count + 1 WHERE user_id = ?";
    $stmt = $con->prepare($update_qry);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $_SESSION['success'] = "Attendance marked successfully";
} else {
    $_SESSION['error'] = "Error: " . $con->error;
}

header("Location: ../attendance.php");
exit();
?>