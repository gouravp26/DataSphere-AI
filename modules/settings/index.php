<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "../../config/constants.php";

$settings=[];

if(file_exists("settings.json")){

$settings=json_decode(

file_get_contents("settings.json"),

true

);

}
$settings = array_merge([
    "site_name" => "DataSphere AI",
    "records_per_page" => 10
], $settings ?? []);


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$stmt = $conn->prepare("
SELECT *
FROM users
WHERE id=?
");

$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

include "../../components/header.php";
?>

<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <?php include "../../components/alerts.php"; ?>

            <h2 class="mb-4">⚙ Settings</h2>
            <div class="card shadow mb-4">

                <div class="card-body">

                    <h4>Account Information</h4>

                    <div class="row">

                        <div class="col-md-3">

                            <strong>User ID</strong><br>

                            <?= $user['id'] ?>

                        </div>

                        <div class="col-md-3">

                            <strong>Email</strong><br>

                            <?= htmlspecialchars($user['email']) ?>

                        </div>

                        <div class="col-md-3">

                            <strong>Role</strong><br>

                            <?= ucfirst($user['role']) ?>

                        </div>

                        <div class="col-md-3">

                            <strong>Status</strong><br>

                            <span class="badge bg-success">

                                <?= ucfirst($user['status']) ?>

                            </span>

                        </div>

                        <div class="col-md-3">

                            <strong>Member Since</strong>><br>

                            <?= date("d M Y",strtotime($user['created_at'])) ?>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card shadow mb-4">

                <div class="card-body">

                    <h4>Profile</h4>

                    <form action="update_profile.php" method="POST">

                        <div class="mb-3">

                            <label>Name</label>

                            <input type="text" name="name" class="form-control"
                                value="<?= htmlspecialchars($user['name']) ?>" required>

                        </div>

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($user['email']) ?>" required>

                        </div>

                        <div class="mb-3">

                            <label>Role</label>

                            <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" readonly>

                        </div>

                        <button class="btn btn-primary">

                            <i class="bi bi-person-check"></i>

                            Save Profile

                        </button>

                    </form>

                </div>

            </div>
            <div class="card shadow mb-4">

                <div class="card-body">

                    <h4>Change Password</h4>

                    <form action="change_password.php" method="POST">

                        <div class="mb-3">

                            <label>Current Password</label>

                            <input type="password" name="current_password" class="form-control" required>

                        </div>

                        <div class="mb-3">

                            <label>New Password</label>

                            <input type="password" name="new_password" class="form-control" required>

                        </div>

                        <div class="mb-3">

                            <label>Confirm Password</label>

                            <input type="password" name="confirm_password" class="form-control" required>

                        </div>

                        <button class="btn btn-success">

                            Change Password

                        </button>

                    </form>

                </div>

            </div>
            <div class="card shadow mb-4">
                <div class="card-body">

                    <h4>System</h4>

                    <form action="update_system.php" method="POST">

                        <div class="row">

                            <div class="col-md-6">

                                <label>Site Name</label>

                                <input class="form-control" name="site_name"
                                    value="<?= htmlspecialchars($settings['site_name']) ?>">

                            </div>

                            <div class="col-md-6">

                                <label>Records Per Page</label>

                                <select class="form-select" name="records_per_page">

                                    <?php foreach([10,25,50,100] as $limit): ?>

                                    <option value="<?= $limit ?>"
                                        <?= $settings['records_per_page'] == $limit ? "selected" : "" ?>>
                                        <?= $limit ?>
                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <button class="btn btn-dark mt-3">

                            <i class="bi bi-gear"></i>

                            Save Settings

                        </button>

                    </form>

                </div>
            </div>
            <div class="card shadow">

                <div class="card-body">

                    <h4>Logo</h4>

                    <form action="upload_logo.php" method="POST" enctype="multipart/form-data">

                        <input type="file" name="logo" class="form-control mb-3">

                        <?php

$logo="../../assets/uploads/logo.png";

if(file_exists($logo)){

?>

                        <div class="text-center mb-3">
                            <img src="<?= $logo ?>" class="img-thumbnail" style="max-height:120px;">
                            <p class="text-muted mt-2">Current Logo</p>
                        </div>

                        <?php } ?>
                        <button class="btn btn-warning">
                            <i class="bi bi-upload"></i>

                            Upload Logo

                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include "../../components/footer.php"; ?>