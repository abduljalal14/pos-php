<!-- ========================================= -->
<!-- FILE: views/dashboard/index.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Dashboard</h2>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Total Produk -->
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Produk</h6>
                        <h2 class="mb-0"><?= $stats['total_produk'] ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-box-seam" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Hari Ini -->
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Transaksi Hari Ini</h6>
                        <h2 class="mb-0"><?= $stats['transaksi_hari_ini'] ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-cart-check" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan Hari Ini -->
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Pendapatan Hari Ini</h6>
                        <h2 class="mb-0">Rp <?= number_format($stats['pendapatan_hari_ini'], 0, ',', '.') ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-cash-coin" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Rendah -->
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2">Produk Stok Rendah</h6>
                        <h2 class="mb-0"><?= $stats['produk_stok_rendah'] ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Menu Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=kasir" class="btn btn-lg btn-success">
                        <i class="bi bi-cart-check"></i> Mulai Transaksi
                    </a>
                    
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="index.php?page=transaksi&action=laporan" class="btn btn-lg btn-info">
                        <i class="bi bi-file-earmark-text"></i> Lihat Laporan
                    </a>
                    <a href="index.php?page=produk" class="btn btn-lg btn-primary">
                        <i class="bi bi-box-seam"></i> Kelola Produk
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Informasi</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?= $_SESSION['nama_lengkap'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td><?= $_SESSION['username'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td><span class="badge bg-primary"><?= ucfirst($_SESSION['role']) ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td><?= date('d F Y') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Waktu:</strong></td>
                        <td id="current-time"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
}

updateTime();
setInterval(updateTime, 1000);
</script>

<?php include 'views/layouts/footer.php'; ?>