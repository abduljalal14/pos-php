
<!-- ========================================= -->
<!-- FILE: views/transaksi/laporan.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2>Laporan Transaksi</h2>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="page" value="transaksi">
            <input type="hidden" name="action" value="laporan">
            
            <div class="col-md-4">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" 
                       value="<?= $tanggal_awal ?>">
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" 
                       value="<?= $tanggal_akhir ?>">
            </div>
            
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
$total_pendapatan = 0;
?>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksi)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($transaksi as $t): 
                        $total_pendapatan += $t['total'];
                    ?>
                    <tr>
                        <td><?= $t['kode_transaksi'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($t['tanggal'])) ?></td>
                        <td><?= $t['nama_lengkap'] ?></td>
                        <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($t['bayar'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($t['kembalian'], 0, ',', '.') ?></td>
                        <td>
                            <a href="index.php?page=transaksi&action=detail&id=<?= $t['id'] ?>" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="3" class="text-end">Total Pendapatan:</th>
                    <th colspan="4">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>