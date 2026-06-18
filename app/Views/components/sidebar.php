<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item mb-3">
            <div class="px-3 py-2 rounded-4" style="background: linear-gradient(135deg, #123a63, #1d4b7c); color: #fff;">
                <div class="small text-white-50">Operasional</div>
                <div class="fw-bold">Premium Laundry</div>
                <div class="small text-white-50">Manajemen layanan terpusat</div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() === '') ? '' : 'collapsed' ?>" href="/">
                <i class="bi bi-house-door"></i>
                <span>Beranda</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (uri_string() === 'keranjang') ? '' : 'collapsed' ?>" href="keranjang">
                <i class="bi bi-journal-check"></i>
                <span>Daftar Pesanan</span>
            </a>
        </li>

        <?php if (session()->get('role') == 'admin') : ?>
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() === 'produk') ? '' : 'collapsed' ?>" href="produk">
                    <i class="bi bi-stars"></i>
                    <span>Layanan Laundry</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>