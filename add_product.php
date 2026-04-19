<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('data.json'), true);
    
    // Simple validation
    $id = $_POST['id'] ?: uniqid();
    
    // Check if ID already exists
    $exists = false;
    foreach ($data['inventory'] as $item) {
        if ($item['id'] === $id) {
            $exists = true;
            break;
        }
    }
    
    if ($exists) {
        $message = "Error: Product ID already exists.";
        $messageType = "danger";
    } else {
        $sales_history = !empty($_POST['sales_history']) ? array_map('intval', explode(',', $_POST['sales_history'])) : [0, 0, 0, 0];
        $monthly_sales = !empty($_POST['monthly_sales']) ? array_map('intval', explode(',', $_POST['monthly_sales'])) : [0, 0, 0, 0, 0, 0];
        
        $newProduct = [
            'id' => $id,
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'quantity' => (int)$_POST['quantity'],
            'price' => (float)$_POST['price'],
            'supplier' => $_POST['supplier'],
            'last_updated' => date('Y-m-d H:i:s'),
            'sales_history' => $sales_history,
            'monthly_sales' => $monthly_sales,
            'min_threshold' => (int)$_POST['min_threshold'] ?: 10
        ];
        
        $data['inventory'][] = $newProduct;
        if (file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT))) {
            $message = "Product added successfully!";
            $messageType = "success";
            // Redirect to dashboard after 2 seconds or provide link
        } else {
            $message = "Error saving product.";
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
    <title>Add Product - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 border-0">
                        <div class="d-flex align-items-center">
                            <a href="dashboard.php" class="btn btn-link text-white p-0 me-3">
                                <i class="bi bi-arrow-left fs-4"></i>
                            </a>
                            <h4 class="m-0 fw-bold">Add New Product</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="add_product.php">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product ID (optional)</label>
                                <input type="text" name="id" class="form-control bg-light" placeholder="Auto-generated if empty">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Name</label>
                                <input type="text" name="name" class="form-control bg-light" required placeholder="e.g. Cricket Bat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <input type="text" name="category" class="form-control bg-light" required placeholder="e.g. Sports">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Quantity</label>
                                    <input type="number" name="quantity" class="form-control bg-light" required placeholder="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Price ($)</label>
                                    <input type="number" step="0.01" name="price" class="form-control bg-light" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Supplier</label>
                                <input type="text" name="supplier" class="form-control bg-light" required placeholder="Supplier name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Minimum Threshold (for alerts)</label>
                                <input type="number" name="min_threshold" class="form-control bg-light" value="10">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sales History (comma separated)</label>
                                <input type="text" name="sales_history" class="form-control bg-light" placeholder="10, 15, 20, 18">
                                <small class="text-muted">Enter recent sales units for AI forecasting.</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Monthly Sales (comma separated)</label>
                                <input type="text" name="monthly_sales" class="form-control bg-light" placeholder="12, 18, 25, 20, 30, 28">
                                <small class="text-muted">Enter sales for last 6 months for trend chart.</small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    <i class="bi bi-save me-2"></i> SAVE PRODUCT
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Use theme from localStorage
        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>
