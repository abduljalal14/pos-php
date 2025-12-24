
<!-- ========================================= -->
<!-- FILE: views/user/index.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2>Kelola User</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=user&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Tanggal Dibuat</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= $u['username'] ?></td>
                    <td><?= $u['nama_lengkap'] ?></td>
                    <td>
                        <span class="badge <?= $u['role'] == 'admin' ? 'bg-danger' : 'bg-info' ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></td>
                    <td>
                        <a href="index.php?page=user&action=edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if ($u['id'] != $_SESSION['user_id']): ?>
                        <a href="index.php?page=user&action=delete&id=<?= $u['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus user ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>