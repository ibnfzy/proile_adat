<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
      <div class="flex items-center gap-2 text-sm text-indigo-600 dark:text-indigo-300">
        <span class="text-2xl"><?= esc($informasi['emoji']); ?></span>
        <span>Preview Informasi</span>
      </div>
      <h1 class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white"><?= esc($informasi['judul']); ?></h1>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Terakhir diperbarui pada <?= esc($informasi['updated_at'] ? date('d M Y, H:i', strtotime($informasi['updated_at'])) : '-'); ?></p>
    </div>
    <div class="flex items-center gap-2">
      <a href="/Admin/informasi/<?= esc($informasi['id']); ?>/edit"
        class="inline-flex items-center rounded-lg border border-indigo-500 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 dark:border-indigo-400 dark:text-indigo-300 dark:hover:bg-indigo-500/20">
        Edit Informasi
      </a>
      <a href="/Admin/informasi"
        class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800/60">
        Kembali
      </a>
    </div>
  </div>

  <?php if (! empty($informasi['gambar'])): ?>
    <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 shadow-sm dark:border-gray-800">
      <img src="<?= esc($informasi['gambar']); ?>" alt="Gambar Informasi" class="h-72 w-full object-cover" />
    </div>
  <?php endif; ?>

  <article class="prose max-w-none text-gray-700 dark:prose-invert dark:text-gray-200">
    <?= nl2br(esc($informasi['konten'])); ?>
  </article>
</div>
<?= $this->endSection(); ?>
