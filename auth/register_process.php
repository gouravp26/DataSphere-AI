<?php

require_once "../config/database.php";
require_once "../config/session.php";

if($_SERVER['REQUEST_METHOD'] !== "POST"){
    header("Location: register.php");
    exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$check = $conn->prepare(
    "SELECT id FROM users WHERE email=?"
);

$check->execute([$email]);


if($check->rowCount() > 0){

    $_SESSION['error'] = "Email already exists";
    header("Location: register.php");
    exit();

}


$stmt = $conn->prepare(
    "INSERT INTO users(name,email,password,role)
     VALUES(?,?,?,'user')"
);


$stmt->execute([
    $name,
    $email,
    $password
]);


$_SESSION['success']="Registration successful. Login now.";

header("Location: login.php");
exit();

?>