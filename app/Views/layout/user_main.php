<?php
$hlm = 'Katalog Layanan';
if (uri_string() !== '') {
    $hlm = ucwords(str_replace(['/', '-'], ' ', uri_string()));
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEKHOZ - <?= esc($hlm) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8f9fb;
            --surface: #ffffff;
            --line: #e8edf2;
            --text: #111827;
            --muted: #6b7280;
            --brand: #1b4b72;
            --radius: 22px;
            --shadow: 0 14px 34px rgba(17, 24, 39, 0.06);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 0%, rgba(202, 230, 255, 0.5), transparent 24%),
                radial-gradient(circle at 90% 10%, rgba(237, 245, 255, 0.9), transparent 28%),
                var(--bg);
        }

        .navbar-wrap {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -.02em;
            color: var(--brand) !important;
            font-size: 1.4rem;
        }

        .pill {
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #fff;
            padding: 8px 16px;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .pill:hover {
            background: #f2f6fb;
            border-color: #d1d9e6;
        }

        .pill-active {
            background: var(--brand);
            color: #fff !important;
            border-color: var(--brand);
        }

        .pill-active:hover {
            background: #153d5e;
            border-color: #153d5e;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 20px;
            height: 20px;
            border-radius: 999px;
            background: #ef4444;
            color: white;
            font-size: .7rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid white;
        }
        
        .pill-text {
            padding: 8px 16px;
            color: var(--brand);
            font-weight: 700;
            border-right: 1px solid var(--line);
        }

        .main {
            max-width: 1480px;
            margin: 28px auto;
            padding: 0 18px 44px;
        }

        .content-card {
            border: 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            padding: 0;
        }

        .footer {
            text-align: center;
            color: var(--muted);
            font-size: .9rem;
            padding: 20px 16px 30px;
        }
    </style>
</head>
<body>
<div class="navbar-wrap">
    <div class="container-fluid px-3 px-lg-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <a class="navbar-brand" href="<?= site_url('/') ?>">SEKHOZ.</a>
        
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a class="pill <?= uri_string() === '' ? 'pill-active' : '' ?>" href="<?= site_url('/') ?>">
                <i class="bi bi-grid me-1"></i> Katalog
            </a>

            <?php
            $cart = service('cart');
            $cartCount = count($cart->contents());
            ?>
            <a class="pill <?= uri_string() === 'keranjang' ? 'pill-active' : '' ?>" href="<?= site_url('keranjang') ?>" style="position:relative;">
                <i class="bi bi-bag-check me-1"></i> Keranjang
                <?php if ($cartCount > 0) : ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>

            <?php if (session()->get('logged_in')) : ?>
                <a class="pill <?= uri_string() === 'my-orders' ? 'pill-active' : '' ?>" href="<?= site_url('my-orders') ?>">
                    <i class="bi bi-receipt-cutoff me-1"></i> Pesanan Saya
                </a>

                <span class="pill-text d-none d-md-inline-block ms-2">
                    <i class="bi bi-person-circle me-1"></i>
                    Halo, <?= esc(session()->get('username') ?? (session()->get('role') === 'admin' ? 'Seller' : 'Buyer')) ?>
                </span>

                <?php if (session()->get('role') === 'admin') : ?>
                    <a class="pill" href="<?= site_url('admin/layanan') ?>"><i class="bi bi-shop me-1"></i> Seller Panel</a>
                <?php endif; ?>

                <a class="pill" href="<?= site_url('logout') ?>" style="color: #dc3545;">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            <?php else : ?>
                <a class="pill ms-2" href="<?= site_url('login') ?>"><i class="bi bi-person me-1"></i> Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<main class="main">
    <div class="content-card">
        <?= $this->renderSection('content') ?>
    </div>
</main>

<div class="footer">&copy; <?= date('Y') ?> SEKHOZ Commerce Experience. All Rights Reserved.</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>