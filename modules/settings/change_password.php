<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

$stmt = $conn->prepare("
SELECT password
FROM users
WHERE id=?
");

$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($current, $user['password'])) {

    $_SESSION['error'] = "Current password is incorrect.";

    header("Location:index.php");

    exit();
}

if ($new != $confirm) {

    $_SESSION['error'] = "Passwords do not match.";

    header("Location:index.php");

    exit();
}

$password = password_hash($new, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
UPDATE users
SET password=?
WHERE id=?
");

$stmt->execute([
    $password,
    $_SESSION['user_id']
]);

$_SESSION['success'] = "Password changed successfully.";

header("Location:index.php");
exit();