<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

$sql = "SELECT * FROM datasets ORDER BY created_at DESC";
$stmt = $conn->query($sql);
$datasets = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

?>
<?php include "../../components/header.php"; ?>


<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <h2 class="mb-4">Datasets</h2>

            <p>Create and manage your datasets.</p>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDatasetModal">

                <i class="bi bi-plus-circle"></i>
                Create Dataset

            </button>

            <hr class="my-4">

            <?php if(count($datasets) > 0): ?>

            <div class="row">

                <?php foreach($datasets as $dataset): ?>

                <div class="col-md-4 mb-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h5>

                                <i
                                    class="bi <?= htmlspecialchars($dataset['icon']) ?> text-<?= htmlspecialchars($dataset['color']) ?>"></i>

                                <?= htmlspecialchars($dataset['name']) ?>

                            </h5>

                            <p class="text-muted">

                                <?= htmlspecialchars($dataset['description']) ?>

                            </p>

                            <div class="d-flex justify-content-between">

                                <a href="../records/index.php?dataset_id=<?= $dataset['id'] ?>"
                                    class="btn btn-success btn-sm">

                                    Open

                                </a>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editDatasetModal<?= $dataset['id'] ?>">

                                    Edit

                                </button>

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteDatasetModal<?= $dataset['id'] ?>">

                                    Delete

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Edit Dataset Modal -->

                <div class="modal fade" id="editDatasetModal<?= $dataset['id'] ?>" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <form action="update.php" method="POST">

                                <input type="hidden" name="id" value="<?= $dataset['id'] ?>">

                                <div class="modal-header">

                                    <h5 class="modal-title">

                                        Edit Dataset

                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">

                                        <label>Dataset Name</label>

                                        <input type="text" name="name" class="form-control"
                                            value="<?= htmlspecialchars($dataset['name']) ?>" required>

                                    </div>

                                    <div class="mb-3">

                                        <label>Description</label>

                                        <textarea name="description"
                                            class="form-control"><?= htmlspecialchars($dataset['description']) ?></textarea>

                                    </div>

                                    <div class="mb-3">

                                        <label>Icon</label>

                                        <select name="icon" class="form-select">

                                            <?php
                            $icons = [
                                "bi-table" => "Table",
                                "bi-people" => "People",
                                "bi-box" => "Products",
                                "bi-building" => "Building",
                                "bi-folder" => "Folder"
                            ];

                            foreach($icons as $value => $label):
                            ?>

                                            <option value="<?= $value ?>"
                                                <?= $dataset['icon'] == $value ? 'selected' : '' ?>>

                                                <?= $label ?>

                                            </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                    <div class="mb-3">

                                        <label>Color</label>

                                        <select name="color" class="form-select">

                                            <?php
                            $colors = [
                                "primary",
                                "success",
                                "danger",
                                "warning",
                                "dark"
                            ];

                            foreach($colors as $c):
                            ?>

                                            <option value="<?= $c ?>" <?= $dataset['color'] == $c ? 'selected' : '' ?>>

                                                <?= ucfirst($c) ?>

                                            </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                        Cancel

                                    </button>

                                    <button type="submit" class="btn btn-primary">

                                        Save Changes

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <!-- Delete Dataset Modal -->

                <div class="modal fade" id="deleteDatasetModal<?= $dataset['id'] ?>" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <form action="delete.php" method="POST">

                                <input type="hidden" name="id" value="<?= $dataset['id'] ?>">

                                <div class="modal-header bg-danger text-white">

                                    <h5 class="modal-title">

                                        Delete Dataset

                                    </h5>

                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <p>

                                        Are you sure you want to delete

                                        <strong>

                                            <?= htmlspecialchars($dataset['name']) ?>

                                        </strong>?

                                    </p>

                                    <div class="alert alert-warning mb-0">

                                        ⚠ This action cannot be undone.

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                        Cancel

                                    </button>

                                    <button type="submit" class="btn btn-danger">

                                        Delete

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

            </div>

            <?php else: ?>

            <div class="alert alert-info">

                No datasets found.

                Click

                <strong>Create Dataset</strong>

                to create your first dataset.

            </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- Create Dataset Modal -->

<div class="modal fade" id="createDatasetModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="store.php" method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Create New Dataset
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Dataset Name
                        </label>

                        <input type="text" name="name" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description" class="form-control" rows="3">
</textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Icon
                        </label>

                        <select name="icon" class="form-select">

                            <option value="bi-table">
                                Table
                            </option>

                            <option value="bi-people">
                                People
                            </option>

                            <option value="bi-box">
                                Products
                            </option>

                            <option value="bi-building">
                                Building
                            </option>

                            <option value="bi-folder">
                                Folder
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Color
                        </label>

                        <select name="color" class="form-select">

                            <option value="primary">
                                Blue
                            </option>

                            <option value="success">
                                Green
                            </option>

                            <option value="danger">
                                Red
                            </option>

                            <option value="warning">
                                Yellow
                            </option>

                            <option value="dark">
                                Black
                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Create Dataset

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>