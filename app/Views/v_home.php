<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 px-4 py-3" role="alert">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                <i class="bi bi-check2-circle text-success fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold mb-1">Pesanan berhasil diproses</div>
                <div><?= session()->getFlashData('success') ?></div>
            </div>
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php
}
?>
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <div class="text-uppercase text-primary fw-semibold small mb-2" style="letter-spacing: .18em;">Service Catalog</div>
        <h2 class="mb-2 fw-bold" style="letter-spacing: -.04em;">Layanan laundry premium yang rapi, cepat, dan terpercaya.</h2>
        <p class="text-muted mb-0" style="max-width: 58rem;">Pilih paket layanan yang paling sesuai. Setiap kartu di bawah tetap menggunakan data asli sistem, termasuk nama layanan, harga, dan foto layanan.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">Abundant whitespace</span>
        <span class="badge bg-light text-dark border px-3 py-2">Modern pill buttons</span>
        <span class="badge bg-light text-dark border px-3 py-2">Luxury UI</span>
    </div>
</div>

<div class="row g-4">
    <?php foreach ($products as $key => $item) : ?>
        <div class="col-12 col-md-6 col-xl-4">
            <?= form_open('keranjang') ?>
            <?= form_hidden([
                'id'    => $item['id'],
                'nama'  => $item['nama'],
                'harga' => $item['harga'],
                'foto'  => $item['foto']
            ]) ?>

            <div class="card h-100 border-0 shadow-sm rounded-5 overflow-hidden service-card">
                <div class="position-relative">
                    <div class="service-image-wrap">
                        <img src="<?= base_url() . 'img/' . $item['foto'] ?>" alt="<?= esc($item['nama']) ?>" class="img-fluid w-100 service-image">
                    </div>
                    <span class="badge rounded-pill text-bg-light border position-absolute top-0 start-0 m-3 px-3 py-2">Premium Package</span>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                        <div>
                            <h3 class="h5 fw-bold mb-1" style="letter-spacing: -.03em;"><?= esc($item['nama']) ?></h3>
                            <div class="text-muted small">Service package untuk kebutuhan laundry harian maupun ekspres</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-uppercase text-muted fw-semibold">Harga</div>
                            <div class="fs-5 fw-bold text-primary"><?= number_to_currency($item['harga'], 'IDR') ?></div>
                        </div>
                    </div>

                    <div class="mt-auto pt-3 d-flex align-items-center justify-content-between gap-3 border-top">
                        <div class="small text-muted">
                            <i class="bi bi-droplet-half text-primary me-1"></i>
                            Fresh cleaning, neat finishing
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                            Pesan Layanan
                        </button>
                    </div>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>

<style>
    .service-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        background: rgba(255, 255, 255, 0.95);
    }

    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12) !important;
    }

    .service-image-wrap {
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: linear-gradient(135deg, #eef4ff, #f8fbff);
    }

    .service-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: transform 0.35s ease;
    }

    .service-card:hover .service-image {
        transform: scale(1.03);
    }

    .btn-primary {
        background: linear-gradient(135deg, #123a63, #1d4b7c);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0f2f50, #173d66);
    }

    .text-primary {
        color: #123a63 !important;
    }

    .bg-primary-subtle {
        background-color: #eaf2ff !important;
    }
</style>

<?= $this->endSection() ?>