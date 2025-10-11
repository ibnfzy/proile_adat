<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="mx-auto max-w-3xl rounded-2xl border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Kategori Artikel</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Perbarui informasi kategori artikel yang dipilih.</p>
    </div>
    <a href="/Admin/kategori-artikel" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">&larr; Kembali ke daftar</a>
  </div>

  <?php $errors = session()->getFlashdata('errors') ?? []; ?>

  <?php if (! empty($errors)): ?>
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900/60 dark:bg-red-900/30 dark:text-red-200">
      <ul class="list-disc space-y-1 pl-5">
        <?php foreach ($errors as $error): ?>
          <li><?= esc($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="/Admin/kategori-artikel/<?= esc($kategori['id']); ?>/update" method="post" class="space-y-6">
    <?= csrf_field(); ?>
    <div>
      <label for="nama" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Kategori</label>
      <input type="text" id="nama" name="nama" value="<?= esc(old('nama', $kategori['nama'])); ?>"
        class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Contoh: Budaya Daerah" required />
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="/Admin/kategori-artikel"
        class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Batal</a>
      <button type="submit"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan Perubahan</button>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
