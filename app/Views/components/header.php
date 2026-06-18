<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between gap-3">
    <a href="/" class="logo d-flex align-items-center gap-2 text-decoration-none">
      <span class="badge bg-light text-dark border px-3 py-2">PL</span>
      <span class="d-none d-lg-block">Premium Laundry</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <div class="search-bar ms-4 d-none d-md-block">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Cari layanan, paket, atau nomor pesanan" title="Cari layanan laundry">
      <button type="submit" title="Cari"><i class="bi bi-search"></i></button>
    </form>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center gap-2">
      <li class="nav-item d-block d-md-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <li class="nav-item dropdown pe-2">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
            <i class="bi bi-person-circle fs-4 text-primary"></i>
          </div>
          <span class="d-none d-md-block ps-2 fw-semibold"><?= esc(session()->get('username') ?? 'Pengguna') ?> <small class="text-muted">(<?= esc(session()->get('role') ?? 'guest') ?>)</small></span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?= esc(session()->get('username') ?? 'Pengguna') ?></h6>
            <span><?= esc(session()->get('role') ?? 'guest') ?></span>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="logout">
              <i class="bi bi-box-arrow-right"></i>
              <span>Keluar</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>
