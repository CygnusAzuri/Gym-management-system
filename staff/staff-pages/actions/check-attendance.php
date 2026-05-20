<?php
session_start();

// Validate session first
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../index.php");
    exit();
}

// Use correct path for dbcon.php (relative to this file)
require_once('../../dbcon.php'); // Changed from '../dbcon.php'

// Debug connection
if(!isset($con) || !$con) {
    die("Database connection failed");
}

if(isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    
    try {
        // Check existing attendance
        $check_query = "SELECT * FROM attendance WHERE user_id = ? AND curr_date = ?";
        $check_stmt = $con->prepare($check_query);
        $check_stmt->bind_param("is", $user_id, $current_date);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if($result->num_rows > 0) {
            $_SESSION['error'] = "Member already checked in today";
        } else {
            // Insert new record
            $insert_query = "INSERT INTO attendance (user_id, curr_date, curr_time) VALUES (?, ?, ?)";
            $insert_stmt = $con->prepare($insert_query);
            $insert_stmt->bind_param("iss", $user_id, $current_date, $current_time);
            
            if($insert_stmt->execute()) {
                $_SESSION['success'] = "Check-in successful";
            } else {
                $_SESSION['error'] = "Database error: ".$insert_stmt->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    } catch(Exception $e) {
        $_SESSION['error'] = "System error: ".$e->getMessage();
    }
}

header("Location: ../../staff-pages/attendance.php");
exit();
?>