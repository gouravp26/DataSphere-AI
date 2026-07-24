<?php

require_once "../config/database.php";
require_once "../config/session.php";


$data = [];


/* Total Datasets */
$stmt = $conn->query(
    "SELECT COUNT(*) FROM datasets"
);

$data['datasets'] = $stmt->fetchColumn();



/* Total Records */
$stmt = $conn->query(
    "SELECT COUNT(*) FROM records"
);

$data['records'] = $stmt->fetchColumn();



/* Total Fields */
$stmt = $conn->query(
    "SELECT COUNT(*) FROM dataset_fields"
);

$data['fields'] = $stmt->fetchColumn();



/* Total Users */

$stmt = $conn->query(
    "SELECT COUNT(*) FROM users"
);

$data['users'] = $stmt->fetchColumn();



echo json_encode($data);

?>