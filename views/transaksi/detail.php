
<!-- ========================================= -->
<!-- FILE: views/transaksi/detail.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row mb-3">
    <div class="col">
        <h2>Detail Transaksi</h2>
    </div>
    <div class="col text-end">
        <a href="index.php?page=transaksi&action=laporan" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-info">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Informasi Transaksi</h5>
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Kode Transaksi:</strong></td>
                        <td><?= $transaksi['kode_transaksi'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td><?= date('d F Y H:i:s', strtotime($transaksi['tanggal'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Kasir:</strong></td>
                        <td><?= $transaksi['nama_lengkap'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <h5>Detail Produk</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($detail as $d): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['kode_produk'] ?></td>
                    <td><?= $d['nama_produk'] ?></td>
                    <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                    <td><?= $d['jumlah'] ?></td>
                    <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="5" class="text-end">Total:</th>
                    <th>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-end">Bayar:</th>
                    <th>Rp <?= number_format($transaksi['bayar'], 0, ',', '.') ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-end">Kembalian:</th>
                    <th>Rp <?= number_format($transaksi['kembalian'], 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>