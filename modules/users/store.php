<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if ($_SESSION['user_role'] !== 'admin') {

    $_SESSION['error'] = "Access denied.";

    header("Location: ../../dashboard/index.php");
    exit();

}

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: index.php");
    exit();
}

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];
$status = $_POST['status'];


if (
    empty($full_name) ||
    empty($email) ||
    empty($password)
) {

    $_SESSION['error'] = "All fields are required.";

    header("Location: create.php");

    exit();

}


$check = $conn->prepare("
SELECT id
FROM users
WHERE email = ?
");

$check->execute([$email]);

if($check->fetch()){

    $_SESSION['error'] = "Email already exists.";

    header("Location: create.php");
    exit();

}

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $conn->prepare("
INSERT INTO users
(
name,
email,
password,
role,
status
)
VALUES
(
?,?,?,?,?
)
");

$stmt->execute([
    $full_name,
    $email,
    $passwordHash,
    $role,
    $status
]);

$_SESSION['success'] =
"User created successfully.";

header("Location: index.php");
exit();