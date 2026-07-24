<?php

require_once "../config/database.php";
require_once "../config/session.php";

$message = "";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $email = trim($_POST['email']);

    $stmt = $conn->prepare(
        "SELECT id FROM users WHERE email=?"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if($user){

        $token = bin2hex(random_bytes(32));

        $expiry = date(
            "Y-m-d H:i:s",
            strtotime("+30 minutes")
        );


        $update = $conn->prepare(
            "UPDATE users 
             SET reset_token=?, reset_expiry=?
             WHERE id=?"
        );


        $update->execute([
            $token,
            $expiry,
            $user['id']
        ]);


        $message =
        "Reset link: 
        reset_password.php?token=".$token;


    }else{

        $message="Email not found";

    }

}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="col-md-5 mx-auto">

            <div class="card p-4 shadow">

                <h3>Forgot Password</h3>

                <?php if($message): ?>

                <div class="alert alert-info">
                    <?= $message ?>
                </div>

                <?php endif; ?>


                <form method="POST">

                    <input type="email" name="email" class="form-control mb-3" placeholder="Enter email" required>


                    <button class="btn btn-primary w-100">
                        Generate Reset Link
                    </button>


                </form>

            </div>

        </div>

    </div>

</body>

</html>