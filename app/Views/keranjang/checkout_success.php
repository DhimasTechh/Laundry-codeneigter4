<?= $this->extend('layout/user_main') ?>
<?= $this->section('content') ?>

<div class="success-wrap">

    <!-- Confetti Animation -->
    <div class="confetti-wrap" id="confetti-wrap"></div>

    <div class="success-card">
        <!-- Icon -->
        <div class="success-icon-ring">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
        </div>

        <h1 class="success-title">Pesanan Berhasil! 🎉</h1>
        <p class="success-subtitle">
            Terima kasih telah mempercayakan laundry Anda kepada kami.<br>
            Tim kami akan segera memproses pesananmu.
        </p>

        <!-- Order Details -->
        <div class="order-detail-box">
            <div class="order-detail-row">
                <span class="order-detail-label"><i class="bi bi-hash me-1"></i> No. Transaksi</span>
                <span class="order-detail-value">#TRX-<?= str_pad($data['transaction_id'], 5, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="order-detail-row">
                <span class="order-detail-label"><i class="bi bi-cash me-1"></i> Total Bayar</span>
                <span class="order-detail-value fw-bold" style="color:var(--brand);"><?= number_to_currency($data['total'], 'IDR') ?></span>
            </div>
            <div class="order-detail-row">
                <span class="order-detail-label"><i class="bi bi-credit-card me-1"></i> Metode Pembayaran</span>
                <span class="order-detail-value">
                    <?php
                    $metodeIcon = match ($data['metode']) {
                        'Transfer Bank' => 'bi-bank2',
                        'QRIS'          => 'bi-qr-code-scan',
                        'COD'           => 'bi-cash-coin',
                        default         => 'bi-credit-card',
                    };
                    ?>
                    <i class="bi <?= $metodeIcon ?> me-1"></i>
                    <?= esc($data['metode']) ?>
                </span>
            </div>
            <div class="order-detail-row">
                <span class="order-detail-label"><i class="bi bi-clock me-1"></i> Status</span>
                <span class="status-badge pending">Menunggu Konfirmasi</span>
            </div>
        </div>

        <!-- Info -->
        <div class="info-steps">
            <div class="info-step">
                <div class="info-step-icon" style="background:#eff6ff; color:#1d4ed8;">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="info-step-text">Kami akan menghubungi kamu untuk konfirmasi jadwal penjemputan.</div>
            </div>
            <div class="info-step">
                <div class="info-step-icon" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="info-step-text">Kurir akan menjemput cucian dan mengantarkan kembali setelah selesai.</div>
            </div>
            <?php if ($data['metode'] === 'Transfer Bank') : ?>
            <div class="info-step">
                <div class="info-step-icon" style="background:#fefce8; color:#ca8a04;">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div class="info-step-text">Silakan transfer ke rekening BCA <strong>1234567890</strong> a.n. <strong>Premium Laundry</strong> dengan nominal tepat.</div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="success-actions">
            <a href="<?= site_url('my-orders') ?>" class="btn-primary-action">
                <i class="bi bi-receipt-cutoff me-2"></i>
                Lihat Riwayat Pesanan
            </a>
            <a href="<?= site_url('/') ?>" class="btn-secondary-action">
                <i class="bi bi-grid me-2"></i>
                Kembali ke Katalog
            </a>
        </div>
    </div>

</div>

<style>
    .success-wrap {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        position: relative;
        overflow: hidden;
    }

    .confetti-wrap {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .success-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 32px;
        padding: 48px 44px;
        max-width: 540px;
        width: 100%;
        text-align: center;
        position: relative;
        z-index: 1;
        box-shadow: 0 24px 60px rgba(17, 24, 39, 0.08);
    }

    /* Success Icon */
    .success-icon-ring {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(27, 75, 114, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        animation: pulse-ring 2s ease infinite;
    }

    .success-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brand), #2563a8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: 0 8px 24px rgba(27, 75, 114, 0.4);
        animation: pop-in .5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes pulse-ring {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.06); opacity: .8; }
    }

    @keyframes pop-in {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .success-title {
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: -.04em;
        margin-bottom: 10px;
        color: var(--text);
    }

    .success-subtitle {
        color: var(--muted);
        margin-bottom: 28px;
        line-height: 1.6;
    }

    /* Order Detail Box */
    .order-detail-box {
        background: #f8f9fb;
        border-radius: 18px;
        padding: 20px;
        text-align: left;
        margin-bottom: 24px;
        border: 1px solid var(--line);
    }

    .order-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed var(--line);
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-detail-row:last-child { border-bottom: none; }

    .order-detail-label {
        font-size: .88rem;
        color: var(--muted);
        flex-shrink: 0;
    }

    .order-detail-value {
        font-weight: 600;
        font-size: .9rem;
        color: var(--text);
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 700;
    }

    .status-badge.pending { background: #fef9c3; color: #713f12; border: 1px solid #fde68a; }

    /* Info Steps */
    .info-steps {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 28px;
        text-align: left;
    }

    .info-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 14px;
        background: white;
        border-radius: 14px;
        border: 1px solid var(--line);
    }

    .info-step-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-step-text {
        font-size: .88rem;
        color: var(--muted);
        line-height: 1.5;
        padding-top: 8px;
    }

    /* Actions */
    .success-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-primary-action, .btn-secondary-action {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px 24px;
        border-radius: 999px;
        font-weight: 700;
        font-size: .95rem;
        text-decoration: none;
        transition: all .2s ease;
    }

    .btn-primary-action {
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        box-shadow: 0 6px 20px rgba(27, 75, 114, 0.3);
    }

    .btn-primary-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(27, 75, 114, 0.4);
        color: white;
    }

    .btn-secondary-action {
        background: white;
        color: var(--text);
        border: 1.5px solid var(--line);
    }

    .btn-secondary-action:hover {
        background: #f2f6fb;
        border-color: #d1d9e6;
        color: var(--text);
    }

    @media (max-width: 576px) {
        .success-card { padding: 32px 22px; }
        .success-title { font-size: 1.5rem; }
    }
</style>

<script>
// Simple confetti animation
(function() {
    const wrap = document.getElementById('confetti-wrap');
    const colors = ['#1b4b72', '#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6'];

    for (let i = 0; i < 60; i++) {
        const confetti = document.createElement('div');
        const size = Math.random() * 10 + 6;
        confetti.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: ${colors[Math.floor(Math.random() * colors.length)]};
            border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
            left: ${Math.random() * 100}%;
            top: -20px;
            opacity: ${Math.random() * 0.7 + 0.3};
            animation: fall-${i} ${Math.random() * 2 + 2}s ease-in ${Math.random() * 1.5}s forwards;
        `;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall-${i} {
                0% { top: -20px; transform: rotate(0deg) translateX(0); opacity: 1; }
                100% { top: 110vh; transform: rotate(${Math.random() * 720 - 360}deg) translateX(${Math.random() * 200 - 100}px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
        wrap.appendChild(confetti);
    }
})();
</script>

<?= $this->endSection() ?>
