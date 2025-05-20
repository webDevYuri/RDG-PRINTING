<?php
session_start();
include '../backend/connection/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'markAsDone') {
    if (isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $query = "UPDATE uploads SET isActive = 0 WHERE id = $id"; 
        
        if ($conn->query($query) === TRUE) {
            $_SESSION['success_message'] = "Job marked as done"; 
            header("Location: job-request.php");
            exit;
        } else {
            header("Location: job-request.php");
            exit;
        }
    } else {
        header("Location: job-request.php");
        exit;
    }
}