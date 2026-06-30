<?= $this->extend('layout/user_main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <div class="small text-uppercase fw-semibold mb-2" style="letter-spacing:.13em; color:var(--muted);">Akun Saya</div>
        <h1 class="h3 mb-1 fw-bold" style="letter-spacing:-.03em;">Riwayat Pesanan</h1>
        <div style="color:var(--muted);">Pantau status laundry dan riwayat transaksi kamu.</div>
    </div>
    <a href="<?= site_url('/') ?>" class="pill">
        <i class="bi bi-plus me-1"></i> Tambah Pesanan Baru
    </a>
</div>

<?php if (empty($transactions)) : ?>
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-receipt"></i></div>
        <h3>Belum Ada Pesanan</h3>
        <p>Kamu belum pernah melakukan transaksi. Yuk, mulai pesan layanan laundry sekarang!</p>
        <a href="<?= site_url('/') ?>" class="btn-action-primary">
            <i class="bi bi-grid me-2"></i> Lihat Katalog Layanan
        </a>
    </div>

<?php else : ?>

    <!-- Stats Row -->
    <div class="stats-row mb-4">
        <?php
        $totalTrx      = count($transactions);
        $totalBayar    = array_sum(array_column($transactions, 'total_harga'));
        $pending       = count(array_filter($transactions, fn($t) => $t['status'] == 0));
        $selesai       = count(array_filter($transactions, fn($t) => $t['status'] == 2));
        ?>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff; color:#1d4ed8;">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
            <div>
                <div class="stat-value"><?= $totalTrx ?></div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <div class="stat-value"><?= number_to_currency($totalBayar, 'IDR') ?></div>
                <div class="stat-label">Total Pengeluaran</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fefce8; color:#ca8a04;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="stat-value"><?= $pending ?></div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5; color:#059669;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="stat-value"><?= $selesai ?></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="orders-list">
        <?php foreach ($transactions as $trx) : ?>
            <?php
            $statusClass = match ((int) $trx['status']) {
                0 => 'pending',
                1 => 'diproses',
                2 => 'selesai',
                default => 'pending',
            };
            $statusLabel = match ((int) $trx['status']) {
                0 => 'Menunggu Konfirmasi',
                1 => 'Sedang Diproses',
                2 => 'Selesai',
                default => 'Tidak Diketahui',
            };
            $metodeIcon = match ($trx['metode_pembayaran'] ?? '') {
                'Transfer Bank' => 'bi-bank2',
                'QRIS'          => 'bi-qr-code-scan',
                'COD'           => 'bi-cash-coin',
                default         => 'bi-credit-card',
            };
            ?>
            <div class="order-card">
                <!-- Order Header -->
                <div class="order-card-header">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="order-id-badge">
                            #TRX-<?= str_pad($trx['id'], 5, '0', STR_PAD_LEFT) ?>
                        </div>
                        <span class="status-badge <?= $statusClass ?>">
                            <?php if ($statusClass === 'pending') : ?>
                                <i class="bi bi-clock me-1"></i>
                            <?php elseif ($statusClass === 'diproses') : ?>
                                <i class="bi bi-arrow-repeat me-1"></i>
                            <?php else : ?>
                                <i class="bi bi-check-circle me-1"></i>
                            <?php endif; ?>
                            <?= $statusLabel ?>
                        </span>
                    </div>
                    <div class="order-meta">
                        <span><i class="bi bi-calendar3 me-1"></i><?= date('d M Y, H:i', strtotime($trx['created_at'])) ?></span>
                        <span><i class="bi <?= $metodeIcon ?> me-1"></i><?= esc($trx['metode_pembayaran'] ?? 'COD') ?></span>
                    </div>
                </div>

                <!-- Order Body -->
                <div class="order-card-body">

                    <!-- Detail Items -->
                    <?php if (!empty($trx['details'])) : ?>
                        <div class="order-items-grid">
                            <?php foreach ($trx['details'] as $detail) : ?>
                                <div class="order-item-chip">
                                    <div class="order-item-img">
                                        <img src="<?= base_url('img/' . ($detail['foto'] ?? 'default.jpg')) ?>"
                                            alt="<?= esc($detail['nama'] ?? '-') ?>"
                                            onerror="this.src='<?= base_url('img/default.jpg') ?>'">
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:.9rem;"><?= esc($detail['nama'] ?? 'Layanan') ?></div>
                                        <div class="small" style="color:var(--muted);">x<?= $detail['jumlah'] ?> &bull; <?= number_to_currency($detail['subtotal_harga'], 'IDR') ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Alamat -->
                    <div class="order-info-row">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        <span style="color:var(--muted); font-size:.9rem;"><?= esc($trx['alamat'] ?? '-') ?></span>
                    </div>
                </div>

                <!-- Order Footer -->
                <div class="order-card-footer">
                    <div class="order-total">
                        <span class="small" style="color:var(--muted);">Total Pembayaran</span>
                        <span class="fw-bold fs-5" style="color:var(--brand);"><?= number_to_currency($trx['total_harga'], 'IDR') ?></span>
                    </div>
                    <button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modal-trx-<?= $trx['id'] ?>">
                        <i class="bi bi-eye me-1"></i> Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="modal-trx-<?= $trx['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg, var(--brand), #2563a8); border-radius:16px 16px 0 0; padding:22px 28px;">
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-0">
                                    <i class="bi bi-receipt-cutoff me-2"></i>
                                    Detail Transaksi #TRX-<?= str_pad($trx['id'], 5, '0', STR_PAD_LEFT) ?>
                                </h5>
                                <div class="text-white-50 small mt-1"><?= date('d MMMM Y H:i', strtotime($trx['created_at'])) ?></div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Items Table -->
                            <h6 class="fw-bold mb-3">Item Pesanan</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-borderless align-middle">
                                    <thead style="background:#f8f9fb; border-radius:12px;">
                                        <tr>
                                            <th class="ps-3 rounded-start" style="font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; color:var(--muted);">Layanan</th>
                                            <th style="font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; color:var(--muted);">Jumlah</th>
                                            <th class="text-end pe-3 rounded-end" style="font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; color:var(--muted);">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trx['details'] as $detail) : ?>
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div style="width:44px;height:44px;border-radius:10px;overflow:hidden;background:#f3f7fc;flex-shrink:0;">
                                                        <img src="<?= base_url('img/' . ($detail['foto'] ?? '')) ?>"
                                                             style="width:100%;height:100%;object-fit:cover;"
                                                             onerror="this.style.display='none'">
                                                    </div>
                                                    <span class="fw-semibold"><?= esc($detail['nama'] ?? '-') ?></span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= $detail['jumlah'] ?> item</span></td>
                                            <td class="text-end pe-3 fw-semibold"><?= number_to_currency($detail['subtotal_harga'], 'IDR') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Info Grid -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-info-card">
                                        <div class="small fw-bold text-uppercase mb-2" style="letter-spacing:.08em; color:var(--muted);">Informasi Pengiriman</div>
                                        <div class="mb-1"><strong>Penerima:</strong> <?= esc($trx['nama_penerima'] ?? '-') ?></div>
                                        <div class="mb-1"><strong>Telepon:</strong> <?= esc($trx['telepon'] ?? '-') ?></div>
                                        <div><strong>Alamat:</strong> <?= esc($trx['alamat'] ?? '-') ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-info-card">
                                        <div class="small fw-bold text-uppercase mb-2" style="letter-spacing:.08em; color:var(--muted);">Ringkasan Biaya</div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Layanan</span>
                                            <span><?= number_to_currency($trx['total_harga'] - $trx['ongkir'], 'IDR') ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Ongkir</span>
                                            <span><?= number_to_currency($trx['ongkir'], 'IDR') ?></span>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total</span>
                                            <span style="color:var(--brand);"><?= number_to_currency($trx['total_harga'], 'IDR') ?></span>
                                        </div>
                                        <hr class="my-2">
                                        <div><strong>Metode:</strong> <i class="bi <?= $metodeIcon ?> me-1"></i><?= esc($trx['metode_pembayaran'] ?? 'COD') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button class="btn btn-sm rounded-pill px-4" style="background:#f4f6f8; border:1px solid var(--line);" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>

<style>
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        max-width: 480px;
        margin: 0 auto;
    }
    .empty-icon { font-size: 4.5rem; color: #d1d9e6; margin-bottom: 20px; line-height: 1; }
    .empty-state h3 { font-weight: 800; letter-spacing: -.03em; margin-bottom: 10px; }
    .empty-state p { color: var(--muted); margin-bottom: 28px; }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-value { font-size: 1.2rem; font-weight: 800; letter-spacing: -.03em; color: var(--text); }
    .stat-label { font-size: .8rem; color: var(--muted); font-weight: 600; }

    /* Orders List */
    .orders-list { display: flex; flex-direction: column; gap: 16px; }

    .order-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 22px;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }

    .order-card:hover {
        box-shadow: 0 12px 32px rgba(17, 24, 39, 0.08);
        transform: translateY(-2px);
    }

    .order-card-header {
        padding: 16px 22px;
        background: #fafbfc;
        border-bottom: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-id-badge {
        font-family: monospace;
        font-weight: 800;
        font-size: .9rem;
        color: var(--brand);
        background: rgba(27, 75, 114, 0.06);
        padding: 4px 12px;
        border-radius: 8px;
        border: 1px solid rgba(27, 75, 114, 0.15);
    }

    .order-meta {
        display: flex;
        gap: 16px;
        font-size: .83rem;
        color: var(--muted);
        flex-wrap: wrap;
    }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 700;
    }
    .status-badge.pending  { background: #fef9c3; color: #713f12; border: 1px solid #fde68a; }
    .status-badge.diproses { background: #dbeafe; color: #1e3a8a; border: 1px solid #bfdbfe; }
    .status-badge.selesai  { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }

    .order-card-body { padding: 18px 22px; }

    .order-items-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .order-item-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8f9fb;
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .order-item-img {
        width: 40px;
        height: 40px;
        border-radius: 9px;
        overflow: hidden;
        flex-shrink: 0;
        background: #eef4ff;
    }

    .order-item-img img { width: 100%; height: 100%; object-fit: cover; }

    .order-info-row {
        display: flex;
        align-items: flex-start;
        padding: 10px 14px;
        background: #f8f9fb;
        border-radius: 12px;
        margin-top: 10px;
    }

    .order-card-footer {
        padding: 14px 22px;
        background: #f4f6f8;
        border-top: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .order-total { display: flex; flex-direction: column; }

    .btn-detail, .btn-action-primary {
        display: inline-flex;
        align-items: center;
        padding: 10px 22px;
        border-radius: 999px;
        font-weight: 700;
        font-size: .9rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .btn-detail {
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        border: none;
        box-shadow: 0 4px 14px rgba(27, 75, 114, 0.25);
    }

    .btn-detail:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(27, 75, 114, 0.35); color: white; }

    .btn-action-primary {
        background: linear-gradient(135deg, var(--brand), #2563a8);
        color: white;
        border: none;
        box-shadow: 0 6px 20px rgba(27, 75, 114, 0.3);
        padding: 14px 28px;
        font-size: 1rem;
    }

    .btn-action-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(27, 75, 114, 0.4); color: white; }

    /* Modal */
    .detail-info-card {
        background: #f8f9fb;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 16px 18px;
        font-size: .9rem;
        height: 100%;
    }
</style>

<?= $this->endSection() ?>
