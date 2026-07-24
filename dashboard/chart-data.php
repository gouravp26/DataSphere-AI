<?php

require_once "../config/database.php";
require_once "../config/session.php";

header('Content-Type: application/json');

$data = [];


/*
|--------------------------------------------------------------------------
| Records Growth Data
|--------------------------------------------------------------------------
*/

$stmt = $conn->query("
    SELECT 
        DATE(created_at) AS date,
        COUNT(*) AS total
    FROM records
    GROUP BY DATE(created_at)
    ORDER BY date ASC
");


$records = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $records[] = [
        "date" => $row['date'],
        "total" => $row['total']
    ];

}


$data['records_growth'] = $records;



/*
|--------------------------------------------------------------------------
| Dataset Distribution
|--------------------------------------------------------------------------
*/

$stmt = $conn->query("
    SELECT 
        datasets.name,
        COUNT(records.id) AS total
    FROM datasets
    LEFT JOIN records 
    ON datasets.id = records.dataset_id
    GROUP BY datasets.id
");


$datasets = [];


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $datasets[] = [
        "name" => $row['name'],
        "total" => $row['total']
    ];

}


$data['dataset_distribution'] = $datasets;



echo json_encode($data);

?>