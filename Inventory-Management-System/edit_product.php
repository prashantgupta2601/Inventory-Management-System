<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$message = '';
$messageType = '';

// Fetch the product from SQL
$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: dashboard.php');
    exit;
}

// Decode JSON fields
$product['sales_history'] = json_decode($product['sales_history'] ?? '[]', true);
$product['monthly_sales'] = json_decode($product['monthly_sales'] ?? '[]', true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = "Error: Invalid CSRF token.";
        $messageType = "danger";
    } else {
        $sales_history = !empty($_POST['sales_history']) ? array_map('intval', explode(',', $_POST['sales_history'])) : $product['sales_history'];
    $monthly_sales = !empty($_POST['monthly_sales']) ? array_map('intval', explode(',', $_POST['monthly_sales'])) : $product['monthly_sales'];
    
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $supplier = $_POST['supplier'];
    $min_threshold = (int)$_POST['min_threshold'];
    $sales_history_json = json_encode($sales_history);
    $monthly_sales_json = json_encode($monthly_sales);

    $stmt = $conn->prepare("UPDATE inventory SET name = ?, category = ?, quantity = ?, price = ?, supplier = ?, min_threshold = ?, sales_history = ?, monthly_sales = ? WHERE id = ?");
    $stmt->bind_param("ssisdisss", $name, $category, $quantity, $price, $supplier, $min_threshold, $sales_history_json, $monthly_sales_json, $id);
    
    if ($stmt->execute()) {
        $message = "Product updated successfully!";
        $messageType = "success";
        
        // Refresh local product data
        $product['name'] = $name;
        $product['category'] = $category;
        $product['quantity'] = $quantity;
        $product['price'] = $price;
        $product['supplier'] = $supplier;
        $product['min_threshold'] = $min_threshold;
        $product['sales_history'] = $sales_history;
        $product['monthly_sales'] = $monthly_sales;
    } else {
        $message = "Error updating product: " . $conn->error;
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Inventory System</title>
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
                            <h4 class="m-0 fw-bold">Edit Product</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product ID</label>
                                <input type="text" name="id" class="form-control bg-light" value="<?php echo htmlspecialchars($product['id']); ?>" readonly>
                                <small class="text-muted">Product ID cannot be changed.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Name</label>
                                <input type="text" name="name" class="form-control bg-light" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <input type="text" name="category" class="form-control bg-light" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Quantity</label>
                                    <input type="number" name="quantity" class="form-control bg-light" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Price ($)</label>
                                    <input type="number" step="0.01" name="price" class="form-control bg-light" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Supplier</label>
                                <input type="text" name="supplier" class="form-control bg-light" value="<?php echo htmlspecialchars($product['supplier']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Minimum Threshold</label>
                                <input type="number" name="min_threshold" class="form-control bg-light" value="<?php echo htmlspecialchars($product['min_threshold'] ?? 10); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sales History (comma separated)</label>
                                <input type="text" name="sales_history" class="form-control bg-light" value="<?php echo implode(', ', $product['sales_history'] ?? []); ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Monthly Sales (comma separated)</label>
                                <input type="text" name="monthly_sales" class="form-control bg-light" value="<?php echo implode(', ', $product['monthly_sales'] ?? []); ?>">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    <i class="bi bi-save me-2"></i> UPDATE PRODUCT
                                </button>
                                <a href="dashboard.php" class="btn btn-outline-secondary py-2 fw-bold">CANCEL</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
        }
    </script>
</body>
</html>
