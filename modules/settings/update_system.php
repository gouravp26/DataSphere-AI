<?php

require_once "../../config/session.php";

$data = [

    "site_name" => $_POST['site_name'],

    "records_per_page" => (int)$_POST['records_per_page']

];

file_put_contents(
    "settings.json",
    json_encode($data, JSON_PRETTY_PRINT)
);

$_SESSION['success'] = "Settings saved.";

header("Location:index.php");
exit();