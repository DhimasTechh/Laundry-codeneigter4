<?php
$hlm = 'Beranda';
if (uri_string() !== '') {
    $hlm = ucwords(str_replace(['/', '-'], ' ', uri_string()));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Premium Laundry - <?= esc($hlm) ?></title>
  <meta name="description" content="Premium Laundry management system">
  <meta name="keywords" content="laundry, service, premium, management">

  <link href="<?= base_url() ?>NiceAdmin/assets/img/favicon.png" rel="icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/css/style.css" rel="stylesheet">

  <style>
    :root {
      --pl-bg: #f4f7fb;
      --pl-surface: rgba(255, 255, 255, 0.88);
      --pl-border: rgba(16, 24, 40, 0.08);
      --pl-text: #0f172a;
      --pl-muted: #64748b;
      --pl-primary: #123a63;
      --pl-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
    }

    html, body {
      background:
        radial-gradient(circle at top left, rgba(108, 168, 255, 0.16), transparent 32%),
        radial-gradient(circle at top right, rgba(18, 58, 99, 0.08), transparent 28%),
        var(--pl-bg);
      color: var(--pl-text);
      font-family: 'Inter', sans-serif;
    }

    body {
      min-height: 100vh;
    }

    .header {
      background: rgba(255, 255, 255, 0.82);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid var(--pl-border);
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    .header .logo span {
      color: var(--pl-primary);
      font-weight: 800;
      letter-spacing: -0.03em;
    }

    .header .search-bar {
      max-width: 520px;
      flex: 1;
    }

    .header .search-form {
      border: 1px solid var(--pl-border);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.9);
      overflow: hidden;
    }

    .header .search-form input {
      font-size: 0.95rem;
    }

    .header .search-form button {
      background: var(--pl-primary);
      color: #fff;
    }

    .sidebar {
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(18px);
      border-right: 1px solid var(--pl-border);
      box-shadow: var(--pl-shadow);
    }

    .sidebar .sidebar-nav {
      padding: 18px;
    }

    .sidebar .nav-link {
      border-radius: 18px;
      margin-bottom: 8px;
      color: var(--pl-text);
      font-weight: 600;
      padding: 14px 16px;
      transition: all 0.2s ease;
    }

    .sidebar .nav-link i {
      color: var(--pl-primary);
    }

    .sidebar .nav-link:not(.collapsed),
    .sidebar .nav-link:hover {
      background: linear-gradient(135deg, var(--pl-primary), #1d4b7c);
      color: #fff;
      transform: translateX(2px);
    }

    .sidebar .nav-link:not(.collapsed) i,
    .sidebar .nav-link:hover i {
      color: #fff;
    }

    #main.main {
      padding: 110px 28px 34px;
    }

    .pagetitle {
      margin-bottom: 22px;
    }

    .pagetitle h1 {
      font-size: clamp(1.7rem, 2vw, 2.35rem);
      font-weight: 800;
      letter-spacing: -0.05em;
      color: var(--pl-primary);
    }

    .pagetitle .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 0;
      color: var(--pl-muted);
    }

    .content-shell {
      background: var(--pl-surface);
      border: 1px solid var(--pl-border);
      border-radius: 28px;
      box-shadow: var(--pl-shadow);
      overflow: hidden;
    }

    .content-shell .card-body {
      padding: 28px;
    }

    .footer {
      background: transparent;
      color: var(--pl-muted);
      font-size: 0.92rem;
    }

    .btn,
    .btn[class*='rounded-pill'] {
      border-radius: 999px !important;
    }

    .form-control,
    .form-select {
      border-radius: 16px;
      border-color: rgba(15, 23, 42, 0.12);
      box-shadow: none;
    }

    .badge {
      border-radius: 999px;
      font-weight: 600;
    }

    @media (max-width: 1199px) {
      #main.main {
        padding: 98px 18px 24px;
      }
    }
  </style>
</head>

<body>
  <?= $this->include('components/header') ?>
  <?= $this->include('components/sidebar') ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1><?= esc($hlm) ?></h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Premium Laundry</li>
          <?php if ($hlm !== 'Beranda') : ?>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($hlm) ?></li>
          <?php endif; ?>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="content-shell">
        <div class="card-body">
          <?= $this->renderSection('content') ?>
        </div>
      </div>
    </section>
  </main>

  <?= $this->include('components/footer') ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/js/main.js"></script>
</body>

</html>