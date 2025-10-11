<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Informasi</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Perbarui informasi agar tetap akurat dan relevan.</p>
  </div>

  <?php $errors = session('errors') ?? []; ?>

  <form action="/Admin/informasi/<?= esc($informasi['id']); ?>/update" method="post" class="space-y-6">
    <?= csrf_field(); ?>

    <div>
      <label for="judul" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Judul Informasi</label>
      <input type="text" name="judul" id="judul" value="<?= old('judul', $informasi['judul']); ?>"
        class="w-full rounded-xl border <?= isset($errors['judul']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Contoh: Jadwal Pelayanan Kantor" />
      <?php if (isset($errors['judul'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['judul']); ?></p>
      <?php endif; ?>
    </div>

    <div>
      <label for="emoji" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Emoji</label>
      <input type="text" name="emoji" id="emoji" value="<?= old('emoji', $informasi['emoji']); ?>" maxlength="10"
        class="w-full rounded-xl border <?= isset($errors['emoji']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Contoh: 📢" />
      <?php if (isset($errors['emoji'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['emoji']); ?></p>
      <?php endif; ?>
    </div>

    <div>
      <label for="gambar" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">URL / Path Gambar</label>
      <input type="text" name="gambar" id="gambar" value="<?= old('gambar', $informasi['gambar']); ?>"
        class="w-full rounded-xl border <?= isset($errors['gambar']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Contoh: uploads/informasi/jadwal.jpg" />
      <?php if (isset($errors['gambar'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['gambar']); ?></p>
      <?php endif; ?>
    </div>

    <div>
      <label for="konten" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Konten Informasi</label>
      <textarea name="konten" id="konten" rows="8"
        class="w-full rounded-xl border <?= isset($errors['konten']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Tuliskan isi informasi secara lengkap..."><?= old('konten', $informasi['konten']); ?></textarea>
      <?php if (isset($errors['konten'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['konten']); ?></p>
      <?php endif; ?>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="/Admin/informasi" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800/60">
        Batal
      </a>
      <button type="submit"
        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Perbarui Informasi
      </button>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
