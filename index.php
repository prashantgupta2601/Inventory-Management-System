<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory | Modern Management System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .hero-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-image {
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.5s ease;
        }
        .hero-image:hover {
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            font-size: 24px;
            margin-bottom: 20px;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }
        .section-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 50px;
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        footer {
            background: var(--dark-color);
            color: #fff;
            padding: 60px 0 30px;
        }
        [data-theme='dark'] .hero-section {
            background: linear-gradient(135deg, #1a1c23 0%, #111827 100%);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top glass-card mx-2 mt-2" style="border-radius: 15px;">
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
                        <a class="nav-link fw-semibold" href="#features">Features</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="#about">About</a>
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

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h5 class="text-primary fw-bold text-uppercase mb-3">Intelligent Inventory</h5>
                    <h1 class="display-3 fw-bold mb-4 text-dark">Manage stock with <span class="text-primary">AI insights</span></h1>
                    <p class="lead text-secondary mb-5">Predict demand, track trends, and optimize your supply chain with our next-generation management platform.</p>
                    <div class="d-flex gap-3">
                        <a href="login.php" class="btn btn-primary btn-lg px-5 py-3 shadow-lg">Start Free Trial</a>
                        <a href="#features" class="btn btn-outline-secondary btn-lg px-5 py-3">View Demo</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="assets/hero.png" alt="Dashboard" class="img-fluid hero-image">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="glass-card p-4 shadow-lg" style="width: 250px; transform: translate(100px, 100px);">
                                <h6 class="fw-bold"><i class="bi bi-graph-up-arrow text-success me-2"></i> Predicted Sales</h6>
                                <p class="h3 mb-0 text-dark">+24.5%</p>
                                <small class="text-muted">Next 30 days forecast</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Powerful Features</h2>
                <p class="text-secondary mx-auto" style="max-width: 600px;">Everything you need to scale your business operations without the complexity of traditional ERPs.</p>
            </div>
            <div class="row g-4 pt-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="feature-icon bg-primary-subtle">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h3>Real-time Tracking</h3>
                        <p class="text-secondary">Instant updates on stock levels across multiple locations. Never lose sight of your assets again.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="feature-icon bg-info-subtle text-info">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h3>AI Forecasting</h3>
                        <p class="text-secondary">Machine learning algorithms predict demand based on historical data, helping you avoid overstocking.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm">
                        <div class="feature-icon bg-success-subtle text-success">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <h3>Analytics Hub</h3>
                        <p class="text-secondary">Comprehensive reports and interactive charts provide deep insights into your business performance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="p-3 bg-white shadow-lg rounded-4 overflow-hidden">
                        <div class="row g-2">
                            <div class="col-6"><div class="bg-primary-subtle rounded-3" style="height: 150px;"></div></div>
                            <div class="col-6"><div class="bg-info-subtle rounded-3" style="height: 150px;"></div></div>
                            <div class="col-12"><div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 100px;"><i class="bi bi-stars text-primary fs-1"></i></div></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold mb-4">Simplicity meets Power</h2>
                    <p class="text-secondary mb-4">Our system is designed for modern retailers who need speed and accuracy. We've stripped away the bloat of enterprise software to give you a tool that works as fast as you do.</p>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Zero setup time needed</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Role-based access control</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Mobile-responsive dashboard</li>
                    </ul>
                    <a href="about.php" class="btn btn-outline-primary px-4 py-2 fw-semibold">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <h3 class="fw-bold mb-4 text-white"><i class="bi bi-box-seam-fill me-2"></i>Inventory Pro</h3>
                    <p class="text-secondary">Empowering businesses with intelligent data and seamless management tools since 2024.</p>
                </div>
                <div class="col-lg-2 ms-lg-auto">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#features" class="text-secondary text-decoration-none">Features</a></li>
                        <li><a href="about.php" class="text-secondary text-decoration-none">About</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="fw-bold mb-4">Contact</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> support@inventorypro.com</li>
                        <li><i class="bi bi-geo-alt me-2"></i> 123 Tech Avenue, Silicon Valley</li>
                    </ul>
                </div>
            </div>
            <hr class="opacity-25 mb-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0 text-secondary">&copy; 2024 Inventory Management System. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex gap-3 justify-content-md-end">
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme preservation
        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>