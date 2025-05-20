<?php
    include '../backend/connection/db_conn.php'; 

    $query = "SELECT COUNT(*) as active_count FROM uploads WHERE isActive = 1";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $activeCount = $row['active_count'];
        echo json_encode(['activeCount' => $activeCount]);
    } else {
        echo json_encode(['error' => "Error: " . $conn->error]);
    }
?>