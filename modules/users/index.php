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

$search = trim($_GET['search'] ?? '');

if ($search != '') {

    $stmt = $conn->prepare("
        SELECT id, name, email, role, status
        FROM users
        WHERE
            name LIKE ?
            OR email LIKE ?
            OR role LIKE ?
        ORDER BY id DESC
    ");

    $keyword = "%{$search}%";

    $stmt->execute([
        $keyword,
        $keyword,
        $keyword
    ]);

} else {

    $stmt = $conn->query("
        SELECT id, name, email, role, status
        FROM users
        ORDER BY id DESC
    ");

}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <h2>Users</h2>
                    <p class="text-muted">
                        Manage all registered users.
                    </p>
                </div>

                <a href="create.php" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill"></i>
                    Add User
                </a>

            </div>

            <form method="GET" class="mb-3">

                <div class="input-group">

                    <input type="text" class="form-control" name="search" placeholder="Search users..."
                        value="<?= htmlspecialchars($search) ?>">

                    <button class="btn btn-primary">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

            </form>

            <div class="alert alert-primary">

                Total Users :

                <strong>

                    <?= count($users) ?>

                </strong>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <?php if(count($users) > 0): ?>

                    <table class="table table-bordered table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="180">Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($users as $user): ?>

                            <tr>

                                <td><?= $user['id'] ?></td>

                                <td><?= htmlspecialchars($user['name']) ?></td>

                                <td><?= htmlspecialchars($user['email']) ?></td>

                                <td>

                                    <span class="badge bg-<?= $user['role']=='admin'
? 'danger'
: 'secondary' ?>">

                                        <?= htmlspecialchars($user['role']) ?>

                                    </span>

                                </td>

                                <td>

                                    <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    <?php if ($_SESSION['user_role'] === 'admin'): ?>

                                    <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this user?')">
                                        Delete
                                    </a>

                                    <?php endif; ?>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                    <?php else: ?>

                    <div class="alert alert-info">

                        No users found.

                    </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../components/footer.php"; ?>