<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$pageTitle = "Import CSV | " . APP_NAME;
include "../../components/header.php";
?>



<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <?php include "../../components/alerts.php"; ?>

            <div class="card shadow">

                <div class="card-header">

                    <h3>
                        <i class="bi bi-upload"></i>
                        Import CSV Dataset
                    </h3>

                </div>

                <div class="card-body">

                    <div class="alert alert-info">

                        <i class="bi bi-info-circle"></i>

                        Supported format:
                        <strong>.CSV</strong>

                        <br>

                        The first row must contain column names.

                    </div>

                    <form action="upload.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">

                            <label class="form-label">
                                Dataset Name
                            </label>

                            <input type="text" name="dataset_name" class="form-control" placeholder="Example: Students"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                CSV File

                            </label>

                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>

                        </div>

                        <button class="btn btn-primary">

                            <i class="bi bi-upload"></i>

                            Upload Dataset

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>