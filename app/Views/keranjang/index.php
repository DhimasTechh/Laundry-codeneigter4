<?= $this->extend('layout/user_main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <div class="small text-uppercase fw-semibold mb-2" style="letter-spacing:.13em; color:var(--muted);">Transaksi</div>
        <h1 class="h3 mb-1 fw-bold" style="letter-spacing:-.03em;">Keranjang Pembelian</h1>
        <div style="color:var(--muted);">Review layanan, ubah jumlah, lalu lanjutkan proses transaksi.</div>
    </div>
    <a href="<?= site_url('/') ?>" class="pill">
        <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
    </a>
</div>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert-pill success mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= session()->getFlashData('success') ?>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')) : ?>
    <div class="alert-pill danger mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i>
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>

<?= form_open('keranjang/edit', ['id' => 'form-keranjang']) ?>

<?php if (!empty($items)) : ?>
<div class="cart-table-wrap mb-4">
    <div class="table-responsive">
        <table class="table cart-table align-middle mb-0">
            <thead>
                <tr>
                    <th style="min-width:220px;">Layanan</th>
                    <th>Harga Satuan</th>
                    <th style="min-width:180px;">Jumlah</th>
                    <th>Subtotal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="cart-img-wrap">
                                    <img src="<?= base_url('img/' . $item['options']['foto']) ?>" alt="<?= esc($item['name']) ?>">
                                </div>
                                <div>
                                    <div class="fw-semibold"><?= esc($item['name']) ?></div>
                                    <div class="small" style="color:var(--muted);">Layanan Premium</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold"><?= number_to_currency($item['price'], 'IDR') ?></td>
                        <td>
                            <div class="qty-group" data-qty-group>
                                <button class="qty-btn" type="button" data-qty-action="decrease" data-target="qty-<?= $i ?>">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" min="1" name="qty<?= $i++ ?>" id="qty-<?= $i - 1 ?>"
                                    class="qty-input" value="<?= $item['qty'] ?>">
                                <button class="qty-btn" type="button" data-qty-action="increase" data-target="qty-<?= $i - 1 ?>">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td class="fw-bold" style="color:var(--brand);"><?= number_to_currency($item['subtotal'], 'IDR') ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('keranjang/delete/' . $item['rowid']) ?>"
                                class="btn-hapus"
                                onclick="return confirm('Hapus item ini dari keranjang?')"
                                title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Summary & Actions -->
<div class="cart-footer">
    <div class="cart-total-box">
        <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--muted);">Subtotal Layanan</span>
            <span class="fw-semibold"><?= number_to_currency($total, 'IDR') ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--muted);">Estimasi Ongkir</span>
            <span class="fw-semibold">Rp 10.000</span>
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between">
            <span class="fw-bold fs-5">Total</span>
            <span class="fw-bold fs-5" style="color:var(--brand);">
                <?= number_to_currency($total + 10000, 'IDR') ?>
            </span>
        </div>
    </div>

    <div class="cart-actions">
        <button type="submit" class="btn-update" id="btn-update-cart">
            <i class="bi bi-arrow-clockwise me-1"></i> Perbarui
        </button>
        <a href="<?= site_url('keranjang/clear') ?>"
            class="btn-clear"
            onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
            <i class="bi bi-trash me-1"></i> Kosongkan
        </a>
        <a href="<?= site_url('keranjang/checkout') ?>" class="btn-checkout" id="btn-checkout">
            <i class="bi bi-bag-check me-2"></i> Checkout
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<?php else : ?>
<!-- Empty State -->
<div class="cart-empty">
    <div class="cart-empty-icon">
        <i class="bi bi-bag-x"></i>
    </div>
    <h3>Keranjang Masih Kosong</h3>
    <p>Belum ada layanan yang ditambahkan. Pilih layanan laundry favoritmu sekarang!</p>
    <a href="<?= site_url('/') ?>" class="btn-checkout">
        <i class="bi bi-grid me-2"></i> Lihat Katalog Layanan
    </a>
</div>
<?php endif; ?>

<?= form_close() ?>

<style>
    /* Alert Pill */
    .alert-pill {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        border-radius: 16px;
        font-weight: 600;
        font-size: .95rem;
        position: relative;
    }
    .alert-pill.success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .alert-pill.danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: inherit;
        opacity: .6;
    }

    /* Table */
    .cart-table-wrap {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--line);
        overflow: hidden;
    }

    .cart-table thead tr {
        background: #f8f9fb;
    }

    .cart-table th {
        padding: 14px 20px;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--muted);
        font-weight: 700;
        border-bottom: 1px solid var(--line);
    }

    .cart-table td {
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
    }

    .cart-table tbody tr:last-child td {
        border-bottom: none;
    }

    .cart-table tbody tr {
        transition: background .15s;
    }

    .cart-table tbody tr:hover {
        background: #fafbfc;
    }

    /* Cart image */
    .cart-img-wrap {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f3f7fc;
        border: 1px solid var(--line);
    }

    .cart-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Qty Controls */
    .qty-group {
        display: flex;
        align-items: center;
        border: 1px solid var(--line);
        border-radius: 12px;
        overflow: hidden;
        width: fit-content;
    }

    .qty-btn {
        background: #f4f6f8;
        border: none;
        padding: 8px 14px;
        cursor: pointer;
        color: var(--text);
        font-size: 1rem;
        transition: background .15s;
    }

    .qty-btn:hover { background: #e8ecf0; }

    .qty-input {
        border: none;
        border-left: 1px solid var(--line);
        border-right: 1px solid var(--line);
        width: 52px;
        text-align: center;
        font-weight: 700;
        font-size: .95rem;
        padding: 8px 4px;
        outline: none;
        background: white;
        color: var(--text);
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }

    /* Delete button */
    .btn-hapus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fef2f2;
        color: #dc2626;
        text-decoration: none;
        font-size: 1rem;
        transition: all .2s;
    }

    .btn-hapus:hover {
        background: #fecaca;
        color: #991b1b;
        transform: scale(1.08);
    }

    /* Cart Footer */
    .cart-footer {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
        justify-content: space-between;
    }

    .cart-total-box {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 22px 28px;
        min-width: 300px;
        flex: 1;
        max-width: 420px;
    }

    .cart-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        justify-content: flex-end;
        flex: 1;
    }

    /* Buttons */
    .btn-update, .btn-clear, .btn-checkout {
        display: inline-flex;
        align-items: center;
        padding: 12px 22px;
        border-radius: 999px;
        font-weight: 700;
        font-size: .95rem;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s ease;
        border: none;
    }

    .btn-update {
        background: white;
        color: var(--text);
        border: 1px solid var(--line);
    }
    .btn-update:hover { background: #f2f6fb; border-color: #d1d9e6; }

    .btn-clear {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .btn-clear:hover { background: #fecaca; }

    .btn-checkout {
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        box-shadow: 0 6px 20px rgba(27, 75, 114, 0.3);
        padding: 12px 28px;
    }
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(27, 75, 114, 0.4);
        color: white;
    }

    /* Empty state */
    .cart-empty {
        text-align: center;
        padding: 72px 20px;
    }

    .cart-empty-icon {
        font-size: 5rem;
        color: #d1d9e6;
        margin-bottom: 20px;
        line-height: 1;
    }

    .cart-empty h3 {
        font-weight: 800;
        margin-bottom: 10px;
        color: var(--text);
        letter-spacing: -.03em;
    }

    .cart-empty p {
        color: var(--muted);
        margin-bottom: 28px;
        max-width: 380px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 768px) {
        .cart-footer { flex-direction: column; }
        .cart-total-box { max-width: 100%; min-width: 0; width: 100%; }
        .cart-actions { justify-content: stretch; width: 100%; }
        .btn-checkout, .btn-update, .btn-clear { flex: 1; justify-content: center; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Qty +/- buttons
    document.querySelectorAll('[data-qty-action]').forEach(function (button) {
        button.addEventListener('click', function () {
            var targetId = this.getAttribute('data-target');
            var input = document.getElementById(targetId);
            if (!input) return;

            var minValue = parseInt(input.getAttribute('min') || '1', 10);
            var currentValue = parseInt(input.value || minValue, 10);
            var delta = this.getAttribute('data-qty-action') === 'increase' ? 1 : -1;
            input.value = Math.max(minValue, currentValue + delta);
        });
    });
});
</script>

<?= $this->endSection() ?>
