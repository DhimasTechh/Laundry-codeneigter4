<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <div class="small fw-semibold mb-1" style="color:#f59e0b; letter-spacing:.1em; text-transform:uppercase;">
            Laporan Keuangan
        </div>
        <h1 class="h4 fw-bold mb-0" style="letter-spacing:-.03em;">Ringkasan Penghasilan</h1>
        <div class="small mt-1" style="color:var(--muted);">
            Data berdasarkan seluruh transaksi yang masuk ke sistem.
        </div>
    </div>
    <div class="topbar-badge">
        <i class="bi bi-calendar3 me-1" style="color:#f59e0b;"></i>
        <?= date('F Y') ?>
    </div>
</div>

<!-- ── TOP STAT CARDS ──────────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="rev-stat-card" style="--top:#6366f1;">
            <div class="rsc-top">
                <div class="rsc-icon" style="background:#eef2ff; color:#6366f1;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="rsc-badge" style="background:#eef2ff; color:#6366f1;">Gross</div>
            </div>
            <div class="rsc-value">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
            <div class="rsc-label">Total Pendapatan Kotor</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="rev-stat-card" style="--top:#10b981;">
            <div class="rsc-top">
                <div class="rsc-icon" style="background:#ecfdf5; color:#10b981;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="rsc-badge" style="background:#ecfdf5; color:#10b981;">Lunas</div>
            </div>
            <div class="rsc-value">Rp <?= number_format($pendapatanSelesai, 0, ',', '.') ?></div>
            <div class="rsc-label">Pendapatan Telah Diterima</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="rev-stat-card" style="--top:#f59e0b;">
            <div class="rsc-top">
                <div class="rsc-icon" style="background:#fefce8; color:#d97706;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="rsc-badge" style="background:#fefce8; color:#d97706;">Proses</div>
            </div>
            <div class="rsc-value">Rp <?= number_format($pendapatanProses, 0, ',', '.') ?></div>
            <div class="rsc-label">Sedang Diproses</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="rev-stat-card" style="--top:#ec4899;">
            <div class="rsc-top">
                <div class="rsc-icon" style="background:#fdf2f8; color:#ec4899;">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="rsc-badge" style="background:#fdf2f8; color:#ec4899;">Avg</div>
            </div>
            <div class="rsc-value">Rp <?= number_format($avgOrderValue, 0, ',', '.') ?></div>
            <div class="rsc-label">Rata-rata Nilai Pesanan</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- ── CHART: Pendapatan per Bulan ──────────────────── -->
    <div class="col-12 col-xl-7">
        <div class="card-surface p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="fw-bold" style="font-size:.95rem;">
                    <i class="bi bi-bar-chart-fill me-2" style="color:#f59e0b;"></i>
                    Pendapatan per Bulan (6 Bulan Terakhir)
                </div>
            </div>

            <!-- Bar chart (pure CSS) -->
            <div class="bar-chart-wrap">
                <?php
                $maxVal = max(array_column($monthlyData, 'total') ?: [1]);
                ?>
                <?php foreach ($monthlyData as $m) : ?>
                    <?php $pct = $maxVal > 0 ? round($m['total'] / $maxVal * 100) : 0; ?>
                    <div class="bar-col">
                        <div class="bar-value-label">
                            <?= $m['total'] > 0 ? 'Rp ' . number_format($m['total'] / 1000, 0, ',', '.') . 'k' : '-' ?>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="height:<?= $pct ?>%;"
                                 data-value="<?= $pct ?>"></div>
                        </div>
                        <div class="bar-label"><?= $m['bulan'] ?></div>
                        <div class="bar-count"><?= $m['jumlah'] ?> order</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ── RIGHT COLUMN ─────────────────────────────────── -->
    <div class="col-12 col-xl-5">
        <!-- Metode Pembayaran -->
        <div class="card-surface p-4 mb-3">
            <div class="fw-bold mb-3" style="font-size:.95rem;">
                <i class="bi bi-pie-chart-fill me-2" style="color:#6366f1;"></i>
                Distribusi Metode Pembayaran
            </div>
            <?php
            $metodColors = ['#f59e0b', '#6366f1', '#10b981', '#ec4899'];
            $totalMetode = max(array_sum(array_column($metodeStat, 'jumlah')), 1);
            $i = 0;
            ?>
            <?php foreach ($metodeStat as $m) : ?>
                <?php
                $pct = round($m['jumlah'] / $totalMetode * 100);
                $color = $metodColors[$i++ % count($metodColors)];
                ?>
                <div class="metode-row">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <div class="metode-dot" style="background:<?= $color ?>;"></div>
                            <span class="small fw-semibold"><?= esc($m['metode'] ?? 'Tidak Diketahui') ?></span>
                        </div>
                        <div class="small fw-bold" style="color:var(--muted);"><?= $pct ?>%</div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:<?= $pct ?>%; background:<?= $color ?>;"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span class="small" style="color:var(--muted);"><?= $m['jumlah'] ?> transaksi</span>
                        <span class="small fw-bold">Rp <?= number_format($m['total'], 0, ',', '.') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($metodeStat)) : ?>
                <div class="small text-center py-3" style="color:var(--muted);">Belum ada data.</div>
            <?php endif; ?>
        </div>

        <!-- Top Layanan -->
        <div class="card-surface p-4">
            <div class="fw-bold mb-3" style="font-size:.95rem;">
                <i class="bi bi-stars me-2" style="color:#f59e0b;"></i>
                Layanan Terlaris
            </div>
            <?php if (!empty($topLayanan)) : ?>
                <?php foreach ($topLayanan as $idx => $lay) : ?>
                    <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px dashed var(--line);">
                        <div class="rank-badge"><?= $idx + 1 ?></div>
                        <div class="flex-grow-1">
                            <div class="small fw-bold"><?= esc($lay['nama'] ?? '-') ?></div>
                            <div class="small" style="color:var(--muted);">Terjual <?= $lay['total_terjual'] ?> item</div>
                        </div>
                        <div class="fw-bold small" style="color:var(--primary);">
                            Rp <?= number_format($lay['total_pendapatan'], 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="small text-center py-3" style="color:var(--muted);">Belum ada data.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── FULL TRANSACTION LOG ─────────────────────────────────── -->
<div class="card-surface p-0 overflow-hidden mt-3">
    <div class="px-4 py-3 fw-bold d-flex justify-content-between align-items-center" style="border-bottom:1px solid var(--line);">
        <span><i class="bi bi-journal-text me-2" style="color:#f59e0b;"></i>Log Semua Transaksi</span>
        <span class="small" style="color:var(--muted);"><?= count($transactions) ?> total</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="dash-table w-100">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Subtotal</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $trx) : ?>
                    <?php
                    $sc = match ((int)$trx['status']) { 0=>'pending', 1=>'diproses', 2=>'selesai', default=>'pending' };
                    $sl = match ((int)$trx['status']) { 0=>'Pending', 1=>'Diproses', 2=>'Selesai', default=>'-' };
                    ?>
                    <tr>
                        <td><span class="trx-id">#<?= str_pad($trx['id'], 4, '0', STR_PAD_LEFT) ?></span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mini-avatar"><?= strtoupper(substr($trx['username'], 0, 1)) ?></div>
                                <span class="fw-semibold" style="font-size:.85rem;"><?= esc($trx['username']) ?></span>
                            </div>
                        </td>
                        <td class="small" style="color:var(--muted);">
                            <?= date('d M Y', strtotime($trx['created_at'])) ?>
                        </td>
                        <td><span class="method-pill"><?= esc($trx['metode_pembayaran'] ?? 'COD') ?></span></td>
                        <td class="small fw-semibold">
                            Rp <?= number_format($trx['total_harga'] - $trx['ongkir'], 0, ',', '.') ?>
                        </td>
                        <td class="small" style="color:var(--muted);">
                            Rp <?= number_format($trx['ongkir'], 0, ',', '.') ?>
                        </td>
                        <td class="fw-bold" style="color:var(--primary); font-size:.88rem;">
                            Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?>
                        </td>
                        <td><span class="status-dot <?= $sc ?>"><?= $sl ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
/* Rev Stat Cards */
.rev-stat-card {
    background: var(--surface); border: 1px solid var(--line);
    border-radius: var(--radius); padding: 20px;
    border-top: 3px solid var(--top);
    transition: box-shadow .2s, transform .2s;
}
.rev-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.rsc-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
.rsc-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 1.15rem;
}
.rsc-badge {
    font-size: .7rem; font-weight: 700; padding: 3px 9px;
    border-radius: 999px; text-transform: uppercase; letter-spacing: .06em;
}
.rsc-value { font-size: 1.3rem; font-weight: 800; letter-spacing: -.04em; color: var(--text); line-height: 1; margin-bottom: 5px; }
.rsc-label { font-size: .78rem; color: var(--muted); font-weight: 600; }

/* Bar Chart */
.bar-chart-wrap {
    display: flex; align-items: flex-end; gap: 14px;
    height: 180px; padding-top: 28px;
}
.bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
.bar-value-label { font-size: .65rem; color: var(--muted); font-weight: 600; text-align: center; height: 16px; }
.bar-track {
    width: 100%; flex: 1; background: #f0f4f8;
    border-radius: 8px 8px 0 0; overflow: hidden;
    position: relative; min-height: 10px;
}
.bar-fill {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(180deg, #f59e0b, #d97706);
    border-radius: 6px 6px 0 0;
    transition: height 1s cubic-bezier(.4,0,.2,1);
    min-height: 4px;
}
.bar-label { font-size: .72rem; font-weight: 700; color: var(--muted); text-align: center; }
.bar-count { font-size: .65rem; color: var(--muted); text-align: center; }

/* Metode rows */
.metode-row { margin-bottom: 14px; }
.metode-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.progress-track { height: 6px; border-radius: 999px; background: var(--line); overflow: hidden; }
.progress-fill { height: 100%; border-radius: 999px; transition: width .9s cubic-bezier(.4,0,.2,1); }

/* Rank */
.rank-badge {
    width: 26px; height: 26px; border-radius: 8px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; font-weight: 800; font-size: .75rem;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

/* Shared table styles (reused from dashboard) */
.dash-table { border-collapse: collapse; }
.dash-table thead tr { background: #f8f9fb; }
.dash-table th { padding: 10px 16px; font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); font-weight: 700; white-space: nowrap; }
.dash-table td { padding: 11px 16px; border-top: 1px solid var(--line); }
.dash-table tbody tr:hover { background: #fafbfc; }
.trx-id { font-family: monospace; font-weight: 700; color: var(--primary); font-size: .85rem; }
.mini-avatar { width: 28px; height: 28px; border-radius: 8px; background: linear-gradient(135deg, #0f1923, #1b3a5c); color: #f59e0b; font-weight: 800; font-size: .75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.method-pill { display: inline-block; padding: 3px 10px; background: #f4f6f8; border: 1px solid var(--line); border-radius: 999px; font-size: .75rem; font-weight: 600; }
.status-dot { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; font-size: .75rem; font-weight: 700; }
.status-dot.pending  { background: #fef9c3; color: #713f12; }
.status-dot.diproses { background: #dbeafe; color: #1e40af; }
.status-dot.selesai  { background: #dcfce7; color: #14532d; }
.topbar-badge { display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 10px; background: var(--surface); border: 1px solid var(--line); font-size: .83rem; font-weight: 600; color: var(--text); }
</style>

<?= $this->endSection() ?>
