<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="mx-auto max-w-3xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Foto Galeri</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Perbarui detail foto atau ganti gambar yang ditampilkan di galeri.</p>
  </div>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600 dark:border-red-900/60 dark:bg-red-900/30 dark:text-red-200">
      <ul class="list-inside list-disc space-y-1">
        <?php foreach ((array) session()->getFlashdata('errors') as $error): ?>
          <li><?= esc($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="/Admin/galeri/<?= esc($photo['id']); ?>/update" method="post" enctype="multipart/form-data" class="space-y-6">
    <?= csrf_field(); ?>

    <div>
      <label for="judul" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Judul Foto</label>
      <input type="text" id="judul" name="judul" value="<?= old('judul', $photo['judul']); ?>" required
        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" />
    </div>

    <div>
      <label for="deskripsi" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi (Opsional)</label>
      <textarea id="deskripsi" name="deskripsi" rows="4"
        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"><?= old('deskripsi', $photo['deskripsi']); ?></textarea>
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tuliskan konteks atau cerita yang relevan.</p>
    </div>

    <div>
      <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Saat Ini</label>
      <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">
        <img src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>" alt="<?= esc($photo['judul'], 'attr'); ?>"
          class="h-56 w-full object-cover" />
      </div>
    </div>

    <div>
      <label for="gambar" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Ganti Foto</label>
      <input type="file" id="gambar" name="gambar" accept="image/png,image/jpeg,image/jpg,image/webp"
        class="w-full rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 text-sm text-gray-600 transition file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:font-medium file:text-white hover:border-emerald-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:file:bg-emerald-500" />
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengganti foto.</p>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="/Admin/galeri" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Batal</a>
      <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">Update Foto</button>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
