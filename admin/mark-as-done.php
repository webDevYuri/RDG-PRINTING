<?php
session_start();

include '../backend/connection/db_conn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

function logError($message) {
    file_put_contents('../logs/debug.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

logError("Script started");
logError("POST data: " . json_encode($_POST));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logError("POST request received");
    
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = (int)$_POST['id'];
        logError("Processing job ID: $id");
        
        if (!$conn) {
            logError("Database connection failed");
            $_SESSION['error_message'] = "Database connection failed";
        } else {
            $query = "UPDATE uploads SET isActive = 0 WHERE id = $id";
            logError("Executing query: $query");
            
            if ($conn->query($query) === TRUE) {
                logError("Query successful. Affected rows: " . $conn->affected_rows);
                if ($conn->affected_rows > 0) {
                    $_SESSION['success_message'] = "Job marked as done successfully!";
                    logError("Success message set");
                } else {
                    $_SESSION['error_message'] = "No changes made. Record may not exist or is already marked as done.";
                    logError("No changes made");
                }
            } else {
                $error = $conn->error;
                logError("Query error: $error");
                $_SESSION['error_message'] = "Error updating record: $error";
            }
        }
    } else {
        logError("ID parameter not set or not numeric");
        $_SESSION['error_message'] = "Missing or invalid job ID";
    }
} else {
    logError("Not a POST request");
    $_SESSION['error_message'] = "Invalid request method";
}

session_write_close();

logError("Redirecting to job-request.php");
header("Location: job-request.php");
exit;
?>