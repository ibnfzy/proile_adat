<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($pageTitle ?? 'Masuk'); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: radial-gradient(circle at top, rgba(59, 130, 246, 0.25), transparent 60%),
        radial-gradient(circle at bottom, rgba(37, 99, 235, 0.15), transparent 55%), #f8fafc;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">
  <main class="flex flex-1 items-center justify-center px-4 py-12">
    <div
      class="relative w-full max-w-md overflow-hidden rounded-3xl border border-blue-100 bg-white/80 shadow-xl backdrop-blur">
      <div class="absolute -top-24 -left-24 h-56 w-56 rounded-full bg-blue-200/40 blur-3xl"></div>
      <div class="absolute -bottom-24 -right-24 h-56 w-56 rounded-full bg-blue-300/30 blur-3xl"></div>
      <div class="relative px-8 py-10">
        <div class="mb-8 text-center">
          <h1 class="text-2xl font-semibold text-blue-700">Masuk ke Panel Admin</h1>
          <p class="mt-2 text-sm text-slate-500">Silakan login untuk melanjutkan pengelolaan konten.</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="mb-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-600">
            <?= esc(session()->getFlashdata('error')); ?>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('message')) : ?>
          <div class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-600">
            <?= esc(session()->getFlashdata('message')); ?>
          </div>
        <?php endif; ?>

        <?php if ($errors = session()->getFlashdata('errors')) : ?>
          <div class="mb-4 space-y-1 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm text-amber-700">
            <?php foreach ($errors as $error) : ?>
              <p><?= esc($error); ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= site_url('/login'); ?>" method="post" class="space-y-6">
          <?= csrf_field(); ?>
          <div class="space-y-2">
            <label for="username" class="text-sm font-medium text-slate-600">Username</label>
            <input type="text" id="username" name="username" value="<?= old('username'); ?>" autofocus
              class="w-full rounded-xl border border-blue-100 bg-white px-4 py-3 text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-200"
              placeholder="Masukkan username" required>
          </div>

          <div class="space-y-2">
            <label for="password" class="text-sm font-medium text-slate-600">Password</label>
            <input type="password" id="password" name="password"
              class="w-full rounded-xl border border-blue-100 bg-white px-4 py-3 text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-200"
              placeholder="Masukkan password" required>
          </div>

          <button type="submit"
            class="w-full rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:from-blue-600 hover:to-blue-700">
            Masuk Sekarang
          </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500">
          <a href="/" class="inline-flex items-center gap-1 font-medium text-blue-600 hover:text-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </main>

  <footer class="pb-6 text-center text-xs text-slate-400">
    &copy; <?= date('Y'); ?> Panel Admin Desa. All rights reserved.
  </footer>
</body>

</html>
