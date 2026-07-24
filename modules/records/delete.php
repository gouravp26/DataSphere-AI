<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../config/activity_logger.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../../auth/login.php");
    exit();
}

$record_id = (int)$_GET['record_id'];
$dataset_id = (int)$_GET['dataset_id'];

$stmt = $conn->prepare("
DELETE FROM record_values
WHERE record_id=?
");

$stmt->execute([$record_id]);

$stmt = $conn->prepare("
DELETE FROM records
WHERE id=?
");

$stmt->execute([$record_id]);

logActivity(
    $conn,
    $_SESSION['user_id'],
    "DELETE",
    "Record",
    "Deleted Record #".$record_id
);

header("Location:index.php?dataset_id=".$dataset_id);
exit();