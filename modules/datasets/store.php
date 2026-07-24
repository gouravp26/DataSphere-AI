<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../config/activity_logger.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}


$name = trim($_POST['name']);
$description = trim($_POST['description']);
$icon = $_POST['icon'] ?? 'bi-database';
$color = $_POST['color'] ?? 'primary';

$created_by = $_SESSION['user_id'];



$sql = "INSERT INTO datasets
(name, description, icon, color, created_by)
VALUES (?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);


$stmt->execute([
    $name,
    $description,
    $icon,
    $color,
    $created_by
]);



/* Activity Log */

if (function_exists('logActivity')) {

    logActivity(
        $conn,
        $_SESSION['user_id'],
        "CREATE",
        "Dataset",
        "Created dataset: " . $name
    );

}



header("Location: index.php");
exit();

?>