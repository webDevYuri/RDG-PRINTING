<?php
include '../backend/connection/db_conn.php';

$type = $_POST['type'] ?? '';
$year = $_POST['year'] ?? '';
$month = $_POST['month'] ?? '';

$where = [];
$params = [];

if (!empty($year)) {
    $where[] = "YEAR(created_at) = ?";
    $params[] = $year;
}
if (!empty($month)) {
    $where[] = "MONTH(created_at) = ?";
    $params[] = $month;
}

$whereSQL = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

if ($type === 'print') {
    $stmt = $conn->prepare("SELECT service, COUNT(*) as count FROM uploads $whereSQL GROUP BY service");

    if (!empty($params)) {
        $stmt->bind_param(str_repeat('i', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $serviceCounts = [
        'print' => 0,
        '2x2' => 0,
        'passport' => 0,
        '1x1' => 0,
    ];

    while ($row = $result->fetch_assoc()) {
        $serviceCounts[$row['service']] = (int)$row['count'];
    }

    echo json_encode($serviceCounts);
}

elseif ($type === 'customer') {
    $stmt = $conn->prepare("SELECT name, COUNT(*) as count FROM uploads $whereSQL GROUP BY name ORDER BY count DESC LIMIT 5");

    if (!empty($params)) {
        $stmt->bind_param(str_repeat('i', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $topCustomers = [];
    while ($row = $result->fetch_assoc()) {
        $topCustomers[] = ['name' => $row['name'], 'count' => (int)$row['count']];
    }

    echo json_encode($topCustomers);
}
?>
