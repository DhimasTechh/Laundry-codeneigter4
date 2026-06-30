<?= $this->extend('layout/user_main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <div class="small text-uppercase fw-semibold text-secondary mb-2" style="letter-spacing:.13em;">Front-Office</div>
        <h1 class="h3 mb-2">Katalog Layanan Laundry</h1>
        <div class="text-muted">Pilih layanan terbaik untuk kebutuhan harian Anda.</div>
    </div>
    <a href="<?= site_url('keranjang') ?>" class="btn btn-outline-dark rounded-pill px-4">
        <i class="bi bi-bag-check me-2"></i>Lihat Keranjang
    </a>
</div>

<div class="row g-4">
    <?php foreach ($products as $item) : ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 rounded-5 shadow-sm h-100 overflow-hidden" style="border:1px solid #edf2f7 !important;">
                <div style="aspect-ratio:16/10;background:#f3f7fc;overflow:hidden;">
                    <img src="<?= base_url('img/' . $item['foto']) ?>" alt="<?= esc($item['nama']) ?>" class="w-100 h-100" style="object-fit:cover;">
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h2 class="h5 mb-2"><?= esc($item['nama']) ?></h2>
                    <div class="text-muted mb-3"><?= !empty($item['deskripsi']) ? esc($item['deskripsi']) : 'Layanan laundry profesional dengan hasil rapi dan higienis.' ?></div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="fw-bold text-primary fs-5"><?= number_to_currency($item['harga'], 'IDR') ?></div>
                        <?= form_open('keranjang/add') ?>
                            <?= form_hidden('id', $item['id']) ?>
                            <?= form_hidden('nama', $item['nama']) ?>
                            <?= form_hidden('harga', $item['harga']) ?>
                            <?= form_hidden('foto', $item['foto']) ?>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah ke Keranjang</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
