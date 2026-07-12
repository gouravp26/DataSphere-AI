<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: " . BASE_URL . "/modules/datasets/index.php");
    exit();
}

$id = $_POST['id'];
$name = trim($_POST['name']);
$description = trim($_POST['description']);
$icon = $_POST['icon'];
$color = $_POST['color'];

$sql = "UPDATE datasets
        SET name = ?, description = ?, icon = ?, color = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $name,
    $description,
    $icon,
    $color,
    $id
]);

header("Location: " . BASE_URL . "/modules/datasets/index.php");
exit();