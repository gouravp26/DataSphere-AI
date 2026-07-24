<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Only admin can delete users
if ($_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Prevent deleting yourself
if ($id == $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot delete your own account.";
    header("Location: index.php");
    exit();
}

// Check if target user is an admin
$stmt = $conn->prepare("
    SELECT role
    FROM users
    WHERE id = ?
");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Prevent deleting the last admin
if ($user && $user['role'] === 'admin') {

    $_SESSION['error'] = "Administrators cannot be deleted.";

    header("Location: index.php");
    exit();

}

try {

    // Delete user
    $stmt = $conn->prepare("
        DELETE FROM users
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    // Log activity
    $stmt = $conn->prepare("
        INSERT INTO activity_logs
        (user_id, action, description)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        "Delete User",
        "Deleted user ID: " . $id
    ]);

    $_SESSION['success'] = "User deleted successfully.";

} catch (PDOException $e) {

    $_SESSION['error'] = "Unable to delete user.";

}

header("Location: index.php");
exit();