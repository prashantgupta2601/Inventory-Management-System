<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Inventory System</title>
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
                        <a class="nav-link active fw-semibold text-primary border-bottom border-primary border-3" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-secondary" href="about.php">About</a>
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
            <div class="col-md-8">
                <div class="card p-4 p-md-5">
                    <div class="card-body text-center">
                        <h1 class="display-5 fw-bold text-dark mb-4">Welcome to the Inventory Management System</h1>
                        <p class="lead text-secondary mb-5">A comprehensive solution for tracking and managing your retail inventory in real-time.</p>
                        
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="dashboard.php" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-speedometer2 me-2"></i> Go to Dashboard
                            </a>
                        <?php else: ?>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="login.php" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                                </a>
                                <a href="about.php" class="btn btn-outline-secondary btn-lg px-5">
                                    <i class="bi bi-info-circle me-2"></i> Learn More
                                </a>
                            </div>
                        <?php endif; ?>
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