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

$dataset_id = (int)$_GET['dataset_id'];

$stmt = $conn->prepare("SELECT * FROM datasets WHERE id = ?");
$stmt->execute([$dataset_id]);
$dataset = $stmt->fetch(PDO::FETCH_ASSOC);

// Get all fields for this dataset
$stmt = $conn->prepare("
SELECT *
FROM dataset_fields
WHERE dataset_id = ?
ORDER BY field_order ASC, id ASC
");

$stmt->execute([$dataset_id]);

$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
SELECT *
FROM records
WHERE dataset_id = ?
ORDER BY created_at DESC
");

$stmt->execute([$dataset_id]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../../components/header.php";
?>

<div class="dashboard">

    <?php include "../../components/sidebar.php"; ?>

    <div class="main">

        <?php include "../../components/navbar.php"; ?>

        <div class="content">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2>

                        <i
                            class="bi <?= htmlspecialchars($dataset['icon']) ?> text-<?= htmlspecialchars($dataset['color']) ?>"></i>

                        <?= htmlspecialchars($dataset['name']) ?>

                    </h2>

                    <p><?= htmlspecialchars($dataset['description']) ?></p>

                </div>

                <div>

                    <a href="../fields/index.php?dataset_id=<?= $dataset_id ?>" class="btn btn-outline-secondary">

                        Manage Fields

                    </a>

                    <a href="create.php?dataset_id=<?= $dataset_id ?>" class="btn btn-primary">

                        Add Record

                    </a>

                </div>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <?php if(count($records)>0): ?>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <?php foreach($fields as $field): ?>

                                <th>

                                    <?= htmlspecialchars($field['field_name']) ?>

                                </th>

                                <?php endforeach; ?>

                                <th width="150">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($records as $record): ?>

                            <tr>

                                <?php

foreach($fields as $field){

$stmt = $conn->prepare("
SELECT value
FROM record_values
WHERE record_id=?
AND field_id=?
");

$stmt->execute([
$record['id'],
$field['id']
]);

echo "<td>";

echo htmlspecialchars($stmt->fetchColumn());

echo "</td>";

}

?>

                                <td>

                                    <a href="edit.php?record_id=<?= $record['id'] ?>" class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                    <?php else: ?>

                    <div class="text-center py-5">

                        <h4>No Records Found</h4>

                        <p class="text-muted">

                            Click "Add Record" to create your first record.

                        </p>

                    </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>