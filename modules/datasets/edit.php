<?php

require_once "../../config/session.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM datasets WHERE id = ?");
$stmt->execute([$id]);

$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataset) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Edit Dataset | DataSphere AI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Dataset</h4>
            </div>


            <div class="card-body">

                <form action="update.php" method="POST">

                    <input type="hidden" name="id" value="<?= $dataset['id'] ?>">


                    <div class="mb-3">

                        <label class="form-label">
                            Dataset Name
                        </label>

                        <input type="text" name="name" class="form-control"
                            value="<?= htmlspecialchars($dataset['name']) ?>" required>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description" class="form-control"
                            rows="4"><?= htmlspecialchars($dataset['description']) ?></textarea>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Icon
                        </label>

                        <input type="text" name="icon" class="form-control"
                            value="<?= htmlspecialchars($dataset['icon']) ?>">

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Color
                        </label>

                        <select name="color" class="form-select">

                            <option value="primary" <?= $dataset['color']=="primary"?'selected':'' ?>>
                                Primary
                            </option>

                            <option value="success" <?= $dataset['color']=="success"?'selected':'' ?>>
                                Success
                            </option>

                            <option value="danger" <?= $dataset['color']=="danger"?'selected':'' ?>>
                                Danger
                            </option>

                            <option value="warning" <?= $dataset['color']=="warning"?'selected':'' ?>>
                                Warning
                            </option>

                            <option value="dark" <?= $dataset['color']=="dark"?'selected':'' ?>>
                                Dark
                            </option>

                        </select>

                    </div>



                    <div class="d-flex justify-content-between">

                        <a href="index.php" class="btn btn-secondary">
                            Back
                        </a>


                        <button class="btn btn-primary">
                            Update Dataset
                        </button>


                    </div>


                </form>

            </div>

        </div>

    </div>

</body>

</html>