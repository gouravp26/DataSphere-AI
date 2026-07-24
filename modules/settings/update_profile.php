<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: index.php");
    exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);

$stmt = $conn->prepare("
UPDATE users
SET
name=?,
email=?
WHERE id=?
");

$stmt->execute([
    $name,
    $email,
    $_SESSION['user_id']
]);

$_SESSION['user_name'] = $name;
$_SESSION['success'] = "Profile updated successfully.";

header("Location: index.php");
exit();

$stmt=$conn->prepare("
INSERT INTO activity_logs
(user_id,action,description)
VALUES(?,?,?)
");

$stmt->execute([

$_SESSION['user_id'],

"Settings",

"Updated profile"

]);