<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6 flex flex-col gap-4 md:flex-row md:justify-between">
    <div>
      <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Kelola Kategori Artikel</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Tambah, ubah, atau hapus kategori untuk artikel Anda.</p>
    </div>
    <a href="/Admin/kategori-artikel/create"
      class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      + Tambah Kategori
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div
      class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/60 dark:bg-green-900/30 dark:text-green-200">
      <?= esc(session()->getFlashdata('success')); ?>
    </div>
  <?php endif; ?>

  <form method="get" action="/Admin/kategori-artikel" class="mb-6">
    <div class="relative flex items-center">
      <input type="text" name="search" value="<?= esc($search); ?>" placeholder="Cari berdasarkan nama kategori..."
        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" />
      <?php if ($search): ?>
        <a href="/Admin/kategori-artikel"
          class="absolute right-3 text-xs font-semibold uppercase text-indigo-600 hover:text-indigo-500">
          Reset
        </a>
      <?php endif; ?>
    </div>
  </form>

  <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm dark:border-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-800/70">
        <tr>
          <th scope="col"
            class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
            Nama Kategori</th>
          <th scope="col"
            class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
            Slug</th>
          <th scope="col"
            class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
            Dibuat</th>
          <th scope="col"
            class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
            Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900/40">
        <?php if (! empty($categories)): ?>
          <?php foreach ($categories as $kategori): ?>
            <tr class="transition">
              <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100"><?= esc($kategori['nama']); ?></td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300"><?= esc($kategori['slug']); ?></td>
              <td class="px-6 py-4 text-right text-sm text-gray-500 dark:text-gray-300">
                <?= esc($kategori['created_at'] ? date('d M Y, H:i', strtotime($kategori['created_at'])) : '-'); ?>
              </td>
              <td class="px-6 py-4 text-right text-sm">
                <div class="flex justify-end gap-2">
                  <a href="/Admin/kategori-artikel/<?= esc($kategori['id']); ?>/edit"
                    class="inline-flex items-center rounded-lg border border-indigo-500 px-3 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-50 dark:border-indigo-400 dark:text-indigo-300 dark:hover:bg-indigo-500/20">
                    Edit
                  </a>
                  <form action="/Admin/kategori-artikel/<?= esc($kategori['id']); ?>/delete" method="post"
                    onsubmit="return confirm('Hapus kategori ini?');">
                    <?= csrf_field(); ?>
                    <button type="submit"
                      class="inline-flex items-center rounded-lg border border-red-500 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-400 dark:text-red-300 dark:hover:bg-red-500/20">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-300">
              Belum ada kategori yang tersedia.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection(); ?>