<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
 

    $data = @json_decode(@file_get_contents('data.json'), true);
    if ($data && isset($data['users'])) {
        $user = array_filter($data['users'], function($u) use ($username, $password) {
            return $u['username'] === $username && $u['password'] === $password;
        });

        if (!empty($user)) {
            $_SESSION['user'] = array_values($user)[0];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "System error: Data source not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <div class="bg-primary d-inline-block p-3 rounded-circle shadow mb-3">
                        <i class="bi bi-box-seam text-white fs-2"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Welcome Back</h2>
                    <p class="text-secondary">Please enter your details to login</p>
                </div>
                <div class="card p-4">
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="username">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                                    <input class="form-control bg-light border-start-0 py-2" 
                                           id="username" name="username" type="text" placeholder="Enter username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                                    <input class="form-control bg-light border-start-0 py-2" 
                                           id="password" name="password" type="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary py-2 fw-bold" type="submit">
                                    SIGN IN <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="index.php" class="text-decoration-none text-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>