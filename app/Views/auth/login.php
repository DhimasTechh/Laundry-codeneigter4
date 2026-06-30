<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Laundry Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f7f9fc;
            --line: #e6edf5;
            --text: #0f172a;
            --muted: #64748b;
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
                radial-gradient(circle at 15% 10%, rgba(193, 226, 255, 0.55), transparent 30%),
                radial-gradient(circle at 90% 0%, rgba(233, 242, 252, 0.95), transparent 24%),
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
            max-width: 460px;
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
            <div class="small text-uppercase text-secondary fw-semibold mb-2" style="letter-spacing:.14em;">Welcome Back</div>
            <h1 class="h4 mb-2">Masuk ke akun Anda</h1>
            <div class="text-muted">Kelola pesanan laundry dengan pengalaman yang rapi dan cepat.</div>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success rounded-4 border-0 shadow-sm"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger rounded-4 border-0 shadow-sm"><?= session()->getFlashdata('failed') ?></div>
        <?php endif; ?>

        <?= form_open('login') ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" class="form-control form-control-lg rounded-4" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg rounded-4" required>
            </div>
            <button type="submit" class="btn btn-brand btn-lg w-100 rounded-4 text-white fw-semibold">Login</button>
        <?= form_close() ?>

        <div class="text-center mt-4 text-muted">
            Belum punya akun?
            <a href="<?= site_url('register') ?>" class="text-decoration-none fw-semibold">Daftar sekarang</a>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
