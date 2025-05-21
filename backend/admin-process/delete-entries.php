<?php
include '../connection/db_conn.php';

$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];

if (!empty($ids)) {
    $idsString = implode(',', array_map('intval', $ids)); 
    $query = "DELETE FROM uploads WHERE id IN ($idsString)";
    if ($conn->query($query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No IDs provided']);
}
