<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_GET['record_id']) || !isset($_GET['dataset_id'])) {
    header("Location: ../datasets/index.php");
    exit();
}

$record_id = (int)$_GET['record_id'];
$dataset_id = (int)$_GET['dataset_id'];

$stmt = $conn->prepare("
DELETE FROM records
WHERE id = ?
");

$stmt->execute([$record_id]);

header("Location: index.php?dataset_id=".$dataset_id);
exit();