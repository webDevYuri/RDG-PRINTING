<?php
session_start();
include '../backend/connection/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        header("Location: job-request.php?status=error&message=No ID provided");
        exit;
    }

    $id = (int)$_POST['id'];

    $query = "UPDATE uploads SET isNotified = 1 WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        $_SESSION['success_message'] = "Notification sent";
        header("Location: job-request.php");
    } else {
        header("Location: job-request.php");
    }
    exit;
}
?>