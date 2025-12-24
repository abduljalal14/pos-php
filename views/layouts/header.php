<!-- ========================================= -->
<!-- FILE: views/layouts/header.php -->
<!-- ========================================= -->

<?php 
// Mengambil nilai page dan action langsung dari URL jika variabel tidak ditemukan
$page = isset($page) ? $page : (isset($_GET['page']) ? $_GET['page'] : 'dashboard');
$action = isset($action) ? $action : (isset($_GET['action']) ? $_GET['action'] : 'index');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi POS Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar text-white p-3" style="width: 250px;">
            <h4 class="text-center mb-4">POS Kasir</h4>
            <hr class="bg-white">
            
            <div class="mb-3">
                <small class="text-white-50">MENU UTAMA</small>
            </div>
            
            <a href="index.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <a href="index.php?page=kasir" class="<?= $page == 'kasir' ? 'active' : '' ?>">
                <i class="bi bi-cart-check"></i> Kasir
            </a>
            
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="mb-3 mt-3">
                <small class="text-white-50">MASTER DATA</small>
            </div>
            
            <a href="index.php?page=produk" class="<?= $page == 'produk' ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Produk
            </a>
            
            <a href="index.php?page=kategori" class="<?= $page == 'kategori' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i> Kategori
            </a>
            
            <a href="index.php?page=user" class="<?= $page == 'user' ? 'active' : '' ?>">
                <i class="bi bi-people"></i> User
            </a>
            
            <div class="mb-3 mt-3">
                <small class="text-white-50">LAPORAN</small>
            </div>
            
            <a href="index.php?page=transaksi&action=laporan" class="<?= $page == 'transaksi' && $action == 'laporan' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i> Laporan Transaksi
            </a>
            <?php endif; ?>
            
            <hr class="bg-white mt-4">
            
            <a href="index.php?page=logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-light bg-light px-4">
                <span class="navbar-brand mb-0 h1">
                    Aplikasi Kasir - <?= ucfirst($page) ?>
                </span>
                <span class="text-muted">
                    <i class="bi bi-person-circle"></i> 
                    <?= $_SESSION['nama_lengkap'] ?> (<?= ucfirst($_SESSION['role']) ?>)
                </span>
            </nav>

            <!-- Content Area -->
            <div class="p-4">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

