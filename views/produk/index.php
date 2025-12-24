<!-- ========================================= -->
<!-- FILE: views/produk/index.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2>Kelola Produk</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=produk&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p): ?>
                <tr>
                    <td><?= $p['kode_produk'] ?></td>
                    <td><?= $p['nama_produk'] ?></td>
                    <td><?= $p['nama_kategori'] ?? '-' ?></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge <?= $p['stok'] < 10 ? 'bg-danger' : 'bg-success' ?>">
                            <?= $p['stok'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?page=produk&action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="index.php?page=produk&action=delete&id=<?= $p['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>


