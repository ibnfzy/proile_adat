<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
    <div>
      <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Kelola Galeri Foto</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Tambah, cari, dan kelola koleksi foto adat dengan tampilan modern.</p>
    </div>
    <a href="/Admin/galeri/create"
      class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
      + Tambah Foto
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/60 dark:bg-green-900/30 dark:text-green-200">
      <?= esc(session()->getFlashdata('success')); ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600 dark:border-red-900/60 dark:bg-red-900/30 dark:text-red-200">
      <ul class="list-inside list-disc space-y-1">
        <?php foreach ((array) session()->getFlashdata('errors') as $error): ?>
          <li><?= esc($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="get" action="/Admin/galeri" class="mb-6">
    <div class="relative flex items-center">
      <input type="text" name="search" value="<?= esc($search); ?>" placeholder="Cari berdasarkan judul foto..."
        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" />
      <?php if ($search): ?>
        <a href="/Admin/galeri"
          class="absolute right-3 text-xs font-semibold uppercase text-emerald-600 hover:text-emerald-500">
          Reset
        </a>
      <?php endif; ?>
    </div>
  </form>

  <?php if (! empty($photos)): ?>
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
      <?php foreach ($photos as $photo): ?>
        <article class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-md transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-800 dark:bg-gray-900/60">
          <button type="button" data-admin-lightbox
            data-lightbox-src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>"
            data-lightbox-title="<?= esc($photo['judul'], 'attr'); ?>"
            data-lightbox-description="<?= esc($photo['deskripsi'] ?? '', 'attr'); ?>"
            class="relative aspect-video w-full overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400">
            <img src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>" alt="<?= esc($photo['judul'], 'attr'); ?>"
              class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/10 to-transparent opacity-0 transition group-hover:opacity-100"></div>
            <div class="pointer-events-none absolute bottom-4 left-4 right-4 flex items-center justify-between text-left text-xs font-medium uppercase tracking-[0.35em] text-white/80 opacity-0 transition group-hover:opacity-100">
              <span><?= esc($photo['judul']); ?></span>
              <span class="inline-flex items-center gap-1 rounded-full bg-white/10 px-3 py-1 text-[0.6rem] font-semibold text-white/70">Preview</span>
            </div>
          </button>
          <div class="flex flex-col gap-3 p-5">
            <div>
              <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90"><?= esc($photo['judul']); ?></h4>
              <?php if (! empty($photo['deskripsi'])): ?>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                  <?= esc(character_limiter($photo['deskripsi'] ?? '', 120)); ?>
                </p>
              <?php endif; ?>
            </div>
            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
              <span>Dibuat: <?= esc($photo['created_at'] ? date('d M Y', strtotime($photo['created_at'])) : '-'); ?></span>
              <?php if (! empty($photo['updated_at'])): ?>
                <span>Diubah: <?= esc(date('d M Y', strtotime($photo['updated_at']))); ?></span>
              <?php endif; ?>
            </div>
            <div class="mt-2 flex flex-wrap gap-2">
              <button type="button" data-admin-lightbox
                data-lightbox-src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>"
                data-lightbox-title="<?= esc($photo['judul'], 'attr'); ?>"
                data-lightbox-description="<?= esc($photo['deskripsi'] ?? '', 'attr'); ?>"
                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:from-emerald-400 hover:to-emerald-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-300 dark:shadow-emerald-500/30">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Lihat
              </button>
              <a href="/Admin/galeri/<?= esc($photo['id']); ?>/edit"
                class="inline-flex items-center rounded-lg border border-indigo-500 px-3 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50 dark:border-indigo-400 dark:text-indigo-300 dark:hover:bg-indigo-500/20">
                Edit
              </a>
              <form action="/Admin/galeri/<?= esc($photo['id']); ?>/delete" method="post" class="inline"
                onsubmit="return confirm('Hapus foto ini dari galeri?');">
                <?= csrf_field(); ?>
                <button type="submit"
                  class="inline-flex items-center rounded-lg border border-red-500 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-400 dark:text-red-300 dark:hover:bg-red-500/20">
                  Hapus
                </button>
              </form>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900/30 dark:text-gray-300">
      Belum ada foto yang tersimpan di galeri.
    </div>
  <?php endif; ?>

</div>
<?= $this->endSection(); ?>
