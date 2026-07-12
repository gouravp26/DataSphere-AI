<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../../auth/login.php");
    exit();
}

$dataset_id = (int)$_GET['dataset_id'];

// Dataset
$stmt = $conn->prepare("SELECT * FROM datasets WHERE id=?");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

// Fields
$stmt = $conn->prepare("
SELECT *
FROM dataset_fields
WHERE dataset_id=?
ORDER BY field_order,id
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

            <h2>

                <?= htmlspecialchars($dataset['name']) ?>

            </h2>

            <p>

                Add New Record

            </p>

            <form action="store.php" method="POST">

                <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                <?php foreach($fields as $field): ?>

                <div class="mb-3">

                    <label>

                        <?= htmlspecialchars($field['field_name']) ?>

                    </label>

                    <?php if($field['field_type']=="text"): ?>

                    <input type="text" name="field_<?= $field['id'] ?>" class="form-control"
                        <?= $field['is_required'] ? "required" : "" ?>>

                    <?php endif; ?>

                    <?php if($field['field_type']=="number"): ?>

                    <input type="number" name="field_<?= $field['id'] ?>" class="form-control"
                        <?= $field['is_required'] ? "required" : "" ?>>

                    <?php endif; ?>

                    <?php if($field['field_type']=="date"): ?>

                    <input type="date" name="field_<?= $field['id'] ?>" class="form-control"
                        <?= $field['is_required'] ? "required" : "" ?>>

                    <?php endif; ?>

                    <?php if($field['field_type']=="email"): ?>

                    <input type="email" name="field_<?= $field['id'] ?>" class="form-control"
                        <?= $field['is_required'] ? "required" : "" ?>>

                    <?php endif; ?>

                    <?php if($field['field_type']=="textarea"): ?>

                    <textarea name="field_<?= $field['id'] ?>" class="form-control"
                        <?= $field['is_required'] ? "required" : "" ?>></textarea>

                    <?php endif; ?>

                </div>

                <?php endforeach; ?>

                <button class="btn btn-primary">

                    Save Record

                </button>

            </form>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>