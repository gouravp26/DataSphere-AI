<?php

require_once "../config/database.php";
require_once "../config/session.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    $_SESSION['error'] = "Email not found.";
    header("Location: login.php");
    exit();

}

if (!password_verify($password, $user['password'])) {

    $_SESSION['error'] = "Incorrect password.";
    header("Location: login.php");
    exit();

}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['full_name'];
$_SESSION['user_role'] = $user['role'];

header("Location: ../dashboard/index.php");
exit();