<?php
require_once __DIR__ . '/../config.php';

echo "Starting migration...\n";

// Ensure we have the latest schema
echo "Re-initializing tables...\n";
$conn->query("DROP TABLE IF EXISTS inventory");
$conn->query("DROP TABLE IF EXISTS users");

// Trigger recreate logic in config.php by re-including it or just re-running the SQL
// Since we already edited config.php, let's just run those queries directly here for safety
$sql_inventory = "CREATE TABLE IF NOT EXISTS inventory (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    supplier VARCHAR(100),
    min_threshold INT DEFAULT 0,
    sales_history TEXT,
    monthly_sales TEXT,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$conn->query($sql_inventory);

$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_users);

// Read JSON data
$json_file = __DIR__ . '/data.json';
if (!file_exists($json_file)) {
    die("Error: data.json not found at $json_file\n");
}

$data = json_decode(file_get_contents($json_file), true);

// Migrate Inventory
echo "Migrating inventory items...\n";
$stmt = $conn->prepare("INSERT INTO inventory (id, name, category, quantity, price, supplier, min_threshold, sales_history, monthly_sales, last_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($data['inventory'] as $item) {
    $sales_history = json_encode($item['sales_history'] ?? []);
    $monthly_sales = json_encode($item['monthly_sales'] ?? []);
    
    $stmt->bind_param(
        "sssisdisss",
        $item['id'],
        $item['name'],
        $item['category'],
        $item['quantity'],
        $item['price'],
        $item['supplier'],
        $item['min_threshold'],
        $sales_history,
        $monthly_sales,
        $item['last_updated']
    );
    $stmt->execute();
}
echo "Inventory migration complete.\n";

// Migrate Users
echo "Migrating users...\n";
$user_stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");

foreach ($data['users'] as $user) {
    // We hash the password during migration
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $user_stmt->bind_param("ss", $user['username'], $hash);
    $user_stmt->execute();
}
echo "User migration complete.\n";

echo "Migration finished successfully!\n";
?>
