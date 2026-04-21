<?php
require_once 'config.php';

// Auth check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        header('Location: dashboard.php?deleted=1');
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header('Location: dashboard.php');
    exit;
}
?>
