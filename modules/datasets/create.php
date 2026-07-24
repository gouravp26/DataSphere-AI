<?php

require_once "../../config/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Dataset | DataSphere AI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

</head>


<body class="bg-light">


    <div class="container py-5">


        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">
                    <i class="bi bi-database-add"></i>
                    Create New Dataset
                </h4>

            </div>


            <div class="card-body">


                <form action="store.php" method="POST">


                    <div class="mb-3">

                        <label class="form-label">
                            Dataset Name
                        </label>

                        <input type="text" name="name" class="form-control" placeholder="Enter dataset name" required>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description" class="form-control" rows="4"
                            placeholder="Enter description"></textarea>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Icon
                        </label>

                        <input type="text" name="icon" class="form-control" value="bi-database"
                            placeholder="bi-database">

                        <small class="text-muted">
                            Use Bootstrap icon name
                        </small>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Color
                        </label>

                        <select name="color" class="form-select">

                            <option value="primary">Blue</option>

                            <option value="success">Green</option>

                            <option value="danger">Red</option>

                            <option value="warning">Yellow</option>

                            <option value="info">Cyan</option>

                            <option value="dark">Dark</option>

                        </select>

                    </div>



                    <div class="d-flex justify-content-between">


                        <a href="index.php" class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Back

                        </a>


                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-save"></i>
                            Create Dataset

                        </button>


                    </div>


                </form>


            </div>

        </div>


    </div>


</body>

</html>