<?php
include '../backend/connection/db_conn.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM upload_files WHERE upload_id = $id"; 
    $result = $conn->query($query);

    $attachments = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $attachments[] = $row;
        }
    }

    $queryInstructions = "SELECT job_instructions FROM uploads WHERE id = $id";
    $resultInstructions = $conn->query($queryInstructions);
    $jobInstructions = $resultInstructions ? $resultInstructions->fetch_assoc()['job_instructions'] : null;

    header('Content-Type: application/json');
    echo json_encode(['attachments' => $attachments, 'job_instructions' => $jobInstructions]);
    exit;
}

header('Content-Type: application/json');
echo json_encode(['error' => 'No ID provided']);
?>