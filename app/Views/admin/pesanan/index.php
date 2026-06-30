<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert-chip success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashData('success') ?>
        <button class="alert-chip-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <div class="small fw-semibold mb-1" style="color:#f59e0b; letter-spacing:.1em; text-transform:uppercase;">
            Manajemen Transaksi
        </div>
        <h1 class="h4 fw-bold mb-0" style="letter-spacing:-.03em;">Pesanan Masuk</h1>
        <div class="small mt-1" style="color:var(--muted);">
            Total <?= count($transactions) ?> pesanan ditemukan · Klik status untuk memperbaruinya.
        </div>
    </div>

    <!-- Filter tabs -->
    <div class="filter-tabs">
        <a href="?status=all" class="filter-tab <?= ($filterStatus === 'all') ? 'active' : '' ?>">
            Semua <span class="tab-count"><?= count($transactions) ?></span>
        </a>
        <a href="?status=0" class="filter-tab <?= ($filterStatus === '0') ? 'active' : '' ?>">
            Pending <span class="tab-count" style="background:#fef9c3; color:#713f12;"><?= $countByStatus[0] ?? 0 ?></span>
        </a>
        <a href="?status=1" class="filter-tab <?= ($filterStatus === '1') ? 'active' : '' ?>">
            Diproses <span class="tab-count" style="background:#dbeafe; color:#1e40af;"><?= $countByStatus[1] ?? 0 ?></span>
        </a>
        <a href="?status=2" class="filter-tab <?= ($filterStatus === '2') ? 'active' : '' ?>">
            Selesai <span class="tab-count" style="background:#dcfce7; color:#14532d;"><?= $countByStatus[2] ?? 0 ?></span>
        </a>
    </div>
</div>

<!-- Orders List -->
<?php if (empty($transactions)) : ?>
    <div class="card-surface text-center py-5" style="color:var(--muted);">
        <i class="bi bi-inbox" style="font-size:3rem; opacity:.3; display:block; margin-bottom:16px;"></i>
        <div class="fw-semibold">Tidak ada pesanan untuk filter ini.</div>
    </div>
<?php else : ?>
    <div class="orders-grid">
        <?php foreach ($transactions as $trx) : ?>
            <?php
            $sc = match ((int)$trx['status']) { 0=>'pending', 1=>'diproses', 2=>'selesai', default=>'pending' };
            $sl = match ((int)$trx['status']) { 0=>'Menunggu Konfirmasi', 1=>'Sedang Diproses', 2=>'Selesai', default=>'Pending' };
            $mi = match ($trx['metode_pembayaran'] ?? '') {
                'Transfer Bank' => 'bi-bank2',
                'QRIS'          => 'bi-qr-code-scan',
                'COD'           => 'bi-cash-coin',
                default         => 'bi-credit-card',
            };
            ?>
            <div class="order-card-admin">
                <!-- Card Header -->
                <div class="oca-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="order-num-badge">#<?= str_pad($trx['id'], 4, '0', STR_PAD_LEFT) ?></div>
                        <span class="oca-status <?= $sc ?>"><?= $sl ?></span>
                    </div>
                    <div class="small" style="color:var(--muted);">
                        <?= date('d M Y · H:i', strtotime($trx['created_at'])) ?>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="oca-body">
                    <!-- Customer info -->
                    <div class="oca-customer">
                        <div class="oca-avatar"><?= strtoupper(substr($trx['username'], 0, 1)) ?></div>
                        <div>
                            <div class="fw-bold" style="font-size:.9rem;"><?= esc($trx['username']) ?></div>
                            <div class="small" style="color:var(--muted);">
                                <i class="bi bi-telephone me-1"></i><?= esc($trx['telepon'] ?? '-') ?>
                            </div>
                            <div class="small" style="color:var(--muted); margin-top:2px;">
                                <i class="bi bi-geo-alt me-1"></i><?= esc(substr($trx['alamat'] ?? '-', 0, 50)) ?>...
                            </div>
                        </div>
                    </div>

                    <!-- Items (maks 2) -->
                    <?php if (!empty($trx['details'])) : ?>
                        <div class="oca-items">
                            <?php foreach (array_slice($trx['details'], 0, 3) as $d) : ?>
                                <div class="oca-item-chip">
                                    <div class="oca-item-img">
                                        <img src="<?= base_url('img/' . ($d['foto'] ?? '')) ?>"
                                             onerror="this.style.display='none'">
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:.82rem;"><?= esc($d['nama'] ?? '-') ?></div>
                                        <div class="small" style="color:var(--muted);">
                                            <?= $d['jumlah'] ?>x · <?= 'Rp ' . number_format($d['subtotal_harga'], 0, ',', '.') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($trx['details']) > 3) : ?>
                                <div class="small" style="color:var(--muted); padding:4px 8px;">
                                    +<?= count($trx['details']) - 3 ?> item lainnya...
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Card Footer -->
                <div class="oca-footer">
                    <div>
                        <div class="small" style="color:var(--muted);">Total Pembayaran</div>
                        <div class="fw-bold" style="color:var(--primary); font-size:1rem;">
                            Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?>
                        </div>
                        <div class="small" style="color:var(--muted); margin-top:2px;">
                            <i class="bi <?= $mi ?> me-1"></i><?= esc($trx['metode_pembayaran'] ?? 'COD') ?>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button class="btn-detail-modal"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-<?= $trx['id'] ?>">
                            <i class="bi bi-eye me-1"></i> Detail
                        </button>
                        <?php if ((int)$trx['status'] < 2) : ?>
                            <a href="<?= site_url('admin/dashboard/update-status/' . $trx['id']) ?>"
                               class="btn-update-status"
                               onclick="return confirm('Update status pesanan ini?')">
                                <i class="bi bi-arrow-right-circle me-1"></i>
                                <?= (int)$trx['status'] === 0 ? 'Konfirmasi' : 'Selesaikan' ?>
                            </a>
                        <?php else : ?>
                            <span class="btn-done">
                                <i class="bi bi-check-all me-1"></i> Selesai
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="modal-<?= $trx['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header border-0 p-0">
                            <div class="w-100 px-4 py-3 d-flex align-items-center justify-content-between"
                                 style="background:linear-gradient(135deg,#0f1923,#1b3a5c); border-radius:16px 16px 0 0;">
                                <div>
                                    <div class="fw-bold text-white" style="font-size:1rem;">
                                        <i class="bi bi-receipt-cutoff me-2" style="color:#f59e0b;"></i>
                                        Detail Pesanan #<?= str_pad($trx['id'], 4, '0', STR_PAD_LEFT) ?>
                                    </div>
                                    <div class="small" style="color:rgba(255,255,255,.5);">
                                        <?= date('d M Y, H:i', strtotime($trx['created_at'])) ?>
                                    </div>
                                </div>
                                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <div class="mic-label">Informasi Pelanggan</div>
                                        <div class="mic-row"><strong>Username</strong><span><?= esc($trx['username']) ?></span></div>
                                        <div class="mic-row"><strong>Penerima</strong><span><?= esc($trx['nama_penerima'] ?? '-') ?></span></div>
                                        <div class="mic-row"><strong>Telepon</strong><span><?= esc($trx['telepon'] ?? '-') ?></span></div>
                                        <div class="mic-row"><strong>Alamat</strong><span><?= esc($trx['alamat'] ?? '-') ?></span></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <div class="mic-label">Informasi Pembayaran</div>
                                        <div class="mic-row"><strong>Metode</strong>
                                            <span><i class="bi <?= $mi ?> me-1"></i><?= esc($trx['metode_pembayaran'] ?? '-') ?></span>
                                        </div>
                                        <div class="mic-row"><strong>Ongkir</strong><span>Rp <?= number_format($trx['ongkir'], 0, ',', '.') ?></span></div>
                                        <div class="mic-row"><strong>Total</strong>
                                            <span class="fw-bold" style="color:var(--primary);">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></span>
                                        </div>
                                        <div class="mic-row"><strong>Status</strong>
                                            <span class="status-dot <?= $sc ?>"><?= $sl ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mic-label mb-2">Item Pesanan</div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-bordered rounded-3 overflow-hidden">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Layanan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trx['details'] as $d) : ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php if (!empty($d['foto'])) : ?>
                                                            <img src="<?= base_url('img/' . $d['foto']) ?>"
                                                                 style="width:36px; height:36px; border-radius:8px; object-fit:cover;"
                                                                 onerror="this.style.display='none'">
                                                        <?php endif; ?>
                                                        <span class="fw-semibold"><?= esc($d['nama'] ?? '-') ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border"><?= $d['jumlah'] ?></span>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    Rp <?= number_format($d['subtotal_harga'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <?php if ((int)$trx['status'] < 2) : ?>
                                <a href="<?= site_url('admin/dashboard/update-status/' . $trx['id']) ?>"
                                   class="btn btn-sm rounded-pill px-4 fw-bold text-white"
                                   style="background:linear-gradient(135deg,#f59e0b,#d97706);"
                                   onclick="return confirm('Update status pesanan ini?')">
                                    <?= (int)$trx['status'] === 0 ? 'Konfirmasi Pesanan' : 'Tandai Selesai' ?>
                                </a>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
/* Filter Tabs */
.filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-tab {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 10px;
    font-size: .82rem; font-weight: 600; text-decoration: none;
    color: var(--muted); background: var(--surface);
    border: 1px solid var(--line); transition: all .18s;
}
.filter-tab:hover { border-color: #f59e0b; color: var(--text); }
.filter-tab.active {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; border-color: transparent;
    box-shadow: 0 4px 14px rgba(245,158,11,.3);
}
.tab-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 20px; height: 20px; border-radius: 999px;
    background: rgba(255,255,255,.25); color: inherit;
    font-size: .7rem; font-weight: 800; padding: 0 5px;
}
.filter-tab:not(.active) .tab-count { background: #f0f4f8; color: var(--muted); }

/* Orders Grid */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 16px;
}

/* Order Card */
.order-card-admin {
    background: var(--surface); border: 1px solid var(--line);
    border-radius: var(--radius); overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.order-card-admin:hover { box-shadow: var(--shadow); transform: translateY(-2px); }

.oca-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 18px; background: #fafbfc;
    border-bottom: 1px solid var(--line);
}
.order-num-badge {
    font-family: monospace; font-weight: 800; font-size: .88rem;
    color: var(--primary); background: rgba(27,58,92,.07);
    padding: 3px 10px; border-radius: 7px;
}
.oca-status { font-size: .75rem; font-weight: 700; padding: 4px 11px; border-radius: 999px; }
.oca-status.pending  { background: #fef9c3; color: #713f12; }
.oca-status.diproses { background: #dbeafe; color: #1e40af; }
.oca-status.selesai  { background: #dcfce7; color: #14532d; }

.oca-body { padding: 16px 18px; }

.oca-customer { display: flex; gap: 12px; margin-bottom: 14px; }
.oca-avatar {
    width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg, #0f1923, #1b3a5c);
    color: #f59e0b; font-weight: 800; font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
}

.oca-items { display: flex; flex-direction: column; gap: 6px; }
.oca-item-chip {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 12px; background: #f8f9fb;
    border: 1px solid var(--line); border-radius: 11px;
}
.oca-item-img {
    width: 36px; height: 36px; border-radius: 8px;
    background: #eef4ff; overflow: hidden; flex-shrink: 0;
}
.oca-item-img img { width: 100%; height: 100%; object-fit: cover; }

.oca-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 18px; border-top: 1px solid var(--line); background: #fafbfc;
    flex-wrap: wrap; gap: 10px;
}
.btn-detail-modal, .btn-update-status, .btn-done {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 7px 16px; border-radius: 9px;
    font-size: .8rem; font-weight: 700; cursor: pointer;
    text-decoration: none; transition: all .15s;
    white-space: nowrap; border: none;
}
.btn-detail-modal {
    background: #f0f4f8; color: var(--text);
    border: 1px solid var(--line);
}
.btn-detail-modal:hover { background: #e4e9f0; color: var(--text); }
.btn-update-status {
    background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff;
    box-shadow: 0 3px 10px rgba(245,158,11,.3);
}
.btn-update-status:hover { opacity: .88; color: #fff; }
.btn-done { background: #ecfdf5; color: #059669; cursor: default; }

/* Modal info cards */
.modal-info-card {
    background: #f8f9fb; border: 1px solid var(--line);
    border-radius: 14px; padding: 16px; height: 100%;
}
.mic-label {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); margin-bottom: 10px;
}
.mic-row {
    display: flex; justify-content: space-between; gap: 12px;
    padding: 6px 0; border-bottom: 1px dashed var(--line);
    font-size: .85rem;
}
.mic-row:last-child { border-bottom: none; }
.mic-row strong { color: var(--muted); font-weight: 600; flex-shrink: 0; }
.mic-row span { text-align: right; }

/* Status dots for modal */
.status-dot { font-size: .75rem; font-weight: 700; padding: 3px 10px; border-radius: 999px; display: inline-block; }
.status-dot.pending  { background: #fef9c3; color: #713f12; }
.status-dot.diproses { background: #dbeafe; color: #1e40af; }
.status-dot.selesai  { background: #dcfce7; color: #14532d; }

@media (max-width: 600px) {
    .orders-grid { grid-template-columns: 1fr; }
}
</style>

<?= $this->endSection() ?>
