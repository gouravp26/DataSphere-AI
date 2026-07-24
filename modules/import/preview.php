<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (
    !isset($_SESSION['import_file']) ||
    !isset($_SESSION['import_dataset_name'])
) {
    header("Location: index.php");
    exit();
}

$filePath = __DIR__ . "/temp/" . $_SESSION['import_file'];

if (!file_exists($filePath)) {
    $_SESSION['error'] = "Uploaded file not found.";
    header("Location: index.php");
    exit();
}

$handle = fopen($filePath, "r");

if (!$handle) {
    die("Unable to open CSV file.");
}

/* Read Header */
$headers = fgetcsv($handle);

if ($headers === false) {

    fclose($handle);

    $_SESSION['error'] = "CSV file is empty.";

    header("Location: index.php");

    exit();
}

$trimmedHeaders = array_map('trim', $headers);

if (count($trimmedHeaders) !== count(array_unique($trimmedHeaders))) {

    fclose($handle);

    $_SESSION['error'] = "Duplicate column names found.";

    header("Location: index.php");

    exit();
}

foreach ($headers as $header) {

    if (trim($header) === "") {

        fclose($handle);

        $_SESSION['error'] = "CSV contains empty column names.";

        header("Location: index.php");

        exit();

    }

}

$previewRows = [];
$totalRows = 0;

/* Read remaining rows */
while (($row = fgetcsv($handle)) !== false) {

    $totalRows++;

    if (count($previewRows) < 10) {
        $previewRows[] = $row;
    }
}

fclose($handle);

$pageTitle = "CSV Preview | " . APP_NAME;

include "../../components/header.php";
?>

<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <div class="card shadow">

                <div class="card-header">

                    <h3>📥 Import Preview</h3>

                </div>

                <div class="card-body">

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <strong>Dataset:</strong>

                            <?= htmlspecialchars($_SESSION['import_dataset_name']) ?>

                        </div>

                        <div class="col-md-6">

                            <strong>Original File:</strong>

                            <?= htmlspecialchars($_SESSION['original_file_name']) ?>

                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <strong>Total Rows:</strong>

                            <?= $totalRows ?>

                        </div>

                        <div class="col-md-6">

                            <strong>Total Columns:</strong>

                            <?= count($headers) ?>

                        </div>

                    </div>

                    <hr>

                    <h5>Detected Columns</h5>

                    <div class="mb-4">

                        <?php foreach($headers as $header): ?>

                        <span class="badge bg-primary me-2 mb-2">

                            <?= htmlspecialchars($header) ?>

                        </span>

                        <?php endforeach; ?>

                    </div>

                    <h5>Preview (First 10 Rows)</h5>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead>

                                <tr>

                                    <?php foreach($headers as $header): ?>

                                    <th><?= htmlspecialchars($header) ?></th>

                                    <?php endforeach; ?>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach($previewRows as $row): ?>

                                <tr>

                                    <?php foreach($row as $value): ?>

                                    <td><?= htmlspecialchars($value) ?></td>

                                    <?php endforeach; ?>

                                </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-4 d-flex justify-content-between">

                        <a href="index.php" class="btn btn-secondary">

                            ⬅ Back

                        </a>

                        <form action="process.php" method="POST">

                            <button class="btn btn-success">

                                🚀 Import Dataset

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>