<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Laundry Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --line: #e8eef5;
            --text: #0f172a;
            --brand: #17466c;
            --radius: 22px;
            --shadow: 0 22px 50px rgba(15, 23, 42, .08);
        }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 15%, rgba(193, 226, 255, 0.5), transparent 30%),
                radial-gradient(circle at 0% 0%, rgba(233, 242, 252, 1), transparent 28%),
                var(--bg);
        }
        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }
        .auth-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px;
        }
        .btn-brand {
            background: linear-gradient(135deg, #17466c, #2a5f8a);
            border: 0;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #123a58, #1f4d72);
        }
    </style>
</head>
<body>
<section class="auth-shell">
    <div class="auth-card">
        <div class="mb-4 text-center">
            <div class="small text-uppercase text-secondary fw-semibold mb-2" style="letter-spacing:.14em;">Create Account</div>
            <h1 class="h4 mb-2">Daftar sebagai pembeli</h1>
            <div class="text-muted">Akun pembeli memberi akses ke katalog dan transaksi keranjang.</div>
        </div>

        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger rounded-4 border-0 shadow-sm"><?= session()->getFlashdata('failed') ?></div>
        <?php endif; ?>

        <?= form_open('register') ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text" name="nama" value="<?= old('nama') ?>" class="form-control form-control-lg rounded-4" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" class="form-control form-control-lg rounded-4" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg rounded-4" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-4" required>
            </div>
            <button type="submit" class="btn btn-brand btn-lg w-100 rounded-4 text-white fw-semibold">Buat Akun</button>
        <?= form_close() ?>

        <div class="text-center mt-4 text-muted">
            Sudah punya akun?
            <a href="<?= site_url('login') ?>" class="text-decoration-none fw-semibold">Masuk di sini</a>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
