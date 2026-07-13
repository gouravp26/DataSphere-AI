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
$search = trim($_GET['search'] ?? '');

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

if ($search != "") {

    $stmt = $conn->prepare("
    SELECT DISTINCT records.*
    FROM records
    JOIN record_values
        ON records.id = record_values.record_id
    WHERE records.dataset_id = ?
    AND record_values.value LIKE ?
    ORDER BY records.created_at DESC
    ");

    $stmt->execute([
        $dataset_id,
        "%".$search."%"
    ]);

} else {

    $stmt = $conn->prepare("
    SELECT *
    FROM records
    WHERE dataset_id = ?
    ORDER BY created_at DESC
    ");

    $stmt->execute([$dataset_id]);

}

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

                                <form method="GET" class="mb-3">

                                    <input type="hidden" name="dataset_id" value="<?= $dataset_id ?>">

                                    <div class="input-group">

                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search records..."
                                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                                        <button class="btn btn-primary">

                                            <i class="bi bi-search"></i>

                                        </button>

                                    </div>

                                </form>
                                <td>

                                    <a href="edit.php?record_id=<?= $record['id'] ?>" class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    <a href="delete.php?record_id=<?= $record['id'] ?>&dataset_id=<?= $dataset_id ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this record?')">

                                        Delete

                                    </a>

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