<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">

    <div class="logo">
        <i class="bi bi-database-fill"></i>
        <span><?= APP_NAME ?></span>
    </div>

    <ul>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/dashboard/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/dashboard/index.php">
                <i class="bi bi-house"></i>
                Dashboard
            </a>
        </li>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/datasets/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/modules/datasets/index.php">
                <i class="bi bi-folder2-open"></i>
                Datasets
            </a>
        </li>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/records/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/modules/records/index.php">
                <i class="bi bi-table"></i>
                Records
            </a>
        </li>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/users/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/modules/users/index.php">
                <i class="bi bi-people"></i>
                Users
            </a>
        </li>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/reports/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/modules/reports/index.php">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Reports
            </a>
        </li>

        <li class="<?= strpos($_SERVER['REQUEST_URI'], '/settings/') !== false ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/modules/settings/index.php">
                <i class="bi bi-gear"></i>
                Settings
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/auth/logout.php" onclick="return confirm('Are you sure you want to logout?')">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/modules/import/index.php">
                <i class="bi bi-upload"></i>
                Import CSV
            </a>
        </li>

    </ul>

</div>