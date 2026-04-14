<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Inventory System</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                <i class="bi bi-box-seam me-2"></i> Inventory System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-secondary" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold text-primary border-bottom border-primary border-3" href="about.php">About</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="dashboard.php" class="btn btn-primary px-4">Dashboard</a>
                        <a href="logout.php" class="btn btn-outline-danger px-4">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary px-4">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card p-4 shadow-lg border-0">
                    <div class="card-body">
                        <h1 class="display-6 fw-bold text-dark mb-4"><i class="bi bi-info-circle-fill text-primary me-2"></i> About Our Inventory System</h1>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <h3 class="fw-bold mb-3">Goal of the Project</h3>
                                <p class="text-secondary">This project is designed to provide a lightweight and efficient way for small businesses or individuals to manage their stock. It focuses on simplicity, speed, and real-time data access.</p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="fw-bold mb-3">Key Features</h3>
                                <ul class="list-unstyled text-secondary">
                                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Real-time inventory tracking</li>
                                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Low stock automated alerts</li>
                                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Category-based organization</li>
                                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Secure session-based authentication</li>
                                </ul>
                            </div>
                        </div>
                        
                        <h2 class="fw-bold text-dark mb-4">Technology Stack</h2>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded-3 h-100 border">
                                    <h4 class="fw-bold text-primary mb-3"><i class="bi bi-code-slash me-2"></i> Frontend</h4>
                                    <ul class="text-secondary list-unstyled">
                                        <li class="mb-1">HTML5 & CSS3 (modern features)</li>
                                        <li class="mb-1">Bootstrap 5 for responsiveness</li>
                                        <li class="mb-1">Google Fonts (Poppins)</li>
                                        <li class="mb-1">Bootstrap Icons</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded-3 h-100 border">
                                    <h4 class="fw-bold text-primary mb-3"><i class="bi bi-server me-2"></i> Backend</h4>
                                    <ul class="text-secondary list-unstyled">
                                        <li class="mb-1">PHP for server-side logic</li>
                                        <li class="mb-1">JSON for lightweight storage</li>
                                        <li class="mb-1">Session Management</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center pt-4">
                            <h2 class="fw-bold text-dark mb-3">Ready to Manage?</h2>
                            <p class="text-secondary mb-4">Log in to your account to start managing your inventory.</p>
                            
                            <?php if (!isset($_SESSION['user'])): ?>
                                <a href="login.php" class="btn btn-primary btn-lg px-5">
                                    Login Now <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            <?php else: ?>
                                <a href="dashboard.php" class="btn btn-primary btn-lg px-5">
                                    Go to Dashboard <i class="bi bi-speedometer2 ms-2"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>