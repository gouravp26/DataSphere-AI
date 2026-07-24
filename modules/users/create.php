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

include "../../components/header.php";

?>

<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <?php include "../../components/alerts.php"; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2>Add User</h2>

                    <p class="text-muted">
                        Create a new system user.
                    </p>

                </div>

                <a href="index.php" class="btn btn-secondary">

                    Back

                </a>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <form action="store.php" method="POST">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Full Name

                                </label>

                                <input type="text" name="full_name" class="form-control" required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Email

                                </label>

                                <input type="email" name="email" class="form-control" required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Password

                                </label>

                                <input type="password" name="password" class="form-control" required>

                            </div>

                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Role

                                </label>

                                <select name="role" class="form-select">

                                    <option value="user">

                                        User

                                    </option>

                                    <option value="admin">

                                        Admin

                                    </option>

                                </select>

                            </div>

                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Status

                                </label>

                                <select name="status" class="form-select">

                                    <option value="active">

                                        Active

                                    </option>

                                    <option value="inactive">

                                        Inactive

                                    </option>

                                </select>

                            </div>

                        </div>

                        <button class="btn btn-primary">

                            <i class="bi bi-check-circle"></i>

                            Save User

                        </button>

                        <a href="index.php" class="btn btn-outline-secondary">

                            Cancel

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>