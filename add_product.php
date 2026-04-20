<?php
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($csrf_token)) {
        $message = "Security validation failed. Please refresh.";
        $messageType = "danger";
    } else {
        $id = $_POST['id'] ?? uniqid();
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);
        $supplier = $_POST['supplier'] ?? '';
        $min_threshold = (int)($_POST['min_threshold'] ?? 10);
        
        // Default empty sales data for new products
        $sales_history = json_encode([0, 0, 0, 0]);
        $monthly_sales = json_encode([0, 0, 0, 0, 0, 0]);

        $stmt = $conn->prepare("INSERT INTO inventory (id, name, category, quantity, price, supplier, min_threshold, sales_history, monthly_sales) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiddis s", $id, $name, $category, $quantity, $price, $supplier, $min_threshold, $sales_history, $monthly_sales);

        if ($stmt->execute()) {
            $message = "Product '$name' added successfully!";
            $messageType = "success";
        } else {
            $message = "Database error: " . $conn->error;
            $messageType = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Inventory Pro</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background: #fff;
            padding: 40px;
        }
        .form-label {
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background: #fcfdfe;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
            border-color: #4e73df;
        }
        .btn-add {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 115, 223, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="dashboard.php">
                <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
            </a>
            <div class="ms-auto text-secondary fw-semibold">
                Adding New Product
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="main-card">
                    <div class="text-center mb-5">
                        <div class="bg-primary d-inline-block p-3 rounded-4 shadow-sm mb-3">
                            <i class="bi bi-plus-circle text-white fs-2"></i>
                        </div>
                        <h2 class="fw-bold">Register Product</h2>
                        <p class="text-secondary">Fill in the details to add a new item to your database.</p>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show rounded-4 py-3 mb-4" role="alert">
                            <i class="bi bi-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill me-2"></i>
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Product ID</label>
                                <input type="text" class="form-control" name="id" placeholder="Auto-generated if empty" value="<?php echo uniqid(); ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" placeholder="e.g. Wireless Mouse" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Category</label>
                                <select class="form-select form-control" name="category" required>
                                    <option value="" disabled selected>Select category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Stationery">Stationery</option>
                                    <option value="Apparel">Apparel</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier" placeholder="e.g. Tech Global Inc." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Initial Quantity</label>
                                <input type="number" class="form-control" name="quantity" placeholder="0" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Unit Price ($)</label>
                                <input type="number" step="0.01" class="form-control" name="price" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Stock Threshold</label>
                                <input type="number" class="form-control" name="min_threshold" value="10" required>
                                <small class="text-muted">Triggers low stock alerts</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 btn-add">
                                <i class="bi bi-save me-2"></i> SAVE PRODUCT TO INVENTORY
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
