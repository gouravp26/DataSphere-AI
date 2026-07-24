<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (isset($_GET['type']) && $_GET['type'] == "report") {

    header("Content-Type:text/csv");
    header("Content-Disposition: attachment; filename=DataSphere_Report.csv");

    $output = fopen("php://output","w");

    fputcsv($output,["Metric","Value"]);

    fputcsv($output,[
        "Total Datasets",
        $conn->query("SELECT COUNT(*) FROM datasets")->fetchColumn()
    ]);

    fputcsv($output,[
        "Total Records",
        $conn->query("SELECT COUNT(*) FROM records")->fetchColumn()
    ]);

    fputcsv($output,[
        "Total Fields",
        $conn->query("SELECT COUNT(*) FROM dataset_fields")->fetchColumn()
    ]);

    fputcsv($output,[
        "Total Users",
        $conn->query("SELECT COUNT(*) FROM users")->fetchColumn()
    ]);

    fputcsv($output,[]);

    fputcsv($output,["Dataset","Records"]);

    $stmt = $conn->query("
        SELECT
        datasets.name,
        COUNT(records.id) total
        FROM datasets
        LEFT JOIN records
        ON datasets.id = records.dataset_id
        GROUP BY datasets.id
    ");

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        fputcsv($output,[
            $row['name'],
            $row['total']
        ]);

    }

    fclose($output);
    exit();
}

if (!isset($_GET['dataset_id'])) {
    die("Dataset ID missing.");
}

$dataset_id = (int) $_GET['dataset_id'];

// Get dataset
$stmt = $conn->prepare("
    SELECT *
    FROM datasets
    WHERE id = ?
");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataset) {
    die("Dataset not found.");
}

// Get dataset fields
$stmt = $conn->prepare("
    SELECT *
    FROM dataset_fields
    WHERE dataset_id = ?
    ORDER BY field_order ASC, id ASC
");
$stmt->execute([$dataset_id]);
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CSV Download Headers
$filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $dataset['name']) . "_" . date("Y-m-d") . ".csv";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen("php://output", "w");

// Header Row
$header = [];

foreach ($fields as $field) {
    $header[] = $field['field_name'];
}

fputcsv($output, $header);

// Fetch Records
$stmt = $conn->prepare("
    SELECT id
    FROM records
    WHERE dataset_id = ?
    ORDER BY id ASC
");

$stmt->execute([$dataset_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Write Records
foreach ($records as $record) {

    $row = [];

    foreach ($fields as $field) {

        $valueStmt = $conn->prepare("
            SELECT value
            FROM record_values
            WHERE record_id = ?
            AND field_id = ?
        ");

        $valueStmt->execute([
            $record['id'],
            $field['id']
        ]);

        $row[] = $valueStmt->fetchColumn();
    }

    fputcsv($output, $row);
}

fclose($output);
exit();