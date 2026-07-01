<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Layanan Laundry</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #ffffff;
            padding: 0;
            margin: 0;
        }

        /* ═══════════════════════════════════════════════
           HEADER BAND
        ═══════════════════════════════════════════════ */
        .header-band {
            background-color: #0f172a;
            width: 100%;
            padding: 0;
        }
        .header-inner {
            padding: 26px 32px 22px 32px;
            width: 100%;
        }
        .header-table {
            width: 100%;
        }
        .brand-name {
            font-size: 22px;
            font-weight: 700;
            color: #f59e0b;
            letter-spacing: -0.5px;
        }
        .brand-name span {
            color: #ffffff;
        }
        .brand-tagline {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .header-doc-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: right;
        }
        .header-doc-title {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            text-align: right;
            margin-top: 4px;
        }

        /* ═══════════════════════════════════════════════
           GOLD ACCENT LINE
        ═══════════════════════════════════════════════ */
        .accent-line {
            height: 4px;
            background-color: #f59e0b;
            width: 100%;
        }

        /* ═══════════════════════════════════════════════
           DOCUMENT INFO BAR
        ═══════════════════════════════════════════════ */
        .info-bar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 32px;
            width: 100%;
        }
        .info-bar-table {
            width: 100%;
        }
        .info-item-label {
            font-size: 8.5px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: block;
            margin-bottom: 2px;
        }
        .info-item-value {
            font-size: 10.5px;
            font-weight: 700;
            color: #334155;
        }
        .info-divider {
            width: 1px;
            background-color: #e2e8f0;
            padding: 0 1px;
        }

        /* ═══════════════════════════════════════════════
           MAIN CONTENT AREA
        ═══════════════════════════════════════════════ */
        .content-area {
            padding: 24px 32px;
        }

        /* ═══════════════════════════════════════════════
           STATS CARDS
        ═══════════════════════════════════════════════ */
        .stats-section {
            margin-bottom: 24px;
        }
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .stat-card {
            width: 33.33%;
            padding: 16px 20px;
            vertical-align: top;
        }
        .stat-card-inner {
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 18px;
            background: #ffffff;
        }
        .stat-card-inner.amber-card {
            border-left: 4px solid #f59e0b;
            background: #fffbeb;
        }
        .stat-card-inner.blue-card {
            border-left: 4px solid #3b82f6;
            background: #eff6ff;
        }
        .stat-card-inner.green-card {
            border-left: 4px solid #10b981;
            background: #ecfdf5;
        }
        .stat-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-value.amber { color: #d97706; }
        .stat-value.blue  { color: #2563eb; }
        .stat-value.green { color: #059669; }
        .stat-value-sub {
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-value-sub.amber { color: #d97706; }
        .stat-value-sub.blue  { color: #2563eb; }
        .stat-value-sub.green { color: #059669; }
        .stat-desc {
            font-size: 8.5px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════════════
           SECTION HEADER
        ═══════════════════════════════════════════════ */
        .section-header {
            margin-bottom: 12px;
            border-left: 4px solid #f59e0b;
            padding-left: 10px;
        }
        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.2px;
        }
        .section-sub {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════════════
           DATA TABLE
        ═══════════════════════════════════════════════ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        /* Table Head */
        .data-table thead tr {
            background-color: #0f172a;
        }
        .data-table thead th {
            padding: 10px 13px;
            text-align: left;
            font-size: 8.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border: none;
        }
        .data-table thead th.center { text-align: center; }
        .data-table thead th.right  { text-align: right; }

        /* Table Body */
        .data-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .data-table tbody td {
            padding: 11px 13px;
            font-size: 10.5px;
            color: #334155;
            vertical-align: middle;
            border: none;
        }
        .data-table tbody td.center { text-align: center; }
        .data-table tbody td.right  { text-align: right; }

        /* Row number */
        .td-no {
            color: #cbd5e1;
            font-size: 9.5px;
            font-weight: 700;
            width: 30px;
            text-align: center;
        }

        /* Service name */
        .td-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 11px;
        }

        /* Description */
        .td-desc {
            color: #94a3b8;
            font-size: 9.5px;
            font-style: italic;
        }

        /* Pill badges */
        .pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 9.5px;
            font-weight: 700;
        }
        .pill-amber {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .pill-blue {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .pill-slate {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Total row */
        .row-total td {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            font-weight: 700;
            font-size: 10.5px;
            padding: 12px 13px;
            border: none;
        }
        .row-total .pill-amber {
            background-color: #f59e0b;
            color: #ffffff;
            border: none;
        }
        .row-total .pill-blue {
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
        }
        .row-total .label-total {
            color: #94a3b8;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Table wrapper with border */
        .table-wrapper {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        /* ═══════════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════════ */
        .footer-band {
            margin-top: 24px;
            border-top: 1px solid #e2e8f0;
            padding: 14px 32px;
            background-color: #f8fafc;
        }
        .footer-table {
            width: 100%;
        }
        .footer-brand {
            font-size: 10px;
            font-weight: 800;
            color: #f59e0b;
        }
        .footer-sub {
            font-size: 8.5px;
            color: #94a3b8;
            margin-top: 2px;
        }
        .footer-right {
            text-align: right;
            font-size: 8.5px;
            color: #94a3b8;
        }
        .footer-right strong {
            color: #475569;
            font-size: 9px;
        }

        /* ═══════════════════════════════════════════════
           EMPTY STATE
        ═══════════════════════════════════════════════ */
        .empty-row td {
            padding: 40px;
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            font-style: italic;
        }

    </style>
</head>
<body>

<?php
$totalLayanan = count($products);
$totalHarga   = array_sum(array_column($products, 'harga'));
$avgHarga     = $totalLayanan > 0 ? $totalHarga / $totalLayanan : 0;
$totalStok    = array_sum(array_column($products, 'jumlah'));
$docNumber    = 'LYN-' . date('Ymd') . '-' . str_pad($totalLayanan, 3, '0', STR_PAD_LEFT);
?>

<!-- ══ HEADER ══════════════════════════════════════════════ -->
<div class="header-band">
    <div class="header-inner">
        <table class="header-table">
            <tr>
                <td style="width:55%;vertical-align:top;">
                    <div class="brand-name">✦ Laundry<span>Pro</span></div>
                    <div class="brand-tagline">Sistem Manajemen Laundry Profesional</div>
                </td>
                <td style="width:45%;vertical-align:top;text-align:right;">
                    <div class="header-doc-label">Laporan Resmi</div>
                    <div class="header-doc-title">Kelola Layanan</div>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- ══ ACCENT LINE ═════════════════════════════════════════ -->
<div class="accent-line"></div>

<!-- ══ INFO BAR ════════════════════════════════════════════ -->
<div class="info-bar">
    <table class="info-bar-table">
        <tr>
            <td style="width:24%;padding-right:16px;">
                <span class="info-item-label">No. Dokumen</span>
                <span class="info-item-value"><?= $docNumber ?></span>
            </td>
            <td style="width:1px;padding:0 12px;" class="info-divider">
                <div style="height:28px;width:1px;background:#e2e8f0;"></div>
            </td>
            <td style="width:28%;padding-right:16px;">
                <span class="info-item-label">Tanggal &amp; Waktu Cetak</span>
                <span class="info-item-value"><?= date('d F Y') ?> &bull; <?= date('H:i') ?> WIB</span>
            </td>
            <td style="width:1px;padding:0 12px;" class="info-divider">
                <div style="height:28px;width:1px;background:#e2e8f0;"></div>
            </td>
            <td style="width:22%;padding-right:16px;">
                <span class="info-item-label">Periode Data</span>
                <span class="info-item-value">Semua Data Aktif</span>
            </td>
            <td style="width:1px;padding:0 12px;" class="info-divider">
                <div style="height:28px;width:1px;background:#e2e8f0;"></div>
            </td>
            <td style="width:22%;text-align:right;">
                <span class="info-item-label">Dibuat oleh</span>
                <span class="info-item-value">Admin LaundryPro</span>
            </td>
        </tr>
    </table>
</div>

<!-- ══ MAIN CONTENT ════════════════════════════════════════ -->
<div class="content-area">

    <!-- Stats Cards -->
    <div class="stats-section">
        <table class="stats-table">
            <tr>
                <td class="stat-card" style="padding-left:0;">
                    <div class="stat-card-inner amber-card">
                        <div class="stat-label">&#9733; Total Layanan</div>
                        <div class="stat-value amber"><?= $totalLayanan ?></div>
                        <div class="stat-desc">Layanan aktif di katalog</div>
                    </div>
                </td>
                <td class="stat-card">
                    <div class="stat-card-inner blue-card">
                        <div class="stat-label">&#9670; Rata-rata Harga</div>
                        <div class="stat-value-sub blue">Rp <?= number_format($avgHarga, 0, ',', '.') ?></div>
                        <div class="stat-desc">Per layanan</div>
                    </div>
                </td>
                <td class="stat-card" style="padding-right:0;">
                    <div class="stat-card-inner green-card">
                        <div class="stat-label">&#9679; Total Stok Unit</div>
                        <div class="stat-value green"><?= number_format($totalStok, 0, ',', '.') ?></div>
                        <div class="stat-desc">Unit tersedia</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Section Header -->
    <div class="section-header">
        <div class="section-title">Daftar Lengkap Layanan</div>
        <div class="section-sub">Menampilkan <?= $totalLayanan ?> data layanan &bull; Diurutkan berdasarkan tanggal dibuat</div>
    </div>

    <!-- Data Table -->
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="center" style="width:34px;">#</th>
                    <th style="width:22%;">Nama Layanan</th>
                    <th style="width:30%;">Deskripsi</th>
                    <th class="right" style="width:18%;">Harga / Unit</th>
                    <th class="center" style="width:12%;">Stok</th>
                    <th class="center" style="width:13%;">Tgl. Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)) : ?>
                <tr class="empty-row">
                    <td colspan="6">Tidak ada data layanan yang tersedia.</td>
                </tr>
                <?php else : ?>
                <?php foreach ($products as $i => $p) : ?>
                <tr>
                    <td class="td-no"><?= $i + 1 ?></td>
                    <td class="td-name"><?= esc($p['nama']) ?></td>
                    <td class="td-desc">
                        <?php if (!empty($p['deskripsi'])) : ?>
                            <?= esc(mb_strimwidth($p['deskripsi'], 0, 80, '…')) ?>
                        <?php else : ?>
                            <span style="color:#cbd5e1;">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="right">
                        <span class="pill pill-amber">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    </td>
                    <td class="center">
                        <span class="pill pill-blue"><?= (int)$p['jumlah'] ?> unit</span>
                    </td>
                    <td class="center">
                        <span class="pill pill-slate">
                            <?= isset($p['created_at']) ? date('d/m/Y', strtotime($p['created_at'])) : '—' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- Summary / Total Row -->
                <tr class="row-total">
                    <td colspan="3" style="padding:12px 13px;">
                        <span class="label-total">Ringkasan Total</span>
                        &nbsp;&nbsp;
                        <strong style="color:#ffffff;font-size:10.5px;"><?= $totalLayanan ?> Layanan</strong>
                    </td>
                    <td class="right">
                        <span class="pill pill-amber">Rp <?= number_format($totalHarga, 0, ',', '.') ?></span>
                    </td>
                    <td class="center">
                        <span class="pill pill-blue"><?= number_format($totalStok, 0, ',', '.') ?> unit</span>
                    </td>
                    <td></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Catatan kecil -->
    <table style="width:100%;margin-top:10px;">
        <tr>
            <td style="font-size:8.5px;color:#94a3b8;font-style:italic;">
                * Dokumen ini digenerate secara otomatis oleh sistem LaundryPro dan sah tanpa tanda tangan basah.
            </td>
            <td style="text-align:right;font-size:8.5px;color:#94a3b8;">
                Total nilai semua harga: <strong style="color:#d97706;">Rp <?= number_format($totalHarga, 0, ',', '.') ?></strong>
            </td>
        </tr>
    </table>

</div>

<!-- ══ FOOTER ══════════════════════════════════════════════ -->
<div class="footer-band">
    <table class="footer-table">
        <tr>
            <td style="vertical-align:middle;">
                <div class="footer-brand">✦ LaundryPro</div>
                <div class="footer-sub">Sistem Manajemen Laundry Profesional &mdash; Laporan Otomatis</div>
            </td>
            <td style="text-align:right;vertical-align:middle;">
                <div class="footer-right">
                    <strong>Dicetak:</strong> <?= date('d/m/Y H:i') ?> WIB &nbsp;|&nbsp;
                    <strong>Dok:</strong> <?= $docNumber ?>
                </div>
                <div class="footer-right" style="margin-top:3px;">
                    &copy; <?= date('Y') ?> LaundryPro &mdash; Semua data bersifat rahasia
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
