<?php
session_start();

// Validate session
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../index.php");
    exit();
}

// Use correct path
require_once('../../dbcon.php');

// Verify connection
if(!isset($con) || !$con) {
    die("Database connection failed");
}

if(isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $current_date = date('Y-m-d');
    
    try {
        // Verify check-in exists
        $check_query = "SELECT * FROM attendance WHERE user_id = ? AND curr_date = ?";
        $check_stmt = $con->prepare($check_query);
        $check_stmt->bind_param("is", $user_id, $current_date);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if($result->num_rows == 0) {
            $_SESSION['error'] = "No check-in found for today";
        } else {
            // Delete record
            $delete_query = "DELETE FROM attendance WHERE user_id = ? AND curr_date = ?";
            $delete_stmt = $con->prepare($delete_query);
            $delete_stmt->bind_param("is", $user_id, $current_date);
            
            if($delete_stmt->execute()) {
                $_SESSION['success'] = "Check-out successful";
            } else {
                $_SESSION['error'] = "Database error: ".$delete_stmt->error;
            }
            $delete_stmt->close();
        }
        $check_stmt->close();
    } catch(Exception $e) {
        $_SESSION['error'] = "System error: ".$e->getMessage();
    }
}

header("Location: ../../staff-pages/attendance.php");
exit();
?>