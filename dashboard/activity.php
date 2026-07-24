<?php

require_once "../config/database.php";
require_once "../config/session.php";


header('Content-Type: application/json');


$stmt = $conn->query("
SELECT 
activity_logs.*,
users.username

FROM activity_logs

LEFT JOIN users

ON activity_logs.user_id = users.id

ORDER BY activity_logs.created_at DESC

LIMIT 10
");


$data = [];


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $data[] = $row;

}


echo json_encode($data);

?>