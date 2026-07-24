<?php
require_once "../config/session.php";
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | DataSphere AI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/login.css">

</head>

<body>

    <div class="login-container">

        <!-- Left Side -->

        <div class="left-panel">

            <div class="brand">

                <i class="bi bi-database-fill"></i>

                <h1>DataSphere AI</h1>

                <p>Manage • Analyze • Visualize</p>

            </div>

        </div>

        <!-- Right Side -->

        <div class="right-panel">

            <div class="login-card">

                <h2>Welcome Back 👋</h2>

                <p>Please login to continue</p>

                <?php if(isset($_SESSION['error'])): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($_SESSION['error']) ?>

                    <?php unset($_SESSION['error']); ?>

                </div>

                <?php endif; ?>

                <form action="login_process.php" method="POST">

                    <div class="mb-3">

                        <label>Email Address</label>

                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>

                    </div>

                    <div class="mb-3">

                        <label>Password</label>

                        <div class="input-group">

                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter your password" required>

                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>

                    <div class="d-flex justify-content-between mb-4">

                        <div>

                            <input type="checkbox" name="remember" class="form-check-input" id="remember">

                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>

                        </div>

                        <a href="forgot_password.php">
                            Forgot Password?
                        </a>

                        <a href="register.php">
                            Create Account
                        </a>

                    </div>

                    <button class="btn btn-primary w-100">

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>

    <script src="../assets/js/login.js"></script>

</body>

</html>