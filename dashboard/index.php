<?php

require_once "../config/database.php";
require_once "../config/session.php";
require_once "../config/constants.php";
if (!isset($_SESSION['user_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

// Dashboard Statistics
$totalDatasets = $conn->query("SELECT COUNT(*) FROM datasets")->fetchColumn();

$totalRecords = $conn->query("SELECT COUNT(*) FROM records")->fetchColumn();

$totalFields = $conn->query("SELECT COUNT(*) FROM dataset_fields")->fetchColumn();

$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$stmt = $conn->query("
SELECT
activity_logs.*,
users.name
FROM activity_logs
LEFT JOIN users
ON users.id=activity_logs.user_id
ORDER BY activity_logs.created_at DESC
LIMIT 5
");

$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("
SELECT
datasets.name,
COUNT(records.id) total
FROM datasets
LEFT JOIN records
ON datasets.id=records.dataset_id
GROUP BY datasets.id
");

$chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

foreach($chartData as $row){

    $labels[] = $row['name'];

    $data[] = $row['total'];

}
if (empty($labels)) {
    $labels = ["No datasets"];
    $data = [0];
}


$pageTitle = "Dashboard | DataSphere AI";
include "../components/header.php";
?>
<div class="dashboard">

    <?php include "../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../components/navbar.php"; ?>

        <div class="content">

            <?php include "../components/alerts.php"; ?>

            <div class="page-header">

                <div>
                    <?php

$hour = date("H");

if($hour < 12){
    $greeting = "Good Morning";
}
elseif($hour < 17){
    $greeting = "Good Afternoon";
}
else{
    $greeting = "Good Evening";
}

?>

                    <h2>
                        <?= $greeting ?>,
                        <?= htmlspecialchars($_SESSION['user_name']) ?> 👋
                    </h2>
                    <p>Welcome to your DataSphere AI dashboard.</p>
                </div>

                <a href="../modules/datasets/index.php" class="btn btn-primary">
                    <i class="bi bi-folder-plus"></i>
                    Create Dataset
                </a>

            </div>

            <div class="cards">

                <div class="card-box">

                    <div class="card-icon bg-primary">
                        <i class="bi bi-folder2-open"></i>
                    </div>

                    <div>

                        <h3><?= $totalDatasets ?></h3>

                        <p>Datasets</p>

                    </div>

                </div>

                <div class="card-box">

                    <div class="card-icon bg-success">
                        <i class="bi bi-list-columns"></i>
                    </div>

                    <div>

                        <h3><?= $totalFields ?></h3>

                        <p>Fields</p>

                    </div>
                </div>

                <div class="card-box">

                    <div class="card-icon bg-warning">
                        <i class="bi bi-table"></i>
                    </div>

                    <div>

                        <h3><?= $totalRecords ?></h3>

                        <p>Records</p>

                    </div>

                </div>

                <div class="card-box">

                    <div class="card-icon bg-danger">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>

                        <h3><?= $totalUsers ?></h3>

                        <p>Users</p>

                    </div>

                </div>

            </div>

            <div class="dashboard-grid">

                <!-- Line Chart -->
                <div class="chart-card">

                    <h4>Records Overview</h4>

                    <canvas id="recordsChart"></canvas>

                </div>

                <!-- Pie Chart -->
                <div class="chart-card">

                    <h4>Datasets Overview</h4>

                    <canvas id="datasetChart"></canvas>

                </div>


                <div class="row mt-4">


                    <div class="col-md-12">


                        <div class="card shadow">


                            <div class="card-body">


                                <h5>
                                    🕒 Recent Activity
                                </h5>


                                <div id="activityList">

                                    <?php if (!empty($activities)): ?>

                                    <?php foreach ($activities as $activity): ?>

                                    <div class="border-bottom py-2">

                                        <strong><?= htmlspecialchars($activity['name'] ?? 'Unknown User') ?></strong><br>

                                        <span><?= htmlspecialchars($activity['action']) ?></span><br>

                                        <small class="text-muted">
                                            <?= htmlspecialchars($activity['created_at']) ?>
                                        </small>

                                    </div>

                                    <?php endforeach; ?>

                                    <?php else: ?>

                                    <p class="text-muted">No recent activity.</p>

                                    <?php endif; ?>

                                </div>


                            </div>


                        </div>


                    </div>


                </div>

                <!-- Quick Actions -->
                <div class="activity-card">

                    <h4>Quick Actions</h4>

                    <a href="../modules/datasets/index.php" class="btn btn-primary w-100 mb-2">
                        Create Dataset
                    </a>

                    <a href="../modules/datasets/index.php" class="btn btn-success w-100 mb-2">
                        Manage Records
                    </a>

                    <!-- <a href="../modules/reports/index.php" class="btn btn-warning w-100">

                        Export Reports

                    </a> -->

                </div>

            </div>

        </div>

    </div>

</div>



<script>
const chartLabels = <?= json_encode($labels) ?>;
const chartData = <?= json_encode($data) ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/dashboard.js"></script>

<?php include "../components/footer.php"; ?>