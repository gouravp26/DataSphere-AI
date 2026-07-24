<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../config/constants.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$pageTitle = "Reports | DataSphere AI";

// Statistics
$totalDatasets = $conn->query("SELECT COUNT(*) FROM datasets")->fetchColumn();
$totalRecords = $conn->query("SELECT COUNT(*) FROM records")->fetchColumn();
$totalFields = $conn->query("SELECT COUNT(*) FROM dataset_fields")->fetchColumn();
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Dataset statistics
$stmt = $conn->query("
SELECT
datasets.name,
COUNT(records.id) AS total_records
FROM datasets
LEFT JOIN records
ON datasets.id = records.dataset_id
GROUP BY datasets.id
ORDER BY total_records DESC
");

$datasets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recent Activity
$stmt = $conn->query("
SELECT
activity_logs.*,
users.name
FROM activity_logs
LEFT JOIN users
ON users.id = activity_logs.user_id
ORDER BY activity_logs.created_at DESC
LIMIT 10
");

$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../../components/header.php";
?>

<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">
            <div class="page-header">

                <h2>Reports</h2>

                <div>

                    <a href="../export/export_pdf.php?type=report" class="btn btn-danger">

                        PDF

                    </a>

                    <a href="../export/export_excel.php?type=report" class="btn btn-success">

                        Excel

                    </a>

                </div>

            </div>
            <div class="cards">

                <div class="card-box">

                    <div class="card-icon bg-primary">
                        <i class="bi bi-folder"></i>
                    </div>

                    <div>
                        <h3><?= $totalDatasets ?></h3>
                        <p>Datasets</p>
                    </div>

                </div>

                <div class="card-box">

                    <div class="card-icon bg-success">
                        <i class="bi bi-table"></i>
                    </div>

                    <div>
                        <h3><?= $totalRecords ?></h3>
                        <p>Records</p>
                    </div>

                </div>

                <div class="card-box">

                    <div class="card-icon bg-warning">
                        <i class="bi bi-list-columns"></i>
                    </div>

                    <div>
                        <h3><?= $totalFields ?></h3>
                        <p>Fields</p>
                    </div>

                </div>

                <div class="card-box">

                    <div class="card-icon bg-danger">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>
                        <h3><?= $totalUsers ?></h3>
                        <p>Users</p>
                    </div>

                </div>

            </div>
            <div class="card mt-4 shadow">

                <div class="card-body">

                    <h4>Dataset Statistics</h4>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Dataset</th>

                                <th>Total Records</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($datasets as $row): ?>

                            <tr>

                                <td><?= htmlspecialchars($row['name']) ?></td>

                                <td><?= $row['total_records'] ?></td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>
            <div class="card mt-4 shadow">

                <div class="card-body">

                    <h4>Recent Activity</h4>

                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th>User</th>

                                <th>Action</th>

                                <th>Description</th>

                                <th>Date</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($activities as $activity): ?>

                            <tr>

                                <td><?= htmlspecialchars($activity['name']) ?></td>

                                <td><?= htmlspecialchars($activity['action']) ?></td>

                                <td><?= htmlspecialchars($activity['description']) ?></td>

                                <td><?= $activity['created_at'] ?></td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>