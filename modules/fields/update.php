<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$id = $_POST['id'];
$dataset_id = $_POST['dataset_id'];

$field_name = trim($_POST['field_name']);
$field_label = trim($_POST['field_label']);
$field_type = $_POST['field_type'];
$is_required = isset($_POST['is_required']) ? 1 : 0;

$stmt = $conn->prepare("
UPDATE dataset_fields
SET
field_name=?,
field_label=?,
field_type=?,
is_required=?
WHERE id=?
");

$stmt->execute([
    $field_name,
    $field_label,
    $field_type,
    $is_required,
    $id
]);

header("Location:index.php?dataset_id=".$dataset_id);
exit();