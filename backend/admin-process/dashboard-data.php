<?php

include '../backend/connection/db_conn.php';

$query = "SELECT service, COUNT(*) as count FROM uploads GROUP BY service";
$result = $conn->query($query);

$serviceCounts = [
    'print' => 0,
    '2x2' => 0,
    'passport' => 0,
    '1x1' => 0,
];

while ($row = $result->fetch_assoc()) {
    $serviceCounts[$row['service']] = $row['count'];
}

$queryToday = "SELECT service, COUNT(*) as count FROM uploads WHERE DATE(created_at) = CURDATE() GROUP BY service";
$resultToday = $conn->query($queryToday);

$todayCounts = [
    'print' => 0,
    '2x2' => 0,
    'passport' => 0,
    '1x1' => 0,
];

while ($row = $resultToday->fetch_assoc()) {
    $todayCounts[$row['service']] = $row['count'];
}

$totalUploads = $conn->query("SELECT COUNT(*) as total FROM uploads")->fetch_assoc()['total'];
$totalFiles = $conn->query("SELECT COUNT(*) as total FROM upload_files")->fetch_assoc()['total'];

$queryTopCustomers = "SELECT name, COUNT(*) as count FROM uploads GROUP BY name ORDER BY count DESC LIMIT 5";
$resultTopCustomers = $conn->query($queryTopCustomers);

$topCustomers = [];
while ($row = $resultTopCustomers->fetch_assoc()) {
    $topCustomers[] = ['name' => $row['name'], 'count' => $row['count']];
}
