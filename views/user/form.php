
<!-- ========================================= -->
<!-- FILE: views/user/form.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2><?= $action == 'create' ? 'Tambah' : 'Edit' ?> User</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=user" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= $user['username'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <?= $action == 'edit' ? '(Kosongkan jika tidak diubah)' : '' ?></label>
                        <input type="password" name="password" class="form-control" 
                               <?= $action == 'create' ? 'required' : '' ?>>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" 
                               value="<?= $user['nama_lengkap'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" <?= isset($user) && $user['role'] == 'admin' ? 'selected' : '' ?>>
                                Admin
                            </option>
                            <option value="kasir" <?= isset($user) && $user['role'] == 'kasir' ? 'selected' : '' ?>>
                                Kasir
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>