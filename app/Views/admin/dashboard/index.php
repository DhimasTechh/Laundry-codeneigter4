<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert-chip success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashData('success') ?>
        <button class="alert-chip-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashData('failed')) : ?>
    <div class="alert-chip danger">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= session()->getFlashData('failed') ?>
        <button class="alert-chip-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>

<!-- Page header -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <div class="small fw-semibold mb-1" style="color:#f59e0b; letter-spacing:.1em; text-transform:uppercase;">Overview</div>
        <h1 class="h4 fw-bold mb-0" style="letter-spacing:-.03em;">Selamat datang, <?= esc(session()->get('username') ?? 'Admin') ?> 👋</h1>
        <div class="small mt-1" style="color:var(--muted);">
            <?= date('l, d F Y') ?> · Berikut ringkasan bisnis laundry Anda hari ini.
        </div>
    </div>
    <a href="<?= site_url('admin/pesanan') ?>" class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill fw-bold text-decoration-none"
       style="background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; font-size:.88rem; box-shadow:0 6px 18px rgba(245,158,11,.35);">
        <i class="bi bi-bag-check-fill"></i> Lihat Semua Pesanan
    </a>
</div>

<!-- ── STAT CARDS ───────────────────────────────────────────────── -->
<div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
        <div class="stat-card" style="--accent-c:#6366f1; --accent-light:#eef2ff;">
            <div class="stat-card-top">
                <div class="stat-icon" style="background:var(--accent-light); color:var(--accent-c);">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="stat-trend up">
                    <i class="bi bi-arrow-up-right"></i> Live
                </div>
            </div>
            <div class="stat-value"><?= $stats['total_transaksi'] ?></div>
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-bar" style="--bar-w:100%; --bar-c:var(--accent-c);"></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card" style="--accent-c:#10b981; --accent-light:#ecfdf5;">
            <div class="stat-card-top">
                <div class="stat-icon" style="background:var(--accent-light); color:var(--accent-c);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-trend up"><i class="bi bi-arrow-up-right"></i> Total</div>
            </div>
            <div class="stat-value" style="font-size:1.1rem;">
                <?= 'Rp ' . number_format($stats['total_pendapatan'], 0, ',', '.') ?>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-bar" style="--bar-w:80%; --bar-c:var(--accent-c);"></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card" style="--accent-c:#f59e0b; --accent-light:#fefce8;">
            <div class="stat-card-top">
                <div class="stat-icon" style="background:var(--accent-light); color:var(--accent-c);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <?php if ($stats['pending'] > 0) : ?>
                    <div class="stat-trend warn"><i class="bi bi-exclamation-circle"></i> Perlu Aksi</div>
                <?php endif; ?>
            </div>
            <div class="stat-value"><?= $stats['pending'] ?></div>
            <div class="stat-label">Menunggu Konfirmasi</div>
            <div class="stat-bar" style="--bar-w:<?= $stats['total_transaksi'] > 0 ? round($stats['pending'] / $stats['total_transaksi'] * 100) : 0 ?>%; --bar-c:var(--accent-c);"></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card" style="--accent-c:#06b6d4; --accent-light:#ecfeff;">
            <div class="stat-card-top">
                <div class="stat-icon" style="background:var(--accent-light); color:var(--accent-c);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-trend up"><i class="bi bi-arrow-up-right"></i> Selesai</div>
            </div>
            <div class="stat-value"><?= $stats['selesai'] ?></div>
            <div class="stat-label">Pesanan Selesai</div>
            <div class="stat-bar" style="--bar-w:<?= $stats['total_transaksi'] > 0 ? round($stats['selesai'] / $stats['total_transaksi'] * 100) : 0 ?>%; --bar-c:var(--accent-c);"></div>
        </div>
    </div>
</div>

<!-- ── TWO COLUMNS: Recent Orders + Revenue Breakdown ─────────── -->
<div class="row g-3">

    <!-- Recent Orders -->
    <div class="col-12 col-xl-7">
        <div class="card-surface p-0 overflow-hidden h-100">
            <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid var(--line);">
                <div class="fw-bold" style="font-size:.95rem;">Pesanan Terbaru</div>
                <a href="<?= site_url('admin/pesanan') ?>" class="small fw-semibold text-decoration-none" style="color:#f59e0b;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <?php if (empty($transactions)) : ?>
                <div class="text-center py-5" style="color:var(--muted);">
                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-30"></i>
                    Belum ada transaksi.
                </div>
            <?php else : ?>
                <div style="overflow-x:auto;">
                    <table class="dash-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($transactions, 0, 8) as $trx) : ?>
                                <?php
                                $sc = match ((int)$trx['status']) { 0 => 'pending', 1 => 'diproses', 2 => 'selesai', default => 'pending' };
                                $sl = match ((int)$trx['status']) { 0 => 'Pending', 1 => 'Diproses', 2 => 'Selesai', default => 'Pending' };
                                ?>
                                <tr>
                                    <td><span class="trx-id">#<?= str_pad($trx['id'], 4, '0', STR_PAD_LEFT) ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="mini-avatar"><?= strtoupper(substr($trx['username'], 0, 1)) ?></div>
                                            <span class="fw-semibold" style="font-size:.88rem;"><?= esc($trx['username']) ?></span>
                                        </div>
                                    </td>
                                    <td class="fw-bold" style="color:#1b3a5c; font-size:.88rem;">
                                        <?= 'Rp ' . number_format($trx['total_harga'], 0, ',', '.') ?>
                                    </td>
                                    <td>
                                        <span class="method-pill">
                                            <?= esc($trx['metode_pembayaran'] ?? 'COD') ?>
                                        </span>
                                    </td>
                                    <td><span class="status-dot <?= $sc ?>"><?= $sl ?></span></td>
                                    <td>
                                        <?php if ((int)$trx['status'] < 2) : ?>
                                            <a href="<?= site_url('admin/dashboard/update-status/' . $trx['id']) ?>"
                                               class="btn-quick-action"
                                               onclick="return confirm('Update status pesanan ini?')">
                                                <?= (int)$trx['status'] === 0 ? 'Proses' : 'Selesai' ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="text-success small fw-semibold">✓ Done</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Revenue Breakdown + Method -->
    <div class="col-12 col-xl-5">
        <div class="card-surface p-4 mb-3">
            <div class="fw-bold mb-3" style="font-size:.95rem;">
                <i class="bi bi-wallet2 me-2" style="color:#f59e0b;"></i>Ringkasan Pendapatan
            </div>

            <?php
            $totalPend = $stats['total_pendapatan'] ?: 1;
            $pendapatan = [
                'Transaksi Selesai' => [
                    'val' => $stats['selesai'],
                    'total' => $stats['total_transaksi'],
                    'color' => '#10b981'
                ],
                'Sedang Diproses' => [
                    'val' => $stats['diproses'],
                    'total' => $stats['total_transaksi'],
                    'color' => '#6366f1'
                ],
                'Menunggu Konfirmasi' => [
                    'val' => $stats['pending'],
                    'total' => $stats['total_transaksi'],
                    'color' => '#f59e0b'
                ],
            ];
            $total = max($stats['total_transaksi'], 1);
            ?>

            <?php foreach ($pendapatan as $label => $d) : ?>
                <div class="revenue-row">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-semibold" style="color:var(--muted);"><?= $label ?></span>
                        <span class="small fw-bold"><?= $d['val'] ?> pesanan</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width:<?= $total > 0 ? round($d['val'] / $total * 100) : 0 ?>%;
                                    background:<?= $d['color'] ?>;"></div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:1px solid var(--line);">
                <span class="small" style="color:var(--muted);">Total Nilai Semua Pesanan</span>
                <span class="fw-bold" style="color:var(--primary);">
                    Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?>
                </span>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="card-surface p-4">
            <div class="fw-bold mb-3" style="font-size:.95rem;">
                <i class="bi bi-credit-card me-2" style="color:#6366f1;"></i>Metode Pembayaran
            </div>
            <?php foreach ($metodeStat as $m) : ?>
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px dashed var(--line);">
                    <span class="small fw-semibold"><?= esc($m['metode'] ?? 'Tidak Diketahui') ?></span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="small" style="color:var(--muted);"><?= $m['jumlah'] ?>x</span>
                        <span class="fw-bold small" style="color:var(--primary);">
                            Rp <?= number_format($m['total'], 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($metodeStat)) : ?>
                <div class="small text-center py-3" style="color:var(--muted);">Belum ada data.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* ── Stat Cards ─────────────────────────────────────────── */
.stat-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    padding: 20px;
    transition: box-shadow .2s, transform .2s;
    cursor: default;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.stat-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
.stat-icon {
    width: 46px; height: 46px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
}
.stat-trend {
    font-size: .72rem; font-weight: 700; padding: 3px 9px;
    border-radius: 999px; display: flex; align-items: center; gap: 3px;
}
.stat-trend.up   { background: #ecfdf5; color: #059669; }
.stat-trend.warn { background: #fefce8; color: #d97706; }
.stat-value { font-size: 1.7rem; font-weight: 800; letter-spacing: -.05em; line-height: 1; margin-bottom: 5px; color: var(--text); }
.stat-label { font-size: .78rem; color: var(--muted); font-weight: 600; margin-bottom: 14px; }
.stat-bar {
    height: 4px; border-radius: 999px; background: var(--line);
    position: relative; overflow: hidden;
}
.stat-bar::after {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: var(--bar-w);
    background: var(--bar-c);
    border-radius: 999px;
    transition: width .8s cubic-bezier(.4,0,.2,1);
}

/* ── Table ─────────────────────────────────────────────── */
.dash-table { border-collapse: collapse; }
.dash-table thead tr { background: #f8f9fb; }
.dash-table th {
    padding: 10px 16px;
    font-size: .72rem; text-transform: uppercase; letter-spacing: .08em;
    color: var(--muted); font-weight: 700; white-space: nowrap;
}
.dash-table td { padding: 12px 16px; border-top: 1px solid var(--line); }
.dash-table tbody tr { transition: background .12s; }
.dash-table tbody tr:hover { background: #fafbfc; }
.trx-id { font-family: monospace; font-weight: 700; color: var(--primary); font-size: .85rem; }
.mini-avatar {
    width: 28px; height: 28px; border-radius: 8px;
    background: linear-gradient(135deg, #1b3a5c, #2a5a8c);
    color: #fff; font-weight: 800; font-size: .75rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.method-pill {
    display: inline-block; padding: 3px 10px;
    background: #f4f6f8; border: 1px solid var(--line);
    border-radius: 999px; font-size: .75rem; font-weight: 600;
}
.status-dot {
    display: inline-flex; align-items: center; padding: 3px 10px;
    border-radius: 999px; font-size: .75rem; font-weight: 700;
}
.status-dot.pending  { background: #fef9c3; color: #713f12; }
.status-dot.diproses { background: #dbeafe; color: #1e40af; }
.status-dot.selesai  { background: #dcfce7; color: #14532d; }
.btn-quick-action {
    padding: 5px 12px; border-radius: 8px; font-size: .78rem; font-weight: 700;
    background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff;
    text-decoration: none; white-space: nowrap; transition: opacity .15s;
}
.btn-quick-action:hover { opacity: .85; color: #fff; }

/* ── Revenue ───────────────────────────────────────────── */
.revenue-row { margin-bottom: 14px; }
.progress-track {
    height: 6px; border-radius: 999px; background: var(--line);
    overflow: hidden;
}
.progress-fill {
    height: 100%; border-radius: 999px;
    transition: width .9s cubic-bezier(.4,0,.2,1);
}
</style>

<?= $this->endSection() ?>
