<?php
$hlm = 'Dashboard';
if (uri_string() !== '') {
    $segments = explode('/', uri_string());
    // Ambil segment terakhir yang bermakna
    $last = end($segments);
    $hlm  = ucwords(str_replace(['-', '_'], ' ', $last));
}
$adminName = session()->get('username') ?? 'Admin';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Panel — <?= esc($hlm) ?></title>
    <meta name="description" content="Premium Laundry Seller Management Panel">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <style>
        /* ── Design Tokens ─────────────────────────────────── */
        :root {
            --sidebar-bg:     #0f1923;
            --sidebar-hover:  rgba(255,255,255,.07);
            --sidebar-active: linear-gradient(135deg, #f59e0b, #d97706);
            --sidebar-w:      260px;
            --topbar-h:       68px;
            --body-bg:        #f0f4f8;
            --surface:        #ffffff;
            --line:           #e4e9f0;
            --text:           #111827;
            --muted:          #6b7280;
            --primary:        #1b3a5c;
            --accent:         #f59e0b;
            --radius:         18px;
            --shadow-sm:      0 2px 12px rgba(15,23,42,.06);
            --shadow:         0 8px 28px rgba(15,23,42,.10);
            --shadow-lg:      0 20px 60px rgba(15,23,42,.14);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            color: var(--text);
            background: var(--body-bg);
        }

        /* ── Shell Layout ───────────────────────────────────── */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── Sidebar ────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(245,158,11,.35);
        }
        .brand-text { line-height: 1.2; }
        .brand-title {
            font-weight: 800;
            font-size: .95rem;
            color: #fff;
            letter-spacing: -.02em;
        }
        .brand-sub {
            font-size: .72rem;
            color: rgba(255,255,255,.4);
            font-weight: 500;
        }

        /* Nav sections */
        .sidebar-section {
            padding: 20px 14px 0;
            flex: 1;
        }
        .sidebar-section-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: rgba(255,255,255,.25);
            padding: 0 8px;
            margin-bottom: 6px;
            margin-top: 16px;
        }
        .sidebar-section-label:first-child { margin-top: 0; }

        /* Nav links */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 2px;
            font-weight: 600;
            font-size: .88rem;
            transition: all .18s ease;
            position: relative;
        }
        .nav-item i {
            font-size: 1.05rem;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }
        .nav-item:hover {
            background: var(--sidebar-hover);
            color: rgba(255,255,255,.9);
        }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(245,158,11,.22), rgba(217,119,6,.14));
            color: #fbbf24;
            border: 1px solid rgba(245,158,11,.2);
        }
        .nav-item.active i { color: #f59e0b; }

        /* Badge on nav */
        .nav-badge {
            margin-left: auto;
            background: #f59e0b;
            color: #fff;
            font-size: .65rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 999px;
            line-height: 1.4;
        }

        /* Sidebar footer (admin info + logout) */
        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .admin-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255,255,255,.05);
            margin-bottom: 8px;
        }
        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: .95rem;
            flex-shrink: 0;
        }
        .admin-name { font-size: .83rem; font-weight: 700; color: rgba(255,255,255,.88); line-height: 1.2; }
        .admin-role { font-size: .7rem; color: rgba(255,255,255,.38); font-weight: 500; }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 9px 12px;
            border-radius: 10px;
            background: rgba(239,68,68,.08);
            color: rgba(239,68,68,.75);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 600;
            transition: all .18s;
            border: 1px solid rgba(239,68,68,.12);
        }
        .logout-btn:hover {
            background: rgba(239,68,68,.16);
            color: #ef4444;
        }

        /* ── Main Area ──────────────────────────────────────── */
        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-h);
            background: var(--surface);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
            gap: 16px;
        }
        .topbar-title {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -.03em;
            color: var(--text);
        }
        .topbar-sub {
            font-size: .78rem;
            color: var(--muted);
            font-weight: 500;
            margin-top: 1px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 10px;
            background: #f8f9fb;
            border: 1px solid var(--line);
            font-size: .83rem;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse-dot 2s ease infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,.4); }
            50%       { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
        }
        .topbar-time {
            font-size: .78rem;
            color: var(--muted);
            font-weight: 500;
        }

        /* Content area */
        .app-content {
            flex: 1;
            overflow-y: auto;
            padding: 26px 28px 40px;
        }
        .app-content::-webkit-scrollbar { width: 6px; }
        .app-content::-webkit-scrollbar-track { background: transparent; }
        .app-content::-webkit-scrollbar-thumb { background: #d1d9e6; border-radius: 4px; }

        /* ── Reusable Cards ─────────────────────────────────── */
        .card-surface {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        /* Alert chips */
        .alert-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            border-radius: 14px;
            font-weight: 600;
            font-size: .9rem;
            margin-bottom: 20px;
        }
        .alert-chip.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-chip.danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-chip-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: .5;
            font-size: 1.1rem;
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--text);
            padding: 4px;
        }

        @media (max-width: 991px) {
            .sidebar-toggle { display: block; }
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                z-index: 1000;
                transition: left .25s ease;
            }
            .sidebar.open { left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 999;
            }
            .sidebar-overlay.open { display: block; }
            .app-main { width: 100%; }
            .topbar { padding: 0 16px; }
            .app-content { padding: 18px 16px 32px; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="app-shell">
    <!-- ═══ SIDEBAR ═══════════════════════════════════════ -->
    <aside class="sidebar" id="sidebar">

        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-droplet-half"></i></div>
            <div class="brand-text">
                <div class="brand-title">Premium Laundry</div>
                <div class="brand-sub">Seller Management Panel</div>
            </div>
        </div>

        <!-- Nav -->
        <div class="sidebar-section">
            <div class="sidebar-section-label">Menu Utama</div>

            <a class="nav-item <?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>"
               href="<?= site_url('admin/dashboard') ?>">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a class="nav-item <?= str_starts_with(uri_string(), 'admin/pesanan') ? 'active' : '' ?>"
               href="<?= site_url('admin/pesanan') ?>" id="nav-pesanan">
                <i class="bi bi-bag-check-fill"></i>
                <span>Pesanan Masuk</span>
                <?php
                // Hitung pending order untuk badge
                try {
                    $trxModel = new \App\Models\TransactionModel();
                    $pendingCount = $trxModel->where('status', 0)->countAllResults();
                    if ($pendingCount > 0) {
                        echo '<span class="nav-badge">' . $pendingCount . '</span>';
                    }
                } catch (\Throwable $e) { /* silent */ }
                ?>
            </a>

            <a class="nav-item <?= str_starts_with(uri_string(), 'admin/penghasilan') ? 'active' : '' ?>"
               href="<?= site_url('admin/penghasilan') ?>">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Penghasilan</span>
            </a>

            <div class="sidebar-section-label">Manajemen</div>

            <a class="nav-item <?= str_starts_with(uri_string(), 'admin/layanan') ? 'active' : '' ?>"
               href="<?= site_url('admin/layanan') ?>">
                <i class="bi bi-stars"></i>
                <span>Kelola Layanan</span>
            </a>

            <a class="nav-item" href="<?= site_url('/') ?>" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Katalog</span>
            </a>
        </div>

        <!-- Footer: admin info + logout -->
        <div class="sidebar-footer">
            <div class="admin-card">
                <div class="admin-avatar"><?= strtoupper(substr($adminName, 0, 1)) ?></div>
                <div>
                    <div class="admin-name"><?= esc($adminName) ?></div>
                    <div class="admin-role">Administrator</div>
                </div>
            </div>
            <a href="<?= site_url('logout') ?>" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                Keluar dari Panel
            </a>
        </div>
    </aside>

    <!-- ═══ MAIN ═══════════════════════════════════════════ -->
    <div class="app-main">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="topbar-title"><?= esc($hlm) ?></div>
                    <div class="topbar-sub">Seller Panel · Premium Laundry</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-badge d-none d-md-flex">
                    <div class="topbar-dot"></div>
                    Sistem Aktif
                </div>
                <div class="topbar-time d-none d-lg-block" id="clock"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="app-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Live clock
    function tick() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
    }
    tick();
    setInterval(tick, 1000);

    // Mobile sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('open');
    }
</script>
</body>
</html>
