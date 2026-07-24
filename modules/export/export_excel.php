<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (isset($_GET['type']) && $_GET['type'] == "report") {

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'DataSphere AI Report');
    $sheet->setCellValue('A3', 'Total Datasets');
    $sheet->setCellValue('B3', $conn->query("SELECT COUNT(*) FROM datasets")->fetchColumn());

    $sheet->setCellValue('A4', 'Total Records');
    $sheet->setCellValue('B4', $conn->query("SELECT COUNT(*) FROM records")->fetchColumn());

    $sheet->setCellValue('A5', 'Total Fields');
    $sheet->setCellValue('B5', $conn->query("SELECT COUNT(*) FROM dataset_fields")->fetchColumn());

    $sheet->setCellValue('A6', 'Total Users');
    $sheet->setCellValue('B6', $conn->query("SELECT COUNT(*) FROM users")->fetchColumn());

    $sheet->setCellValue('A8', 'Dataset');
    $sheet->setCellValue('B8', 'Records');

    $stmt = $conn->query("
        SELECT datasets.name,
        COUNT(records.id) total
        FROM datasets
        LEFT JOIN records
        ON datasets.id = records.dataset_id
        GROUP BY datasets.id
    ");

    $row = 9;

    while($data = $stmt->fetch(PDO::FETCH_ASSOC)){

        $sheet->setCellValue("A".$row, $data['name']);
        $sheet->setCellValue("B".$row, $data['total']);

        $row++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="DataSphere_Report.xlsx"');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save("php://output");
    exit();
}

if (!isset($_GET['dataset_id'])) {
    die("Dataset ID missing.");
}

$dataset_id = (int)$_GET['dataset_id'];

// Dataset
$stmt = $conn->prepare("SELECT * FROM datasets WHERE id = ?");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataset) {
    die("Dataset not found.");
}

// Fields
$stmt = $conn->prepare("
SELECT *
FROM dataset_fields
WHERE dataset_id = ?
ORDER BY field_order,id
");

$stmt->execute([$dataset_id]);
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Spreadsheet
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$column = 'A';

// Headers
foreach ($fields as $field) {

    $sheet->setCellValue($column . '1', $field['field_name']);

    $column++;
}

// Records
$stmt = $conn->prepare("
SELECT id
FROM records
WHERE dataset_id=?
ORDER BY id
");

$stmt->execute([$dataset_id]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$row = 2;

foreach ($records as $record) {

    $column = 'A';

    foreach ($fields as $field) {

        $valueStmt = $conn->prepare("
        SELECT value
        FROM record_values
        WHERE record_id=?
        AND field_id=?
        ");

        $valueStmt->execute([
            $record['id'],
            $field['id']
        ]);

        $sheet->setCellValue(
            $column . $row,
            $valueStmt->fetchColumn()
        );

        $column++;
    }

    $row++;
}

// Download
$filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $dataset['name']) . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

$writer->save("php://output");

exit();