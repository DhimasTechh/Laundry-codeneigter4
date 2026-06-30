<?= $this->extend('layout/user_main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <div class="small text-uppercase fw-semibold mb-2" style="letter-spacing:.13em; color:var(--muted);">Checkout</div>
        <h1 class="h3 mb-1 fw-bold" style="letter-spacing:-.03em;">Konfirmasi Pesanan</h1>
        <div style="color:var(--muted);">Lengkapi informasi pengiriman dan pilih metode pembayaran.</div>
    </div>
    <a href="<?= site_url('keranjang') ?>" class="pill">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
    </a>
</div>

<div class="row g-4">

    <!-- Left: Form Data Pengiriman -->
    <div class="col-12 col-lg-7">
        <?= form_open('keranjang/checkout', ['id' => 'form-checkout']) ?>

        <!-- Data Penerima -->
        <div class="checkout-card mb-4">
            <div class="checkout-card-header">
                <div class="step-badge">1</div>
                <div>
                    <div class="fw-bold">Data Penerima</div>
                    <div class="small" style="color:var(--muted);">Siapa yang akan menerima cucian bersih?</div>
                </div>
            </div>
            <div class="checkout-card-body">
                <div class="mb-3">
                    <label for="nama_penerima" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="nama_penerima" name="nama_penerima"
                        class="form-ctrl" placeholder="Masukkan nama penerima" required
                        value="<?= esc(session()->get('username') ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                    <div class="input-prefix-wrap">
                        <span class="input-prefix">+62</span>
                        <input type="tel" id="telepon" name="telepon"
                            class="form-ctrl with-prefix" placeholder="812-xxxx-xxxx" required>
                    </div>
                </div>
                <div>
                    <label for="alamat" class="form-label fw-semibold">Alamat Pengambilan & Pengiriman <span class="text-danger">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-ctrl"
                        rows="3" placeholder="Masukkan alamat lengkap termasuk kota dan kode pos" required></textarea>
                    <div class="form-hint">Tim kami akan menjemput dan mengantar cucian ke alamat ini.</div>
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="checkout-card mb-4">
            <div class="checkout-card-header">
                <div class="step-badge">2</div>
                <div>
                    <div class="fw-bold">Metode Pembayaran</div>
                    <div class="small" style="color:var(--muted);">Pilih cara pembayaran yang paling nyaman.</div>
                </div>
            </div>
            <div class="checkout-card-body">
                <div class="payment-options">

                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="Transfer Bank" required>
                        <div class="payment-option-inner">
                            <div class="payment-icon" style="background:#eff6ff; color:#1d4ed8;">
                                <i class="bi bi-bank2"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Transfer Bank</div>
                                <div class="small" style="color:var(--muted);">BCA, BNI, Mandiri, BRI</div>
                            </div>
                            <div class="payment-check ms-auto"><i class="bi bi-check-lg"></i></div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="QRIS">
                        <div class="payment-option-inner">
                            <div class="payment-icon" style="background:#f0fdf4; color:#16a34a;">
                                <i class="bi bi-qr-code-scan"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">QRIS</div>
                                <div class="small" style="color:var(--muted);">GoPay, OVO, Dana, ShopeePay</div>
                            </div>
                            <div class="payment-check ms-auto"><i class="bi bi-check-lg"></i></div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="COD">
                        <div class="payment-option-inner">
                            <div class="payment-icon" style="background:#fefce8; color:#ca8a04;">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">COD (Bayar di Tempat)</div>
                                <div class="small" style="color:var(--muted);">Bayar saat pengambilan cucian</div>
                            </div>
                            <div class="payment-check ms-auto"><i class="bi bi-check-lg"></i></div>
                        </div>
                    </label>

                </div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-confirm-order" id="btn-confirm">
            <i class="bi bi-shield-check me-2"></i>
            Konfirmasi &amp; Pesan Sekarang
            <i class="bi bi-arrow-right ms-2"></i>
        </button>

        <?= form_close() ?>
    </div>

    <!-- Right: Ringkasan Pesanan -->
    <div class="col-12 col-lg-5">
        <div class="order-summary sticky-top" style="top: 20px;">
            <div class="order-summary-header">
                <i class="bi bi-receipt me-2"></i>
                Ringkasan Pesanan
            </div>
            <div class="order-summary-body">

                <!-- Item list -->
                <?php foreach ($items as $item) : ?>
                    <div class="order-item">
                        <div class="order-item-img">
                            <img src="<?= base_url('img/' . $item['options']['foto']) ?>" alt="<?= esc($item['name']) ?>">
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold"><?= esc($item['name']) ?></div>
                            <div class="small" style="color:var(--muted);">x<?= $item['qty'] ?></div>
                        </div>
                        <div class="fw-semibold text-end"><?= number_to_currency($item['subtotal'], 'IDR') ?></div>
                    </div>
                <?php endforeach; ?>

                <hr style="border-color:var(--line); margin:16px 0;">

                <!-- Price breakdown -->
                <div class="price-row">
                    <span style="color:var(--muted);">Subtotal Layanan</span>
                    <span class="fw-semibold"><?= number_to_currency($total, 'IDR') ?></span>
                </div>
                <div class="price-row">
                    <span style="color:var(--muted);">Ongkos Kirim</span>
                    <span class="fw-semibold"><?= number_to_currency($ongkir, 'IDR') ?></span>
                </div>
                <div class="price-row total-row">
                    <span class="fw-bold fs-5">Total Pembayaran</span>
                    <span class="fw-bold fs-5" style="color:var(--brand);"><?= number_to_currency($grand_total, 'IDR') ?></span>
                </div>

                <div class="order-guarantee">
                    <i class="bi bi-shield-fill-check text-success me-2"></i>
                    Pesanan dijamin aman. Data pribadi kamu terlindungi.
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Checkout Card */
    .checkout-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .checkout-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 24px;
        border-bottom: 1px solid var(--line);
        background: #fafbfc;
    }

    .step-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: #fff;
        font-weight: 800;
        font-size: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(27, 75, 114, 0.3);
    }

    .checkout-card-body { padding: 24px; }

    /* Form Controls */
    .form-label { font-size: .9rem; margin-bottom: 6px; }

    .form-ctrl {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--line);
        border-radius: 14px;
        font-family: 'Manrope', sans-serif;
        font-size: .95rem;
        color: var(--text);
        background: #fff;
        outline: none;
        transition: border-color .2s;
    }

    .form-ctrl:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(27, 75, 114, 0.08); }

    textarea.form-ctrl { resize: vertical; min-height: 90px; }

    .form-hint { font-size: .83rem; color: var(--muted); margin-top: 6px; }

    .input-prefix-wrap { position: relative; display: flex; }

    .input-prefix {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        background: #f4f6f8;
        border: 1.5px solid var(--line);
        border-right: none;
        border-radius: 14px 0 0 14px;
        font-weight: 700;
        color: var(--muted);
        font-size: .95rem;
        white-space: nowrap;
    }

    .form-ctrl.with-prefix { border-radius: 0 14px 14px 0; }

    /* Payment Options */
    .payment-options { display: flex; flex-direction: column; gap: 10px; }

    .payment-option { cursor: pointer; }
    .payment-option input[type="radio"] { display: none; }

    .payment-option-inner {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border: 1.5px solid var(--line);
        border-radius: 16px;
        transition: all .2s;
    }

    .payment-option:hover .payment-option-inner { border-color: var(--brand); background: #f8fbff; }

    .payment-option input:checked + .payment-option-inner {
        border-color: var(--brand);
        background: #eef4ff;
        box-shadow: 0 0 0 3px rgba(27, 75, 114, 0.08);
    }

    .payment-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .payment-check {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        color: transparent;
        transition: all .2s;
        flex-shrink: 0;
    }

    .payment-option input:checked + .payment-option-inner .payment-check {
        background: var(--brand);
        border-color: var(--brand);
        color: white;
    }

    /* Confirm Button */
    .btn-confirm-order {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 16px 28px;
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        border: none;
        border-radius: 999px;
        font-weight: 800;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all .2s ease;
        box-shadow: 0 8px 24px rgba(27, 75, 114, 0.3);
        font-family: 'Manrope', sans-serif;
    }

    .btn-confirm-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(27, 75, 114, 0.4);
    }

    .btn-confirm-order:active { transform: translateY(0); }

    /* Order Summary */
    .order-summary {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .order-summary-header {
        padding: 16px 22px;
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }

    .order-summary-body { padding: 20px 22px; }

    .order-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed var(--line);
    }

    .order-item:last-of-type { border-bottom: none; }

    .order-item-img {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f3f7fc;
        border: 1px solid var(--line);
    }

    .order-item-img img { width: 100%; height: 100%; object-fit: cover; }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        font-size: .95rem;
    }

    .total-row {
        padding-top: 14px;
        margin-top: 8px;
        border-top: 2px solid var(--line);
    }

    .order-guarantee {
        margin-top: 18px;
        padding: 12px 14px;
        background: #f0fdf4;
        border-radius: 12px;
        font-size: .85rem;
        color: #166534;
        display: flex;
        align-items: center;
    }
</style>

<script>
    // Auto-submit prevention + loading state
    document.getElementById('form-checkout').addEventListener('submit', function () {
        const btn = document.getElementById('btn-confirm');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses pesanan...';
    });
</script>

<?= $this->endSection() ?>
