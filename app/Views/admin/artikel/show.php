<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Preview Artikel</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Tinjau tampilan artikel sebelum dipublikasikan.</p>
    </div>
    <a href="/Admin/artikel/<?= esc($artikel['id']); ?>/edit"
      class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      Edit Artikel
    </a>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
    <div class="mb-6">
      <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300">
        <?= esc($artikel['kategori_nama'] ?? 'Tanpa Kategori'); ?>
      </span>
      <h1 class="mt-4 text-3xl font-bold text-gray-900 dark:text-white">
        <?= esc($artikel['judul']); ?>
      </h1>
      <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-300">
        <span>Penulis: <strong class="text-gray-700 dark:text-gray-200"><?= esc($artikel['penulis_nama'] ?? 'Tidak diketahui'); ?></strong></span>
        <span>Dibuat: <?= esc($artikel['created_at'] ? date('d M Y, H:i', strtotime($artikel['created_at'])) : '-'); ?></span>
        <?php if (! empty($artikel['updated_at'])): ?>
          <span>Diperbarui: <?= esc(date('d M Y, H:i', strtotime($artikel['updated_at']))); ?></span>
        <?php endif; ?>
      </div>
    </div>

    <?php if (! empty($artikel['gambar'])):
      $gambarUrl = $artikel['gambar'];
      if (! preg_match('#^https?://#i', $gambarUrl)) {
          $cleanImage = str_replace('\\', '/', ltrim($gambarUrl, '/'));
          if (strpos($cleanImage, 'uploads/') === 0) {
              $cleanImage = substr($cleanImage, strlen('uploads/')) ?: '';
          }
          $gambarUrl = base_url('/uploads/' . ltrim($cleanImage, '/'));
      }
    ?>
      <button type="button" data-admin-lightbox
        data-lightbox-src="<?= esc($gambarUrl, 'attr'); ?>"
        data-lightbox-title="<?= esc($artikel['judul'], 'attr'); ?>"
        data-lightbox-description="<?= esc(character_limiter(strip_tags($artikel['isi'] ?? ''), 180), 'attr'); ?>"
        class="mb-8 w-full overflow-hidden rounded-xl border border-gray-200 shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 dark:border-gray-700">
        <span class="sr-only">Perbesar gambar artikel <?= esc($artikel['judul']); ?></span>
        <div class="relative h-64 w-full">
          <img src="<?= esc($gambarUrl); ?>" alt="Gambar artikel"
            class="h-full w-full object-cover transition duration-500 hover:scale-[1.02]" />
          <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
        </div>
      </button>
    <?php endif; ?>

    <article class="prose prose-indigo max-w-none text-gray-700 dark:prose-invert dark:text-gray-100">
      <?= nl2br(esc($artikel['isi'])); ?>
    </article>
  </div>

  <div class="flex justify-end">
    <a href="/Admin/artikel" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800/60">
      Kembali ke daftar
    </a>
  </div>
</div>
<?= $this->endSection(); ?>
