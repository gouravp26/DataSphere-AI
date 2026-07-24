<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}
if ($_SESSION['user_role'] !== 'admin') {

    $_SESSION['error'] = "Access denied.";

    header("Location: ../../dashboard/index.php");
    exit();

}

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if(!$user){
    header("Location: index.php");
    exit();
}

$pageTitle = "Edit User | " . APP_NAME;
include "../../components/header.php";
?>

<div class="dashboard">



    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>

                <div class="card-body">

                    <form action="update.php" method="POST">

                        <input type="hidden" name="id" value="<?= $user['id'] ?>">

                        <div class="mb-3">

                            <label>Full Name</label>

                            <input type="text" name="name" class="form-control"
                                value="<?= htmlspecialchars($user['name']) ?>" required>

                        </div>

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($user['email']) ?>" required>

                        </div>

                        <div class="mb-3">

                            <label>New Password</label>

                            <input type="password" name="password" class="form-control">

                            <small>
                                Leave blank to keep old password
                            </small>

                        </div>

                        <div class="mb-3">

                            <label>Role</label>

                            <select name="role" class="form-select">

                                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>

                                    Admin

                                </option>

                                <option value="user" <?= $user['role']=='user'?'selected':'' ?>>

                                    User

                                </option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label>Status</label>

                            <select name="status" class="form-select">

                                <option value="active" <?= $user['status']=='active'?'selected':'' ?>>

                                    Active

                                </option>

                                <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>

                                    Inactive

                                </option>

                            </select>

                        </div>

                        <button class="btn btn-primary">

                            Update User

                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include "../../components/footer.php"; ?>