<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if ($_SESSION['user_role'] !== 'admin') {

    $_SESSION['error'] = "Access denied.";

    header("Location: ../../dashboard/index.php");
    exit();

}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$id = (int)$_POST['id'];

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];
$status = $_POST['status'];

if (
    empty($name) ||
    empty($email) ||
    empty($role) ||
    empty($status)
) {

    $_SESSION['error'] = "Please fill all required fields.";

    header("Location: edit.php?id=".$id);

    exit();

}

$stmt = $conn->prepare("
SELECT id
FROM users
WHERE email = ?
AND id != ?
");

$stmt->execute([
    $email,
    $id
]);

if ($stmt->fetch()) {

    $_SESSION['error'] = "Email already exists.";

    header("Location: edit.php?id=".$id);

    exit();

}

try {

    if (!empty($password)) {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
        UPDATE users
        SET
            name=?,
            email=?,
            password=?,
            role=?,
            status=?
        WHERE id=?
        ");

        $stmt->execute([
            $name,
            $email,
            $passwordHash,
            $role,
            $status,
            $id
        ]);

    } else {

        $stmt = $conn->prepare("
        UPDATE users
        SET
            name=?,
            email=?,
            role=?,
            status=?
        WHERE id=?
        ");

        $stmt->execute([
            $name,
            $email,
            $role,
            $status,
            $id
        ]);

    }

    // Activity Log
    $stmt = $conn->prepare("
    INSERT INTO activity_logs
    (user_id, action, description)
    VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        "Update User",
        "Updated user: ".$name
    ]);

    $_SESSION['success'] = "User updated successfully.";

    header("Location: index.php");
    exit();

} catch (PDOException $e) {

    $_SESSION['error'] = "Unable to update user.";

    header("Location: edit.php?id=".$id);
    exit();

}