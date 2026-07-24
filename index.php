<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DataSphere | Smart Database Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Our CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <div class="blob blob1"></div>

    <div class="blob blob2"></div>

    <div class="blob blob3"></div>

    <!-- ================= NAVBAR ================= -->

    <header>

        <nav class="navbar navbar-expand-lg">

            <div class="container">

                <!-- Logo -->
                <a class="navbar-brand fw-bold" href="#">
                    <i class="bi bi-database-fill"></i>
                    DataSphere AI
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <!-- Menu -->

                <div class="collapse navbar-collapse" id="navbar">

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>

                    </ul>

                    <div class="d-flex gap-2">

                        <a href="auth/login.php" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </a>

                        <a href="auth/login.php" class="btn btn-primary">
                            <i class="bi bi-rocket-takeoff"></i>
                            Get Started
                        </a>

                    </div>

                </div>

            </div>

        </nav>

    </header>

    <!-- ================= HERO SECTION ================= -->

    <main class="hero" id="home">

        <div class="container">

            <div class="row align-items-center">

                <!-- Left Side -->

                <div class="col-lg-6">

                    <span class="hero-tag">
                        🚀 Smart Database Management
                    </span>

                    <h1 class="hero-title">

                        Manage Your Database

                        <span>Smarter & Faster</span>

                    </h1>

                    <p class="hero-text">

                        A modern database management portal that lets you
                        add, edit, search, analyze, and manage records
                        efficiently with a clean and professional interface.

                    </p>

                    <div class="hero-buttons">

                        <a href="auth/login.php" class="btn btn-primary">
                            Get Started
                        </a>

                        <a href="dashboard/index.php" class="btn btn-outline-primary">
                            Live Demo
                        </a>

                    </div>

                </div>

                <!-- Right Side -->

                <div class="dashboard-preview">

                    <div class="dashboard-header">

                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>

                    </div>

                    <div class="dashboard-body">

                        <div class="mini-sidebar"></div>

                        <div class="dashboard-content">

                            <div class="stats">

                                <div class="stat-card">
                                    <h5>Students</h5>
                                    <h2>1254</h2>
                                </div>

                                <div class="stat-card">
                                    <h5>Departments</h5>
                                    <h2>18</h2>
                                </div>

                            </div>

                            <div class="table-preview">

                                <div class="table-row"></div>
                                <div class="table-row"></div>
                                <div class="table-row"></div>
                                <div class="table-row"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- ================= TRUSTED SECTION ================= -->

    <section class="trusted" id="about">

        <div class="container">

            <p class="trusted-title">

                Trusted by Students, Developers & Organizations

            </p>

            <div class="trusted-logos">

                <div class="logo-box">College</div>

                <div class="logo-box">Company</div>

                <div class="logo-box">Institute</div>

                <div class="logo-box">Research</div>

                <div class="logo-box">Community</div>

            </div>

        </div>

    </section>


    <!-- ================= FEATURES SECTION ================= -->

    <section class="features" id="features">

        <div class="container">

            <div class="section-title">

                <h2>Why Choose <span>DataSphere?</span></h2>

                <p>
                    Everything you need to manage, analyze and secure your database
                    in one powerful platform.
                </p>

            </div>

            <div class="row g-4">

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <h4>Smart Search</h4>

                        <p>
                            Instantly search and filter records with lightning-fast performance.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>

                        <h4>Analytics</h4>

                        <p>
                            Interactive charts and reports help you understand your data.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        <h4>Secure Access</h4>

                        <p>
                            User authentication with role-based permissions.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-upload"></i>
                        </div>

                        <h4>Import Data</h4>

                        <p>
                            Upload Excel, CSV and documents with a single click.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>

                        <h4>High Performance</h4>

                        <p>
                            Optimized backend for quick response and smooth experience.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="bi bi-moon-stars"></i>
                        </div>

                        <h4>Dark Mode</h4>

                        <p>
                            Switch between light and dark themes anytime.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="contact" id="contact">

        <div class="container">

            <div class="section-title">
                <h2>Get In <span>Touch</span></h2>
                <p>
                    Have questions about DataSphere AI? We'd love to hear from you.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-lg-5">

                    <div class="contact-info">

                        <div class="info-box">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <h5>Email</h5>
                                <p>admin@datasphereai.com</p>
                            </div>
                        </div>

                        <div class="info-box">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <h5>Phone</h5>
                                <p>+91 93990 41883</p>
                            </div>
                        </div>

                        <div class="info-box">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <h5>Location</h5>
                                <p>Jharkhand, India</p>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-lg-7">

                    <div class="contact-form">

                        <form>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>

                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control" rows="6" placeholder="Write your message..."></textarea>
                            </div>

                            <button class="btn btn-primary">
                                <i class="bi bi-send-fill"></i>
                                Send Message
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->

    <footer class="footer">

        <div class="container text-center">

            <h3>DataSphere AI</h3>

            <p>
                Modern Database Management Platform
            </p>

            <div class="social-icons">

                <a href="#"><i class="bi bi-github"></i></a>

                <a href="#"><i class="bi bi-linkedin"></i></a>

                <a href="#"><i class="bi bi-twitter-x"></i></a>

            </div>

            <hr>

            <p>
                © 2026 DataSphere AI. All Rights Reserved.
            </p>

        </div>

    </footer>

    <script>
    window.addEventListener("scroll", function() {

        const navbar = document.querySelector(".navbar");

        if (window.scrollY > 50) {
            navbar.style.padding = "8px 0";
            navbar.style.boxShadow = "0 10px 30px rgba(0,0,0,.15)";
        } else {
            navbar.style.padding = "12px 0";
            navbar.style.boxShadow = "0 8px 30px rgba(0,0,0,.08)";
        }

    });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Our JS -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/effects.js"></script>

</body>

</html>