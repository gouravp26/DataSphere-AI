<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../datasets/index.php");
    exit();
}

$dataset_id = (int)$_POST['dataset_id'];
$field_name = trim($_POST['field_name']);
$field_type = $_POST['field_type'];
$is_required = isset($_POST['is_required']) ? 1 : 0;

// Get next field order
$stmt = $conn->prepare("
    SELECT COALESCE(MAX(field_order),0)+1
    FROM dataset_fields
    WHERE dataset_id = ?
");

$stmt->execute([$dataset_id]);

$field_order = $stmt->fetchColumn();

$sql = "INSERT INTO dataset_fields
(dataset_id, field_name, field_type, is_required, field_order)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $dataset_id,
    $field_name,
    $field_type,
    $is_required,
    $field_order
]);

header("Location: index.php?dataset_id=".$dataset_id);
exit();