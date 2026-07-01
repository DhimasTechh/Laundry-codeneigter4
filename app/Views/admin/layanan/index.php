<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<style>
/* ── Page Header ─────────────────────────────────── */
.page-hero {
    background: linear-gradient(135deg, #0f1923 0%, #1b3a5c 100%);
    border-radius: 24px;
    padding: 32px 36px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(245,158,11,.12);
    pointer-events: none;
}
.page-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(245,158,11,.07);
    pointer-events: none;
}
.page-hero-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .15em;
    color: #f59e0b;
    margin-bottom: 8px;
}
.page-hero-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.04em;
    margin-bottom: 6px;
}
.page-hero-sub {
    font-size: .88rem;
    color: rgba(255,255,255,.5);
    font-weight: 500;
}

/* ── Stats Bar ───────────────────────────────────── */
.stats-bar {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.stat-card {
    flex: 1;
    min-width: 140px;
    background: #fff;
    border-radius: 18px;
    padding: 20px 22px;
    border: 1px solid #e4e9f0;
    box-shadow: 0 2px 12px rgba(15,23,42,.05);
    display: flex;
    align-items: center;
    gap: 16px;
}
.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.stat-icon.amber  { background: linear-gradient(135deg,#fef3c7,#fde68a); color: #d97706; }
.stat-icon.blue   { background: linear-gradient(135deg,#dbeafe,#bfdbfe); color: #1d4ed8; }
.stat-icon.green  { background: linear-gradient(135deg,#d1fae5,#a7f3d0); color: #059669; }
.stat-value { font-size: 1.6rem; font-weight: 800; color: #111827; line-height: 1; }
.stat-label { font-size: .76rem; color: #6b7280; font-weight: 600; margin-top: 2px; }

/* ── Toolbar ─────────────────────────────────────── */
.toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.toolbar-search {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 340px;
}
.toolbar-search i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1rem;
    pointer-events: none;
}
.toolbar-search input {
    padding-left: 40px;
    border-radius: 12px;
    border: 1px solid #e4e9f0;
    background: #fff;
    font-size: .88rem;
    height: 42px;
    width: 100%;
    outline: none;
    transition: border .18s, box-shadow .18s;
}
.toolbar-search input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,.15);
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    font-weight: 700;
    font-size: .88rem;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(245,158,11,.35);
    transition: transform .18s, box-shadow .18s;
}
.btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(245,158,11,.45);
    color: #fff;
}

/* ── Service Grid ─────────────────────────────────── */
.service-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.service-card-admin {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #e4e9f0;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(15,23,42,.06);
    transition: transform .22s ease, box-shadow .22s ease;
    display: flex;
    flex-direction: column;
}
.service-card-admin:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 36px rgba(15,23,42,.12);
}

.scard-image-wrap {
    aspect-ratio: 16/9;
    background: linear-gradient(135deg, #f0f4f8, #e8eef5);
    overflow: hidden;
    position: relative;
}
.scard-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}
.service-card-admin:hover .scard-image-wrap img {
    transform: scale(1.05);
}
.scard-no-image {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    gap: 8px;
    font-size: .82rem;
    font-weight: 600;
}
.scard-no-image i { font-size: 2rem; }

.scard-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15,25,35,.65);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: .7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.scard-body {
    padding: 20px 22px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.scard-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: #111827;
    letter-spacing: -.025em;
    margin-bottom: 6px;
}
.scard-desc {
    font-size: .82rem;
    color: #6b7280;
    line-height: 1.55;
    margin-bottom: 16px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.scard-meta {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.scard-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .78rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
}
.scard-pill.price {
    background: linear-gradient(135deg,#fef3c7,#fde68a);
    color: #92400e;
}
.scard-pill.qty {
    background: linear-gradient(135deg,#dbeafe,#bfdbfe);
    color: #1e40af;
}

.scard-actions {
    display: flex;
    gap: 8px;
    border-top: 1px solid #f0f4f8;
    padding-top: 16px;
}
.scard-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 14px;
    border-radius: 10px;
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: all .18s;
}
.scard-btn.edit {
    background: #eff6ff;
    color: #1d4ed8;
}
.scard-btn.edit:hover {
    background: #dbeafe;
    color: #1e40af;
}
.scard-btn.del {
    background: #fef2f2;
    color: #dc2626;
}
.scard-btn.del:hover {
    background: #fee2e2;
    color: #b91c1c;
}

/* Empty state */
.empty-state {
    grid-column: 1/-1;
    text-align: center;
    padding: 64px 20px;
}
.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg,#fef3c7,#fde68a);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #d97706;
    margin: 0 auto 20px;
}
.empty-title { font-size: 1.15rem; font-weight: 700; color: #111827; margin-bottom: 6px; }
.empty-sub { font-size: .88rem; color: #6b7280; }

/* ── Flash Alert ──────────────────────────────────── */
.flash-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 14px;
    font-weight: 600;
    font-size: .9rem;
    margin-bottom: 22px;
    animation: slideDown .3s ease;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.flash-alert.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.flash-alert.danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

/* ── Modal Overrides ─────────────────────────────── */
.modal-content {
    border-radius: 22px !important;
    border: none !important;
    box-shadow: 0 24px 60px rgba(15,23,42,.18) !important;
}
.modal-header {
    background: linear-gradient(135deg, #0f1923, #1b3a5c);
    border-radius: 22px 22px 0 0 !important;
    border-bottom: none !important;
    padding: 22px 26px !important;
}
.modal-header .modal-title { color: #fff !important; font-weight: 800; font-size: 1.05rem; }
.modal-header .btn-close { filter: invert(1) brightness(2); opacity: .7; }
.modal-body { padding: 26px !important; }
.modal-footer { padding: 0 26px 22px !important; border-top: none !important; }

.form-label { font-size: .82rem; font-weight: 700; color: #374151; margin-bottom: 6px; }
.form-control, .form-select {
    border-radius: 11px !important;
    border: 1.5px solid #e4e9f0 !important;
    font-size: .9rem;
    padding: 10px 14px;
    transition: border .18s, box-shadow .18s;
}
.form-control:focus, .form-select:focus {
    border-color: #f59e0b !important;
    box-shadow: 0 0 0 3px rgba(245,158,11,.15) !important;
}
.input-group-text {
    border-radius: 11px 0 0 11px !important;
    border: 1.5px solid #e4e9f0 !important;
    border-right: none !important;
    background: #f8f9fb;
    color: #6b7280;
    font-size: .88rem;
}
.input-group .form-control { border-radius: 0 11px 11px 0 !important; }

.img-preview-wrap {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(135deg, #f0f4f8, #e8eef5);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    border: 1.5px dashed #d1d9e6;
}
.img-preview-wrap img { width:100%; height:100%; object-fit:cover; }
.img-preview-placeholder { color:#9ca3af; font-size:.82rem; text-align:center; }
.img-preview-placeholder i { font-size:2rem; display:block; margin-bottom:6px; }

.btn-modal-cancel {
    padding: 10px 22px;
    border-radius: 11px;
    background: #f3f4f6;
    color: #374151;
    font-weight: 700;
    font-size: .88rem;
    border: none;
    cursor: pointer;
    transition: background .18s;
}
.btn-modal-cancel:hover { background: #e5e7eb; }
.btn-modal-save {
    padding: 10px 26px;
    border-radius: 11px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    font-weight: 700;
    font-size: .88rem;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(245,158,11,.3);
    transition: transform .18s, box-shadow .18s;
}
.btn-modal-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(245,158,11,.4);
}

/* Search no-result */
.hidden-card { display: none !important; }

/* ── Btn Ekspor PDF ─────────────────────────────── */
.btn-export-pdf {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 12px;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #fff;
    font-weight: 700;
    font-size: .88rem;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(220,38,38,.30);
    transition: transform .18s, box-shadow .18s, opacity .18s;
    text-decoration: none;
}
.btn-export-pdf:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(220,38,38,.42);
    color: #fff;
}
.btn-export-pdf:active {
    transform: translateY(0);
    opacity: .85;
}

/* ── PDF Loading Overlay ─────────────────────────── */
.pdf-loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,.55);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 16px;
}
.pdf-loading-overlay.show { display: flex; }
.pdf-spinner {
    width: 52px;
    height: 52px;
    border: 4px solid rgba(255,255,255,.2);
    border-top-color: #f59e0b;
    border-radius: 50%;
    animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.pdf-loading-text {
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    letter-spacing: -.01em;
}
.pdf-loading-sub {
    color: rgba(255,255,255,.55);
    font-size: .82rem;
}
</style>

<!-- Flash Messages -->
<?php if (session()->getFlashData('success')) : ?>
    <div class="flash-alert success" id="flash-success">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span><?= session()->getFlashData('success') ?></span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;font-size:1.1rem;opacity:.6;">×</button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashData('failed')) : ?>
    <div class="flash-alert danger" id="flash-failed">
        <i class="bi bi-exclamation-circle-fill fs-5"></i>
        <span><?= session()->getFlashData('failed') ?></span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;font-size:1.1rem;opacity:.6;">×</button>
    </div>
<?php endif; ?>

<!-- Hero -->
<div class="page-hero">
    <div class="page-hero-label">Manajemen</div>
    <div class="page-hero-title">Kelola Layanan Laundry</div>
    <div class="page-hero-sub">Tambah, edit, atau hapus layanan yang tampil di katalog pembeli secara real-time.</div>
</div>

<!-- Stats -->
<?php
$totalLayanan = count($products);
$totalHarga   = array_sum(array_column($products, 'harga'));
$avgHarga     = $totalLayanan > 0 ? $totalHarga / $totalLayanan : 0;
?>
<div class="stats-bar">
    <div class="stat-card">
        <div class="stat-icon amber"><i class="bi bi-stars"></i></div>
        <div>
            <div class="stat-value"><?= $totalLayanan ?></div>
            <div class="stat-label">Total Layanan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-currency-dollar"></i></div>
        <div>
            <div class="stat-value"><?= number_to_currency($avgHarga, 'IDR', 'id_ID', 0) ?></div>
            <div class="stat-label">Rata-rata Harga</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
        <div>
            <div class="stat-value"><?= $totalLayanan ?></div>
            <div class="stat-label">Aktif di Katalog</div>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="toolbar">
    <div class="toolbar-search">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Cari layanan…" oninput="filterCards(this.value)">
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <a href="<?= site_url('admin/layanan/download') ?>" id="btnExportPdf"
           class="btn-export-pdf"
           onclick="showPdfLoading(event, this)">
            <i class="bi bi-file-earmark-pdf-fill"></i> Ekspor PDF
        </a>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> Tambah Layanan
        </button>
    </div>
</div>

<!-- PDF Loading Overlay -->
<div class="pdf-loading-overlay" id="pdfLoadingOverlay">
    <div class="pdf-spinner"></div>
    <div class="pdf-loading-text">Membuat PDF…</div>
    <div class="pdf-loading-sub">Mohon tunggu, sedang memproses data layanan.</div>
</div>

<!-- Service Grid -->
<div class="service-grid" id="serviceGrid">
    <?php if (empty($products)) : ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-stars"></i></div>
            <div class="empty-title">Belum ada layanan</div>
            <div class="empty-sub">Klik "Tambah Layanan" untuk mulai menambahkan layanan baru.</div>
        </div>
    <?php else : ?>
        <?php foreach ($products as $idx => $p) : ?>
        <div class="service-card-admin" data-name="<?= esc(strtolower($p['nama'])) ?>" data-id="<?= $p['id'] ?>">
            <div class="scard-image-wrap">
                <?php if (!empty($p['foto']) && file_exists(FCPATH . 'img/' . $p['foto'])) : ?>
                    <img src="<?= base_url('img/' . $p['foto']) ?>" alt="<?= esc($p['nama']) ?>" loading="lazy">
                <?php else : ?>
                    <div class="scard-no-image">
                        <i class="bi bi-image"></i>
                        Belum ada foto
                    </div>
                <?php endif; ?>
                <span class="scard-badge">Layanan #<?= $idx + 1 ?></span>
            </div>

            <div class="scard-body">
                <div class="scard-name"><?= esc($p['nama']) ?></div>
                <div class="scard-desc">
                    <?= !empty($p['deskripsi']) ? esc($p['deskripsi']) : 'Layanan laundry profesional dengan hasil rapi dan higienis.' ?>
                </div>
                <div class="scard-meta">
                    <span class="scard-pill price">
                        <i class="bi bi-tag-fill"></i>
                        <?= number_to_currency($p['harga'], 'IDR', 'id_ID', 0) ?>
                    </span>
                    <span class="scard-pill qty">
                        <i class="bi bi-stack"></i>
                        <?= esc($p['jumlah']) ?> unit
                    </span>
                </div>
                <div class="scard-actions">
                    <button class="scard-btn edit" data-bs-toggle="modal" data-bs-target="#editModal-<?= $p['id'] ?>">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </button>
                    <a href="<?= site_url('admin/layanan/delete/' . $p['id']) ?>"
                       class="scard-btn del"
                       onclick="return confirmDelete('<?= esc($p['nama'], 'js') ?>')">
                        <i class="bi bi-trash3-fill"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ═══ MODAL TAMBAH ═══════════════════════════════════════ -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle-fill me-2" style="color:#f59e0b;"></i>Tambah Layanan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart(site_url('admin/layanan/create')) ?>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="cth. Cuci Reguler" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga <span style="color:#ef4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah / Stok <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="jumlah" class="form-control" placeholder="0" min="0" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat layanan…" style="resize:none;"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto Layanan</label>
                        <div class="img-preview-wrap" id="addPreviewWrap">
                            <div class="img-preview-placeholder">
                                <i class="bi bi-cloud-arrow-up"></i>
                                Preview foto akan muncul di sini
                            </div>
                        </div>
                        <input type="file" name="foto" class="form-control" accept="image/*"
                               onchange="previewImage(this, 'addPreviewWrap')">
                        <div class="mt-2" style="font-size:.75rem;color:#9ca3af;">JPG, PNG, WEBP. Maks 2 MB.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save"><i class="bi bi-check-lg me-1"></i>Simpan Layanan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- ═══ MODAL EDIT (per layanan) ══════════════════════════ -->
<?php foreach ($products as $p) : ?>
<div class="modal fade" id="editModal-<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2" style="color:#f59e0b;"></i>Edit Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart(site_url('admin/layanan/edit/' . $p['id'])) ?>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="nama" class="form-control" value="<?= esc($p['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga <span style="color:#ef4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control" value="<?= esc($p['harga']) ?>" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah / Stok <span style="color:#ef4444;">*</span></label>
                            <input type="number" name="jumlah" class="form-control" value="<?= esc($p['jumlah']) ?>" min="0" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" style="resize:none;"><?= esc($p['deskripsi'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto Layanan</label>
                        <div class="img-preview-wrap" id="editPreviewWrap-<?= $p['id'] ?>">
                            <?php if (!empty($p['foto']) && file_exists(FCPATH . 'img/' . $p['foto'])) : ?>
                                <img src="<?= base_url('img/' . $p['foto']) ?>" alt="<?= esc($p['nama']) ?>">
                            <?php else : ?>
                                <div class="img-preview-placeholder">
                                    <i class="bi bi-image"></i>
                                    Belum ada foto
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="foto" class="form-control" accept="image/*"
                               onchange="previewImage(this, 'editPreviewWrap-<?= $p['id'] ?>')">
                        <div class="mt-2" style="font-size:.75rem;color:#9ca3af;">Pilih file baru untuk mengganti foto saat ini.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
/* ── Image Preview ─────────────────────────────── */
function previewImage(input, wrapId) {
    const wrap = document.getElementById(wrapId);
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        wrap.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Confirm Delete ────────────────────────────── */
function confirmDelete(name) {
    return confirm(`Yakin ingin menghapus layanan "${name}"?\nTindakan ini tidak dapat dibatalkan.`);
}

/* ── Search Filter ─────────────────────────────── */
function filterCards(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('#serviceGrid .service-card-admin').forEach(card => {
        const name = card.dataset.name || '';
        card.style.display = (q === '' || name.includes(q)) ? '' : 'none';
    });
    // Show empty state if all hidden
    const visible = [...document.querySelectorAll('#serviceGrid .service-card-admin')]
        .filter(c => c.style.display !== 'none');
    let noResult = document.getElementById('noResult');
    if (visible.length === 0 && q !== '') {
        if (!noResult) {
            noResult = document.createElement('div');
            noResult.id = 'noResult';
            noResult.className = 'empty-state';
            noResult.innerHTML = `
                <div class="empty-icon"><i class="bi bi-search"></i></div>
                <div class="empty-title">Tidak ditemukan</div>
                <div class="empty-sub">Tidak ada layanan yang cocok dengan "<strong>${query}</strong>"</div>`;
            document.getElementById('serviceGrid').appendChild(noResult);
        }
    } else if (noResult) {
        noResult.remove();
    }
}

/* ── Auto-close flash after 4s ─────────────────── */
['flash-success','flash-failed'].forEach(id => {
    const el = document.getElementById(id);
    if (el) setTimeout(() => el.remove(), 4000);
});

/* ── PDF Loading Overlay ─────────────────────────── */
function showPdfLoading(e, el) {
    // Tampilkan overlay loading
    const overlay = document.getElementById('pdfLoadingOverlay');
    if (overlay) overlay.classList.add('show');

    // Sembunyikan overlay setelah 8 detik (fallback),
    // karena download otomatis tidak memicu event load di halaman.
    setTimeout(() => {
        if (overlay) overlay.classList.remove('show');
    }, 8000);

    // Juga hide saat tab kembali ke focus (setelah download mulai)
    const onFocus = () => {
        setTimeout(() => {
            if (overlay) overlay.classList.remove('show');
        }, 1500);
        window.removeEventListener('focus', onFocus);
    };
    window.addEventListener('focus', onFocus);
}
</script>

<?= $this->endSection() ?>
