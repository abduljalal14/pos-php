<!-- ========================================= -->
<!-- FILE: views/transaksi/kasir.php -->
<!-- ========================================= -->
<?php include 'views/layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Kasir - Point of Sale</h2>
    </div>
</div>

<div class="row">
    <!-- Kiri: Daftar Produk -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Produk</h5>
            </div>
            <div class="card-body">
                <input type="text" id="search-produk" class="form-control mb-3" placeholder="Cari produk atau scan barcode...">
                
                <div style="max-height: 500px; overflow-y: auto;">
                    <?php foreach ($produk as $p): ?>
                    <div class="card mb-2 produk-item" style="cursor: pointer;" 
                         data-id="<?= $p['id'] ?>"
                         data-kode="<?= $p['kode_produk'] ?>"
                         data-nama="<?= $p['nama_produk'] ?>"
                         data-harga="<?= $p['harga'] ?>"
                         data-stok="<?= $p['stok'] ?>">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= $p['nama_produk'] ?></strong>
                                    <br>
                                    <small class="text-muted"><?= $p['kode_produk'] ?></small>
                                </div>
                                <div class="text-end">
                                    <div class="text-primary fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                                    <small class="text-muted">Stok: <?= $p['stok'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanan: Keranjang & Pembayaran -->
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Keranjang Belanja</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="cart-table">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th width="120">Harga</th>
                            <th width="150">Jumlah</th> <th width="120">Subtotal</th>
                            <th width="60">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr id="empty-cart">
                            <td colspan="5" class="text-center text-muted">
                                Keranjang masih kosong
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <h4>Total:</h4>
                    </div>
                    <div class="col-6 text-end">
                        <h3 class="text-primary mb-0" id="total-display">Rp 0</h3>
                        <input type="hidden" id="total-value" value="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah Bayar:</label>
                    <input type="number" id="bayar" class="form-control form-control-lg" placeholder="0" min="0">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kembalian:</label>
                    <input type="text" id="kembalian" class="form-control form-control-lg bg-light" readonly value="Rp 0">
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-success btn-lg" id="btn-bayar">
                        <i class="bi bi-check-circle"></i> Proses Pembayaran
                    </button>
                    <button class="btn btn-danger btn-lg" id="btn-reset">
                        <i class="bi bi-x-circle"></i> Reset Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>

<script>
let cart = [];

// Tambah produk ke keranjang
$('.produk-item').click(function() {
    const id = $(this).data('id');
    const kode = $(this).data('kode');
    const nama = $(this).data('nama');
    const harga = parseFloat($(this).data('harga'));
    const stok = parseInt($(this).data('stok'));

    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        if (existingItem.jumlah < stok) {
            existingItem.jumlah++;
            existingItem.subtotal = existingItem.jumlah * existingItem.harga;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        if (stok > 0) {
            cart.push({
                id: id,
                kode: kode,
                nama: nama,
                harga: harga,
                jumlah: 1,
                subtotal: harga,
                stok: stok
            });
        } else {
            alert('Stok habis!');
            return;
        }
    }
    
    renderCart();
});

// Render keranjang
function renderCart() {
    const tbody = $('#cart-body');
    tbody.empty();
    
    if (cart.length === 0) {
        tbody.html('<tr id="empty-cart"><td colspan="5" class="text-center text-muted">Keranjang masih kosong</td></tr>');
        updateTotal();
        return;
    }
    
    cart.forEach((item, index) => {
        tbody.append(`
            <tr>
                <td>
                    <strong>${item.nama}</strong><br>
                    <small class="text-muted">${item.kode}</small>
                </td>
                <td>Rp ${formatRupiah(item.harga)}</td>
                <td>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary btn-minus" data-index="${index}">-</button>
                        <input type="number" class="form-control text-center jumlah-input" 
                               value="${item.jumlah}" data-index="${index}" min="1" max="${item.stok}">
                        <button class="btn btn-outline-secondary btn-plus" data-index="${index}">+</button>
                    </div>
                </td>
                <td>Rp ${formatRupiah(item.subtotal)}</td>
                <td>
                    <button class="btn btn-sm btn-danger btn-remove" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `);
    });
    
    updateTotal();
}

// Update total
function updateTotal() {
    const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
    $('#total-display').text('Rp ' + formatRupiah(total));
    $('#total-value').val(total);
    hitungKembalian();
}

// Format rupiah
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Tombol plus
$(document).on('click', '.btn-plus', function() {
    const index = $(this).data('index');
    if (cart[index].jumlah < cart[index].stok) {
        cart[index].jumlah++;
        cart[index].subtotal = cart[index].jumlah * cart[index].harga;
        renderCart();
    } else {
        alert('Stok tidak mencukupi!');
    }
});

// Tombol minus
$(document).on('click', '.btn-minus', function() {
    const index = $(this).data('index');
    if (cart[index].jumlah > 1) {
        cart[index].jumlah--;
        cart[index].subtotal = cart[index].jumlah * cart[index].harga;
        renderCart();
    }
});

// Input jumlah manual
$(document).on('change', '.jumlah-input', function() {
    const index = $(this).data('index');
    let jumlah = parseInt($(this).val());
    
    if (jumlah < 1) jumlah = 1;
    if (jumlah > cart[index].stok) {
        jumlah = cart[index].stok;
        alert('Stok tidak mencukupi!');
    }
    
    cart[index].jumlah = jumlah;
    cart[index].subtotal = cart[index].jumlah * cart[index].harga;
    renderCart();
});

// Hapus item
$(document).on('click', '.btn-remove', function() {
    const index = $(this).data('index');
    cart.splice(index, 1);
    renderCart();
});

// Reset keranjang
$('#btn-reset').click(function() {
    if (confirm('Yakin ingin mengosongkan keranjang?')) {
        cart = [];
        renderCart();
        $('#bayar').val('');
        $('#kembalian').val('Rp 0');
    }
});

// Hitung kembalian
$('#bayar').on('input', hitungKembalian);

function hitungKembalian() {
    const total = parseFloat($('#total-value').val());
    const bayar = parseFloat($('#bayar').val()) || 0;
    const kembalian = bayar - total;
    
    if (kembalian >= 0) {
        $('#kembalian').val('Rp ' + formatRupiah(kembalian));
        $('#kembalian').removeClass('text-danger').addClass('text-success');
    } else {
        $('#kembalian').val('Rp ' + formatRupiah(Math.abs(kembalian)) + ' (Kurang)');
        $('#kembalian').removeClass('text-success').addClass('text-danger');
    }
}

// Proses pembayaran
$('#btn-bayar').click(function() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    
    const total = parseFloat($('#total-value').val());
    const bayar = parseFloat($('#bayar').val()) || 0;
    
    if (bayar < total) {
        alert('Jumlah bayar kurang!');
        return;
    }
    
    const kembalian = bayar - total;
    
    if (confirm(`Total: Rp ${formatRupiah(total)}\nBayar: Rp ${formatRupiah(bayar)}\nKembalian: Rp ${formatRupiah(kembalian)}\n\nProses transaksi?`)) {
        const items = cart.map(item => ({
            produk_id: item.id,
            jumlah: item.jumlah,
            harga: item.harga,
            subtotal: item.subtotal
        }));
        
        $.ajax({
            url: 'index.php?page=transaksi&action=simpan',
            method: 'POST',
            data: {
                total: total,
                bayar: bayar,
                kembalian: kembalian,
                items: JSON.stringify(items)
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Transaksi berhasil!\nKode: ' + response.kode_transaksi);
                    cart = [];
                    renderCart();
                    $('#bayar').val('');
                    $('#kembalian').val('Rp 0');
                } else {
                    alert('Gagal menyimpan transaksi: ' + response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan transaksi!');
            }
        });
    }
});

// Search produk
$('#search-produk').on('input', function() {
    const search = $(this).val().toLowerCase();
    $('.produk-item').each(function() {
        const nama = $(this).data('nama').toLowerCase();
        const kode = $(this).data('kode').toLowerCase();
        
        if (nama.includes(search) || kode.includes(search)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});
</script>

