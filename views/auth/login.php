
<!-- ========================================= -->
<!-- FILE: views/auth/login.php -->
<!-- ========================================= -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">
                            <i class="bi bi-cart-check"></i> POS Kasir
                        </h3>
                        <p class="text-center text-muted mb-4">Silakan login untuk melanjutkan</p>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error'] ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST" action="index.php?page=login&action=process">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required autofocus>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Login
                            </button>
                        </form>

                        <div class="text-center text-muted small">
                            <p class="mb-1">Default Login:</p>
                            <p class="mb-0">Admin: admin / password</p>
                            <p class="mb-0">Kasir: kasir1 / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>