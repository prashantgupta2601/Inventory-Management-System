<?php
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$message = '';
$messageType = '';

// Fetch existing product data
$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($csrf_token)) {
        $message = "Security validation failed. Please refresh.";
        $messageType = "danger";
    } else {
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);
        $supplier = $_POST['supplier'] ?? '';
        $min_threshold = (int)($_POST['min_threshold'] ?? 10);
        
        // Handle comma-separated sales data
        $sales_history = !empty($_POST['sales_history']) ? json_encode(array_map('intval', explode(',', $_POST['sales_history']))) : $product['sales_history'];
        $monthly_sales = !empty($_POST['monthly_sales']) ? json_encode(array_map('intval', explode(',', $_POST['monthly_sales']))) : $product['monthly_sales'];

        $update_stmt = $conn->prepare("UPDATE inventory SET name=?, category=?, quantity=?, price=?, supplier=?, min_threshold=?, sales_history=?, monthly_sales=? WHERE id=?");
        $update_stmt->bind_param("sssidisss", $name, $category, $quantity, $price, $supplier, $min_threshold, $sales_history, $monthly_sales, $id);

        if ($update_stmt->execute()) {
            $message = "Product updated successfully!";
            $messageType = "success";
            // Refresh product data for display
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
        } else {
            $message = "Error updating product: " . $conn->error;
            $messageType = "danger";
        }
    }
}

// Prepare arrays for display in form
$sales_history_display = implode(', ', json_decode($product['sales_history'], true) ?? []);
$monthly_sales_display = implode(', ', json_decode($product['monthly_sales'], true) ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Inventory Pro</title>
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
        .btn-update {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-update:hover {
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
                Editing: <span class="text-dark"><?php echo htmlspecialchars($product['name']); ?></span>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="main-card">
                    <div class="text-center mb-5">
                        <div class="bg-primary d-inline-block p-3 rounded-4 shadow-sm mb-3">
                            <i class="bi bi-pencil-square text-white fs-2"></i>
                        </div>
                        <h2 class="fw-bold">Update Product</h2>
                        <p class="text-secondary">Modify the fields below to update information in real-time.</p>
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
                                <label class="form-label text-muted">Product ID (Read Only)</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $product['id']; ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Category</label>
                                <select class="form-select form-control" name="category" required>
                                    <option value="Electronics" <?php echo ($product['category'] == 'Electronics' ? 'selected' : ''); ?>>Electronics</option>
                                    <option value="Furniture" <?php echo ($product['category'] == 'Furniture' ? 'selected' : ''); ?>>Furniture</option>
                                    <option value="Stationery" <?php echo ($product['category'] == 'Stationery' ? 'selected' : ''); ?>>Stationery</option>
                                    <option value="Apparel" <?php echo ($product['category'] == 'Apparel' ? 'selected' : ''); ?>>Apparel</option>
                                    <option value="Other" <?php echo ($product['category'] == 'Other' ? 'selected' : ''); ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier" value="<?php echo htmlspecialchars($product['supplier']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Current Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo $product['quantity']; ?>" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Unit Price ($)</label>
                                <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Low Stock Threshold</label>
                                <input type="number" class="form-control" name="min_threshold" value="<?php echo $product['min_threshold'] ?? 10; ?>" required>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">
                        <div class="mb-4">
                            <label class="form-label">Historical Sales (Last 4 Cycles)</label>
                            <input type="text" class="form-control" name="sales_history" value="<?php echo $sales_history_display; ?>" placeholder="e.g. 10, 15, 20, 18">
                            <small class="text-muted">Separate numbers with commas. This powers AI forecasting.</small>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Monthly Sales Trend (Last 6 Months)</label>
                            <input type="text" class="form-control" name="monthly_sales" value="<?php echo $monthly_sales_display; ?>" placeholder="e.g. 12, 18, 25, 20, 30, 28">
                            <small class="text-muted"> Powers the dashboard analytics chart.</small>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-update">
                                <i class="bi bi-cloud-arrow-up me-2"></i> UPDATE PRODUCT DETAILS
                            </button>
                            <a href="dashboard.php" class="btn btn-outline-secondary py-3 fw-semibold border-0">Cancel and Return</a>
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
