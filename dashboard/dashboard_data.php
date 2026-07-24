<?php

// Total Datasets
$totalDatasets = $conn->query("
SELECT COUNT(*) FROM datasets
")->fetchColumn();

// Total Fields
$totalFields = $conn->query("
SELECT COUNT(*) FROM dataset_fields
")->fetchColumn();

// Total Records
$totalRecords = $conn->query("
SELECT COUNT(*) FROM records
")->fetchColumn();

// Total Users
$totalUsers = $conn->query("
SELECT COUNT(*) FROM users
")->fetchColumn();

// Dataset chart

$stmt = $conn->query("
SELECT
    datasets.name,
    COUNT(records.id) AS total
FROM datasets
LEFT JOIN records
ON datasets.id = records.dataset_id
GROUP BY datasets.id
ORDER BY datasets.name
");

$chartLabels = [];
$chartData = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $chartLabels[] = $row['name'];
    $chartData[] = $row['total'];

}