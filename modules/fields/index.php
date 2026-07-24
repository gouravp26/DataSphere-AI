<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_GET['dataset_id'])) {
    header("Location: ../datasets/index.php");
    exit();
}

$dataset_id = (int) $_GET['dataset_id'];

// Get dataset information
$stmt = $conn->prepare("SELECT * FROM datasets WHERE id = ?");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataset) {
    die("Dataset not found.");
}

// Get all fields
$stmt = $conn->prepare("
    SELECT *
    FROM dataset_fields
    WHERE dataset_id = ?
    ORDER BY field_order ASC, id ASC
");
$stmt->execute([$dataset_id]);
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

                    <h2>

                        <i
                            class="bi <?= htmlspecialchars($dataset['icon']) ?> text-<?= htmlspecialchars($dataset['color']) ?>"></i>

                        <?= htmlspecialchars($dataset['name']) ?>

                    </h2>

                    <p class="text-muted">

                        <?= htmlspecialchars($dataset['description']) ?>

                    </p>

                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFieldModal">

                    <i class="bi bi-plus-circle"></i>

                    Add New Field

                </button>

            </div>
            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Field Name</th>

                                <th>Type</th>

                                <th>Required</th>

                                <th width="170">Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if(count($fields) > 0): ?>

                            <?php foreach($fields as $field): ?>

                            <tr>

                                <td>

                                    <?= htmlspecialchars($field['field_name']) ?>

                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        <?= ucfirst($field['field_type']) ?>

                                    </span>

                                </td>

                                <td>

                                    <?= $field['is_required'] ? "✅ Yes" : "❌ No" ?>

                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm editFieldBtn" data-id="<?= $field['id'] ?>"
                                        data-name="<?= htmlspecialchars($field['field_name']) ?>"
                                        data-label="<?= htmlspecialchars($field['field_label']) ?>"
                                        data-type="<?= $field['field_type'] ?>"
                                        data-required="<?= $field['is_required'] ?>" data-bs-toggle="modal"
                                        data-bs-target="#editFieldModal">

                                        Edit

                                    </button>
                                    <form action="delete.php" method="POST" class="d-inline">

                                        <input type="hidden" name="id" value="<?= $field['id'] ?>">

                                        <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this field?')">

                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                            <?php else: ?>

                            <tr>

                                <td colspan="4" class="text-center">

                                    No fields created yet.

                                </td>

                            </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>
            <div class="modal fade" id="addFieldModal">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form action="store.php" method="POST">

                            <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                            <div class="modal-header">

                                <h5>Add New Field</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="mb-3">

                                    <label>Field Name</label>

                                    <input type="text" name="field_name" class="form-control" required>

                                </div>

                                <div class="mb-3">
                                    <label>Field Label</label>
                                    <input type="text" name="field_label" class="form-control"
                                        placeholder="Student Name">
                                </div>

                                <div class="mb-3">

                                    <label>Field Type</label>

                                    <select name="field_type" class="form-select">

                                        <option value="text">Text</option>

                                        <option value="number">Number</option>

                                        <option value="date">Date</option>

                                        <option value="email">Email</option>

                                        <option value="textarea">Textarea</option>

                                    </select>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" name="is_required" value="1" class="form-check-input">

                                    <label class="form-check-label">

                                        Required Field

                                    </label>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">

                                    Save Field

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
            <div class="modal fade" id="editFieldModal">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form action="update.php" method="POST">

                            <input type="hidden" name="id" id="edit_id">

                            <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                            <div class="modal-header">

                                <h5>Edit Field</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="mb-3">

                                    <label>Field Name</label>

                                    <input type="text" id="edit_name" name="field_name" class="form-control" required>

                                </div>

                                <div class="mb-3">

                                    <label>Field Label</label>

                                    <input type="text" id="edit_label" name="field_label" class="form-control" required>

                                </div>

                                <div class="mb-3">

                                    <label>Field Type</label>

                                    <select id="edit_type" name="field_type" class="form-select">

                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="email">Email</option>
                                        <option value="date">Date</option>
                                        <option value="textarea">Textarea</option>

                                    </select>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" id="edit_required" name="is_required" value="1"
                                        class="form-check-input">

                                    <label class="form-check-label">

                                        Required Field

                                    </label>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button class="btn btn-primary">

                                    Update Field

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <script>
            document.querySelectorAll(".editFieldBtn").forEach(button => {

                button.addEventListener("click", function() {

                    document.getElementById("edit_id").value =
                        this.dataset.id;

                    document.getElementById("edit_name").value =
                        this.dataset.name;

                    document.getElementById("edit_label").value =
                        this.dataset.label;

                    document.getElementById("edit_type").value =
                        this.dataset.type;

                    document.getElementById("edit_required").checked =
                        this.dataset.required == 1;

                });

            });
            </script>
            <?php include "../../components/footer.php"; ?>