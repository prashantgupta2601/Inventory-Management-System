<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory System</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid mx-lg-5">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-box-seam me-2"></i> Inventory System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navDashboard">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navDashboard">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white opacity-75">Welcome, <span class="fw-bold"><?php echo $_SESSION['user']['username']; ?></span></span>
                    <a href="logout.php" class="btn btn-sm btn-light text-primary fw-bold px-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Inventory Dashboard</h1>
            <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Item
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Total Items</h3>
                <p id="totalItems" class="text-3xl font-bold text-blue-500">0</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Low Stock</h3>
                <p id="lowStockItems" class="text-3xl font-bold text-red-500">0</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Inventory Value</h3>
                <p id="inventoryValue" class="text-3xl font-bold text-green-500">$0.00</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Inventory Overview</h2>
            </div>
            <div class="p-4">
                <canvas id="inventoryChart" height="100"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Inventory Items</h2>
                    <input type="text" id="searchInput" placeholder="Search items..." class="px-4 py-2 border rounded-lg">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTable" class="bg-white divide-y divide-gray-200">
                        <!-- Inventory items will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Add New Item</h3>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="addForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Item Name</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="name" name="name" type="text" placeholder="Item name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Category</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="category" name="category" type="text" placeholder="Category" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">Quantity</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="quantity" name="quantity" type="number" placeholder="Quantity" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="price" name="price" type="number" step="0.01" placeholder="Price" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="supplier">Supplier</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="supplier" name="supplier" type="text" placeholder="Supplier" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeAddModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Item</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editName">Item Name</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="editName" name="name" type="text" placeholder="Item name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editCategory">Category</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="editCategory" name="category" type="text" placeholder="Category" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editQuantity">Quantity</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="editQuantity" name="quantity" type="number" placeholder="Quantity" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editPrice">Price</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="editPrice" name="price" type="number" step="0.01" placeholder="Price" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editSupplier">Supplier</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="editSupplier" name="supplier" type="text" placeholder="Supplier" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Global variables
        let inventoryData = [];
        let inventoryChart = null;

        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            fetchInventoryData();
            
            // Set up event listeners
            document.getElementById('addForm').addEventListener('submit', addItem);
            document.getElementById('editForm').addEventListener('submit', updateItem);
            document.getElementById('searchInput').addEventListener('input', filterItems);
            
            // Refresh data every 30 seconds
            setInterval(fetchInventoryData, 30000);
        });

        // Fetch inventory data
        function fetchInventoryData() {
            fetch('api/fetch.php')
                .then(response => response.json())
                .then(data => {
                    inventoryData = data;
                    updateDashboard(data);
                    renderInventoryTable(data);
                    updateInventoryChart(data);
                })
                .catch(error => console.error('Error:', error));
        }

        // Update dashboard stats
        function updateDashboard(data) {
            const totalItems = data.length;
            const lowStockItems = data.filter(item => item.quantity < 10).length;
            const inventoryValue = data.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            
            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('lowStockItems').textContent = lowStockItems;
            document.getElementById('inventoryValue').textContent = `$${inventoryValue.toFixed(2)}`;
        }

        // Render inventory table
        function renderInventoryTable(data) {
            const tableBody = document.getElementById('inventoryTable');
            tableBody.innerHTML = '';
            
            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No inventory items found</td></tr>';
                return;
            }
            
            data.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                // Highlight low stock items
                const quantityClass = item.quantity < 5 ? 'text-red-500 font-bold' : 
                                    item.quantity < 10 ? 'text-yellow-500' : 'text-gray-700';
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${item.category}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm ${quantityClass}">${item.quantity}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">$${item.price.toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${item.supplier}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${item.last_updated}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button onclick="openEditModal('${item.id}')" class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                        <button onclick="deleteItem('${item.id}')" class="text-red-500 hover:text-red-700">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Filter items based on search input
        function filterItems() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filteredData = inventoryData.filter(item => 
                item.name.toLowerCase().includes(searchTerm) || 
                item.category.toLowerCase().includes(searchTerm) ||
                item.supplier.toLowerCase().includes(searchTerm)
            );
            renderInventoryTable(filteredData);
        }

        // Add item
        function addItem(e) {
            e.preventDefault();
            
            const formData = {
                name: document.getElementById('name').value,
                category: document.getElementById('category').value,
                quantity: document.getElementById('quantity').value,
                price: document.getElementById('price').value,
                supplier: document.getElementById('supplier').value
            };
            
            fetch('api/add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                closeAddModal();
                fetchInventoryData();
                document.getElementById('addForm').reset();
            })
            .catch(error => console.error('Error:', error));
        }

        // Update item
        function updateItem(e) {
            e.preventDefault();
            
            const formData = {
                id: document.getElementById('editId').value,
                name: document.getElementById('editName').value,
                category: document.getElementById('editCategory').value,
                quantity: document.getElementById('editQuantity').value,
                price: document.getElementById('editPrice').value,
                supplier: document.getElementById('editSupplier').value
            };
            
            fetch('api/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                closeEditModal();
                fetchInventoryData();
            })
            .catch(error => console.error('Error:', error));
        }

        // Delete item
        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`api/delete.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        fetchInventoryData();
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Modal functions
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id) {
            const item = inventoryData.find(item => item.id === id);
            if (item) {
                document.getElementById('editId').value = item.id;
                document.getElementById('editName').value = item.name;
                document.getElementById('editCategory').value = item.category;
                document.getElementById('editQuantity').value = item.quantity;
                document.getElementById('editPrice').value = item.price;
                document.getElementById('editSupplier').value = item.supplier;
                document.getElementById('editModal').classList.remove('hidden');
            }
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Update inventory chart
        function updateInventoryChart(data) {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            
            // Group by category
            const categories = {};
            data.forEach(item => {
                if (!categories[item.category]) {
                    categories[item.category] = 0;
                }
                categories[item.category] += item.quantity;
            });
            
            const labels = Object.keys(categories);
            const values = Object.values(categories);
            
            if (inventoryChart) {
                inventoryChart.data.labels = labels;
                inventoryChart.data.datasets[0].data = values;
                inventoryChart.update();
            } else {
                inventoryChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantity by Category',
                            data: values,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>