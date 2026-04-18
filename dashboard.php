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
    
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="shadow">
            <div class="sidebar-header d-flex align-items-center justify-content-between">
                <h4 class="m-0 fw-bold text-primary"><i class="bi bi-box-seam me-2"></i>IMS</h4>
                <button type="button" id="sidebarCollapseClose" class="btn d-md-none">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                </li>
                <li>
                    <a href="index.php"><i class="bi bi-house me-2"></i> Home</a>
                </li>
                <li>
                    <a href="about.php"><i class="bi bi-info-circle me-2"></i> About</a>
                </li>
                <li class="mt-5">
                    <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm mb-4 rounded-3">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="bi bi-text-left"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <!-- Dark Mode Toggle -->
                        <button class="btn btn-outline-secondary btn-sm me-3 border-0 rounded-circle" id="themeToggle">
                            <i class="bi bi-moon-stars fs-5"></i>
                        </button>

                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> <?php echo $_SESSION['user']['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h2 class="fw-bold text-dark m-0">Inventory Dashboard</h2>
                        <p class="text-secondary m-0">Manage and track your items efficiently</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-lg me-2"></i> Add New Item
                        </button>
                    </div>
                </div>
                
                <!-- Smart Alert Container -->
                <div id="smartAlertContainer"></div>

                <!-- Stats Cards (Step 4 placeholders) -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card p-3 border-0 shadow-sm border-start border-primary border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Items</div>
                                        <div id="totalItems" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-check fs-1 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 border-0 shadow-sm border-start border-danger border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Low Stock</div>
                                        <div id="lowStockItems" class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-exclamation-triangle fs-1 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 border-0 shadow-sm border-start border-success border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Inventory Value</div>
                                        <div id="inventoryValue" class="h3 mb-0 font-weight-bold text-gray-800">$0.00</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-currency-dollar fs-1 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3 border-0">
                                <h5 class="m-0 fw-bold text-dark">Inventory Overview</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="inventoryChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 fw-bold text-dark">Inventory Items</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchInput" placeholder="Search items..." class="form-control bg-light border-0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3 text-center">Quantity</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3 text-center">Predicted Demand</th>
                                    <th class="px-4 py-3">Supplier</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventoryTable" class="bg-white">
                                <!-- Inventory items will be loaded here via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold">Add New Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Enter item name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" class="form-control bg-light" id="category" name="category" placeholder="Enter category" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control bg-light" id="quantity" name="quantity" placeholder="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price ($)</label>
                                <input type="number" step="0.01" class="form-control bg-light" id="price" name="price" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Supplier</label>
                            <input type="text" class="form-control bg-light" id="supplier" name="supplier" placeholder="Enter supplier name" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">SAVE ITEM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold">Edit Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Name</label>
                            <input type="text" class="form-control bg-light" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" class="form-control bg-light" id="editCategory" name="category" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control bg-light" id="editQuantity" name="quantity" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price ($)</label>
                                <input type="number" step="0.01" class="form-control bg-light" id="editPrice" name="price" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Supplier</label>
                            <input type="text" class="form-control bg-light" id="editSupplier" name="supplier" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">UPDATE ITEM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i id="toastIcon" class="bi me-2 fs-5"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global variables
        let inventoryData = [];
        let inventoryChart = null;

        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        
        // Check for saved theme
        if (localStorage.getItem('theme') === 'dark') {
            body.setAttribute('data-theme', 'dark');
            themeToggle.innerHTML = '<i class="bi bi-sun fs-5"></i>';
        }

        themeToggle.addEventListener('click', () => {
            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                themeToggle.innerHTML = '<i class="bi bi-moon-stars fs-5"></i>';
            } else {
                body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeToggle.innerHTML = '<i class="bi bi-sun fs-5"></i>';
            }
        });

        // Toast Helper
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');
            
            toastMessage.textContent = message;
            toastEl.className = `toast border-0 shadow-lg bg-${type} text-white`;
            
            if (type === 'success') toastIcon.className = 'bi bi-check-circle-fill me-2 fs-5';
            else if (type === 'danger') toastIcon.className = 'bi bi-exclamation-circle-fill me-2 fs-5';
            else if (type === 'warning') toastIcon.className = 'bi bi-exclamation-triangle-fill me-2 fs-5';
            
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // Sidebar Toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
        
        document.getElementById('sidebarCollapseClose').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('content').classList.remove('active');
        });

        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            fetchInventoryData();
            
            // Set up event listeners
            document.getElementById('addForm').addEventListener('submit', addItem);
            document.getElementById('editForm').addEventListener('submit', updateItem);
            document.getElementById('searchInput').addEventListener('input', filterItems);
            
            // Refresh data every 60 seconds
            setInterval(fetchInventoryData, 60000);
            
            // Show welcome toast
            showToast('Welcome to your Dashboard!', 'success');
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
            const lowStockItemsCount = data.filter(item => parseInt(item.quantity) < parseInt(item.min_threshold || 10)).length;
            const inventoryValue = data.reduce((sum, item) => sum + (parseInt(item.quantity) * parseFloat(item.price)), 0);
            
            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('lowStockItems').textContent = lowStockItemsCount;
            document.getElementById('inventoryValue').textContent = `$${inventoryValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            // Update Smart Alert
            const alertContainer = document.getElementById('smartAlertContainer');
            if (lowStockItemsCount > 0) {
                alertContainer.innerHTML = `
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4 fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">Low Stock Warning!</strong>
                            There are <b>${lowStockItemsCount}</b> items with stock below their minimum threshold. Please restock soon.
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            } else {
                alertContainer.innerHTML = '';
            }
        }

        // Render inventory table
        function renderInventoryTable(data) {
            const tableBody = document.getElementById('inventoryTable');
            tableBody.innerHTML = '';
            
            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-box2"></i>
                        <h5 class="text-secondary">No inventory items found</h5>
                        <p class="text-muted">Start by adding a new item to your system.</p>
                    </div>
                </td></tr>`;
                return;
            }
            
            data.forEach(item => {
                const row = document.createElement('tr');
                const qty = parseInt(item.quantity);
                const threshold = parseInt(item.min_threshold || 10);
                const isLowStock = qty < threshold;
                
                // Highlight low stock items
                const badgeClass = isLowStock ? 'bg-danger' : 
                                 qty < (threshold + 5) ? 'bg-warning text-dark' : 'bg-success';
                
                if (isLowStock) row.classList.add('table-danger');
                
                row.innerHTML = `
                    <td class="px-4 py-3">
                        <div class="fw-bold d-flex align-items-center">
                            <i class="bi bi-dot fs-2 text-${isLowStock ? 'danger' : (qty < (threshold + 5) ? 'warning' : 'success')} me-n1"></i>
                            ${item.name}
                            ${isLowStock ? '<span class="ms-2 badge bg-danger text-uppercase" style="font-size: 0.6rem;">Low Stock</span>' : ''}
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="badge bg-light text-secondary border border-secondary border-opacity-25 px-3 py-2">${item.category}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="badge ${badgeClass} rounded-pill px-3 py-2" style="min-width: 45px;">${qty}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="fw-bold">$${parseFloat(item.price).toFixed(2)}</div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="badge bg-info-subtle text-info border border-info border-opacity-25 px-3 py-2">
                             ${item.forecast}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-secondary">
                        ${item.supplier}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="openEditModal('${item.id}')" class="btn btn-sm btn-outline-primary border-0 me-1" title="Edit Item">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="deleteItem('${item.id}')" class="btn btn-sm btn-outline-danger border-0" title="Delete Item">
                            <i class="bi bi-trash"></i>
                        </button>
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
                const addModalEl = document.getElementById('addModal');
                const addModal = bootstrap.Modal.getInstance(addModalEl);
                addModal.hide();
                fetchInventoryData();
                document.getElementById('addForm').reset();
                showToast('Item added successfully!', 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error adding item.', 'danger');
            });
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
                const editModalEl = document.getElementById('editModal');
                const editModal = bootstrap.Modal.getInstance(editModalEl);
                editModal.hide();
                fetchInventoryData();
                showToast('Item updated successfully!', 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating item.', 'danger');
            });
        }

        // Delete item
        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`api/delete.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        fetchInventoryData();
                        showToast('Item deleted successfully!', 'warning');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Error deleting item.', 'danger');
                    });
            }
        }

        // Modal triggers (not needed anymore with data-bs-target, but keeping for compatibility if invoked via JS)
        function openEditModal(id) {
            const item = inventoryData.find(item => item.id === id);
            if (item) {
                document.getElementById('editId').value = item.id;
                document.getElementById('editName').value = item.name;
                document.getElementById('editCategory').value = item.category;
                document.getElementById('editQuantity').value = item.quantity;
                document.getElementById('editPrice').value = item.price;
                document.getElementById('editSupplier').value = item.supplier;
                
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            }
        }

        // Update inventory chart
        function updateInventoryChart(data) {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            const isDark = body.getAttribute('data-theme') === 'dark';
            
            // Group by category
            const categories = {};
            data.forEach(item => {
                if (!categories[item.category]) {
                    categories[item.category] = 0;
                }
                categories[item.category] += parseInt(item.quantity);
            });
            
            const labels = Object.keys(categories);
            const values = Object.values(categories);
            
            if (inventoryChart) {
                inventoryChart.data.labels = labels;
                inventoryChart.data.datasets[0].data = values;
                inventoryChart.options.scales.x.ticks.color = isDark ? '#a0a0a0' : '#666';
                inventoryChart.options.scales.y.ticks.color = isDark ? '#a0a0a0' : '#666';
                inventoryChart.update();
            } else {
                inventoryChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantity by Category',
                            data: values,
                            backgroundColor: '#4e73df',
                            borderColor: '#4e73df',
                            borderWidth: 1,
                            borderRadius: 5,
                            barPercentage: 0.5
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                grid: { color: isDark ? '#3f414e' : '#e2e2e2', borderDash: [2, 2] },
                                ticks: { color: isDark ? '#a0a0a0' : '#666' }
                            },
                            x: { 
                                grid: { display: false },
                                ticks: { color: isDark ? '#a0a0a0' : '#666' }
                            }
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>