<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

// CSRF Protection Helpers
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf_token($token) {
    return !empty($token) && hash_equals($_SESSION['csrf_token'], $token);
}

// Create tables if they do not exist
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
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_users);

// Add role column if it doesn't exist (for existing tables)
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user' AFTER password_hash");
}

// Hardcode sample users: admin/1234 and user/1234
$sample_users = [
    ['admin', 'admin'],
    ['user', 'user']
];

foreach ($sample_users as $sample) {
    $u = $sample[0];
    $r = $sample[1];
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $u);
    $check->execute();
    if ($check->get_result()->num_rows === 0) {
        $hash = password_hash('1234', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $u, $hash, $r);
        $stmt->execute();
    }
}
?>