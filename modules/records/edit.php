<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$record_id = (int)$_GET['record_id'];

// Record
$stmt = $conn->prepare("
SELECT *
FROM records
WHERE id=?
");

$stmt->execute([$record_id]);

$record = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$record){
    die("Record not found.");
}

$dataset_id = $record['dataset_id'];

// Dataset
$stmt = $conn->prepare("
SELECT *
FROM datasets
WHERE id=?
");

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
                Edit Record - <?= htmlspecialchars($dataset['name']) ?>
            </h2>

            <p class="text-muted">
                Update the values below.
            </p>

            <form action="update.php" method="POST">

                <input type="hidden" name="record_id" value="<?= $record_id ?>">

                <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                <?php foreach($fields as $field): ?>

                <?php

$stmt = $conn->prepare("
SELECT value
FROM record_values
WHERE record_id=?
AND field_id=?
");

$stmt->execute([
$record_id,
$field['id']
]);

$value = $stmt->fetchColumn();

?>

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        <?= htmlspecialchars($field['field_label']) ?>

                    </label>
                    <?php if($field['field_type']=="text"): ?>

                    <input type="text" class="form-control" name="field_<?= $field['id'] ?>"
                        value="<?= htmlspecialchars($value) ?>" <?= $field['is_required'] ? 'required' : '' ?>>

                    <?php endif; ?>
                    <?php if($field['field_type']=="number"): ?>

                    <input type="number" class="form-control" name="field_<?= $field['id'] ?>"
                        value="<?= htmlspecialchars($value) ?>" <?= $field['is_required'] ? 'required' : '' ?>>

                    <?php endif; ?>
                    <?php if($field['field_type']=="date"): ?>

                    <input type="date" class="form-control" name="field_<?= $field['id'] ?>"
                        value="<?= htmlspecialchars($value) ?>" <?= $field['is_required'] ? 'required' : '' ?>>

                    <?php endif; ?>
                    <?php if($field['field_type']=="email"): ?>

                    <input type="email" class="form-control" name="field_<?= $field['id'] ?>"
                        value="<?= htmlspecialchars($value) ?>" <?= $field['is_required'] ? 'required' : '' ?>>

                    <?php endif; ?>
                    <?php if($field['field_type']=="textarea"): ?>

                    <textarea class="form-control" name="field_<?= $field['id'] ?>"
                        <?= $field['is_required'] ? 'required' : '' ?>><?= htmlspecialchars($value) ?></textarea>
                    <?php endif; ?>

                </div>

                <?php endforeach; ?>
                <a href="index.php?dataset_id=<?= $dataset_id ?>" class="btn btn-secondary">
                    Back
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </form>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>