<?php

require_once "../config/database.php";

$message="";


if(!isset($_GET['token'])){
    die("Invalid token");
}


$token=$_GET['token'];


$stmt=$conn->prepare(
"SELECT id FROM users 
WHERE reset_token=? 
AND reset_expiry > NOW()"
);


$stmt->execute([$token]);


$user=$stmt->fetch(PDO::FETCH_ASSOC);



if(!$user){

    die("Token expired or invalid");

}



if($_SERVER['REQUEST_METHOD']=="POST"){


$password=password_hash(
$_POST['password'],
PASSWORD_DEFAULT
);



$update=$conn->prepare(
"UPDATE users
SET password=?,
reset_token=NULL,
reset_expiry=NULL
WHERE id=?"
);



$update->execute([
$password,
$user['id']
]);


$message="Password changed successfully. Login now.";

}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">


    <div class="container mt-5">

        <div class="col-md-5 mx-auto">

            <div class="card shadow p-4">


                <h3>Reset Password</h3>


                <?php if($message): ?>

                <div class="alert alert-success">
                    <?= $message ?>
                </div>

                <?php endif; ?>


                <form method="POST">


                    <input type="password" name="password" class="form-control mb-3" placeholder="New password"
                        required>


                    <button class="btn btn-success w-100">
                        Update Password
                    </button>


                </form>


            </div>

        </div>

    </div>


</body>

</html>