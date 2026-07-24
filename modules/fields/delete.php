<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$id = $_POST['id'];
$dataset_id = $_POST['dataset_id'];

$stmt = $conn->prepare("DELETE FROM dataset_fields WHERE id=?");
$stmt->execute([$id]);

header("Location:index.php?dataset_id=".$dataset_id);
exit();