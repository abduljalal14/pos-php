
<!-- ========================================= -->
<!-- FILE: views/produk/form.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2><?= $action == 'create' ? 'Tambah' : 'Edit' ?> Produk</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=produk" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" 
                       value="<?= $produk['kode_produk'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" 
                       value="<?= $produk['nama_produk'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= isset($produk) && $produk['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" 
                       value="<?= $produk['harga'] ?? '' ?>" required min="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" 
                       value="<?= $produk['stok'] ?? '' ?>" required min="0">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>