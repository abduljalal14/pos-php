<!-- ========================================= -->
<!-- FILE: views/kategori/index.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2>Kelola Kategori</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=kategori&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Nama Kategori</th>
                    <th>Tanggal Dibuat</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $k): ?>
                <tr>
                    <td><?= $k['id'] ?></td>
                    <td><?= $k['nama_kategori'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($k['created_at'])) ?></td>
                    <td>
                        <a href="index.php?page=kategori&action=edit&id=<?= $k['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="index.php?page=kategori&action=delete&id=<?= $k['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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

