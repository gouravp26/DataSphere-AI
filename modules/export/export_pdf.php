<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../vendor/autoload.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}
if (isset($_GET['type']) && $_GET['type'] == "report") {

    $pdf = new FPDF('P', 'mm', 'A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 12, 'DataSphere AI Report', 0, 1, 'C');

    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(80,8,"Total Datasets");
    $pdf->Cell(30,8,$conn->query("SELECT COUNT(*) FROM datasets")->fetchColumn(),0,1);

    $pdf->Cell(80,8,"Total Records");
    $pdf->Cell(30,8,$conn->query("SELECT COUNT(*) FROM records")->fetchColumn(),0,1);

    $pdf->Cell(80,8,"Total Fields");
    $pdf->Cell(30,8,$conn->query("SELECT COUNT(*) FROM dataset_fields")->fetchColumn(),0,1);

    $pdf->Cell(80,8,"Total Users");
    $pdf->Cell(30,8,$conn->query("SELECT COUNT(*) FROM users")->fetchColumn(),0,1);

    $pdf->Ln(10);

    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(120,10,"Dataset");
    $pdf->Cell(40,10,"Records",0,1);

    $pdf->SetFont('Arial','',11);

    $stmt = $conn->query("
        SELECT
        datasets.name,
        COUNT(records.id) total
        FROM datasets
        LEFT JOIN records
        ON datasets.id = records.dataset_id
        GROUP BY datasets.id
    ");

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $pdf->Cell(120,8,$row['name']);
        $pdf->Cell(40,8,$row['total'],0,1);

    }

    $pdf->Output("D","DataSphere_Report.pdf");
    exit();
}

if (!isset($_GET['dataset_id'])) {
    die("Dataset ID missing.");
}

$dataset_id = (int)$_GET['dataset_id'];

// Dataset
$stmt = $conn->prepare("
SELECT *
FROM datasets
WHERE id=?
");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataset) {
    die("Dataset not found.");
}

// Fields
$stmt = $conn->prepare("
SELECT *
FROM dataset_fields
WHERE dataset_id=?
ORDER BY field_order,id
");
$stmt->execute([$dataset_id]);
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Records
$stmt = $conn->prepare("
SELECT id
FROM records
WHERE dataset_id=?
ORDER BY id
");
$stmt->execute([$dataset_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF('L','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,12,"DataSphere AI",0,1,'C');

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,$dataset['name']." Records",0,1,'C');

$pdf->Ln(5);

// Header
$pdf->SetFont('Arial','B',10);

$width = 260 / max(count($fields),1);

foreach($fields as $field){

    $pdf->Cell(
        $width,
        10,
        $field['field_name'],
        1,
        0,
        'C'
    );

}

$pdf->Ln();

// Data
$pdf->SetFont('Arial','',10);

foreach($records as $record){

    foreach($fields as $field){

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

        $value = $valueStmt->fetchColumn();

        $pdf->Cell(
            $width,
            8,
            substr($value,0,25),
            1
        );

    }

    $pdf->Ln();

}

$pdf->Ln(8);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(
    0,
    8,
    "Total Records : ".count($records),
    0,
    1
);

$pdf->Output(
    'D',
    preg_replace('/[^a-zA-Z0-9_-]/','_',$dataset['name']).'.pdf'
);

exit();