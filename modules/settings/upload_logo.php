<?php

require_once "../../config/session.php";

if (!empty($_FILES['logo']['tmp_name'])) {

    move_uploaded_file(

        $_FILES['logo']['tmp_name'],

        "../../assets/uploads/logo.png"

    );

}

$_SESSION['success'] = "Logo uploaded.";

header("Location:index.php");
exit();

$stmt=$conn->prepare("
INSERT INTO activity_logs
(user_id,action,description)
VALUES(?,?,?)
");

$stmt->execute([

$_SESSION['user_id'],

"Settings",

"Uploaded new logo"

]);