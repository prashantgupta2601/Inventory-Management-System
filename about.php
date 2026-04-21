<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Inventory Pro</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .about-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4338ca 100%);
            padding: 80px 0;
            color: white;
            border-radius: 0 0 50px 50px;
            margin-bottom: -50px;
        }
        .tech-card {
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        .tech-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top glass-card mx-2 mt-2" style="border-radius: 15px; position: fixed; width: calc(100% - 20px); z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="index.php">
                <i class="bi bi-box-seam-fill me-2"></i> Inventory Pro
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="index.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link active fw-bold text-primary" href="about.php">About</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item ms-lg-3">
                            <a href="dashboard.php" class="btn btn-primary px-4 py-2">Go to Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a href="login.php" class="btn btn-primary px-4 py-2">Get Started</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <header class="about-header">
        <div class="container text-center pt-5">
            <h1 class="display-4 fw-bold mb-3 mt-5">Innovation in Stock Management</h1>
            <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Blending modern UI aesthetics with powerful AI-driven insights to transform how you manage your inventory.</p>
        </div>
    </header>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-lg-10">
                <div class="card p-5 shadow-lg border-0 bg-white">
                    <div class="card-body">
                        <div class="row g-5 mb-5 align-items-center">
                            <div class="col-md-6">
                                <h2 class="fw-bold mb-4">Our Vision</h2>
                                <p class="text-secondary fs-5">We aim to provide a lightweight yet professional solution for stock management. By leveraging predictive analytics and a modern user interface, we empower users to make data-driven decisions that save time and reduce costs.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-primary bg-opacity-10 p-5 rounded-4 text-center">
                                    <i class="bi bi-rocket-takeoff-fill text-primary display-1"></i>
                                </div>
                            </div>
                        </div>
                        
                        <h2 class="fw-bold text-dark text-center mb-5">Built with Modern Tech</h2>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="tech-card">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                                            <i class="bi bi-window-sidebar fs-3 text-info"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0">Frontend Excellence</h4>
                                    </div>
                                    <p class="text-secondary">Crafted with PHP and Vanilla CSS, utilizing Bootstrap 5 for responsiveness and 3D effects for a premium feel.</p>
                                    <ul class="text-secondary list-unstyled">
                                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i> Glassmorphism Design</li>
                                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i> 3D CSS Transforms</li>
                                        <li><i class="bi bi-check-lg text-success me-2"></i> Dynamic Chart.js Visuals</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="tech-card">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                            <i class="bi bi-database-fill-gear fs-3 text-primary"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0">Robust Backend</h4>
                                    </div>
                                    <p class="text-secondary">Powered by MySQL for reliable data storage and PHP for core business logic and AI forecasting algorithms.</p>
                                    <ul class="text-secondary list-unstyled">
                                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i> MySQL Relational DB</li>
                                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i> Secure RBAC System</li>
                                        <li><i class="bi bi-check-lg text-success me-2"></i> PHP Forecasting Models</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center pt-4">
                            <h2 class="fw-bold text-dark mb-3">Ready to experience the future?</h2>
                            <?php if (!isset($_SESSION['user'])): ?>
                                <a href="login.php" class="btn btn-primary btn-lg px-5 py-3 shadow-lg">
                                    Get Started Now <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            <?php else: ?>
                                <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3 shadow-lg">
                                    Return to Dashboard <i class="bi bi-speedometer2 ms-2"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="mt-5 bg-dark py-4 text-center">
        <p class="mb-0 text-secondary">&copy; 2024 Inventory Pro. All systems operational.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>