<?php
include '../config/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard | DataSphere AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="../assets/css/dashboard.css">

</head>

<body>

<div class="dashboard">

    <?php include "../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../components/navbar.php"; ?>

        <div class="content">

    <div class="page-header">

        <div>
            <h2>Welcome Back 👋</h2>
            <p>Here's what's happening today.</p>
        </div>

        <button class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add New
        </button>

    </div>

    <div class="cards">

        <div class="card-box">

            <div class="card-icon bg-primary">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>

                <h3>1250</h3>

                <p>Students</p>

            </div>

        </div>

        <div class="card-box">

            <div class="card-icon bg-success">
                <i class="bi bi-person-workspace"></i>
            </div>

            <div>

                <h3>85</h3>

                <p>Faculty</p>

            </div>

        </div>

        <div class="card-box">

            <div class="card-icon bg-warning">
                <i class="bi bi-building"></i>
            </div>

            <div>

                <h3>12</h3>

                <p>Departments</p>

            </div>

        </div>

        <div class="card-box">

            <div class="card-icon bg-danger">
                <i class="bi bi-book"></i>
            </div>

            <div>

                <h3>48</h3>

                <p>Courses</p>

            </div>

        </div>

    </div>
    
    <div class="dashboard-grid">

    <!-- Line Chart -->
    <div class="chart-card">

        <h4>Monthly Student Registrations</h4>

        <canvas id="studentChart"></canvas>

    </div>

    <!-- Pie Chart -->
    <div class="chart-card">

        <h4>Department Distribution</h4>

        <canvas id="departmentChart"></canvas>

    </div>

    <!-- Recent Activity -->
    <div class="activity-card">

        <h4>Recent Activity</h4>

        <ul>

            <li>✅ Student Rahul Sharma added</li>
            <li>📚 New Course Created</li>
            <li>👨‍🏫 Faculty Updated</li>
            <li>🏢 Department Added</li>
            <li>📄 Report Exported</li>

        </ul>

    </div>

    <!-- Quick Actions -->
    <div class="activity-card">

        <h4>Quick Actions</h4>

        <button class="btn btn-primary w-100 mb-2">Add Student</button>

        <button class="btn btn-success w-100 mb-2">Add Faculty</button>

        <button class="btn btn-warning w-100">Generate Report</button>

    </div>

</div>

</div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/dashboard.js"></script>

</body>

</html>