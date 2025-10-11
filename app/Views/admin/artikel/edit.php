<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Artikel</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Perbarui konten artikel agar selalu relevan dan akurat.</p>
  </div>

  <?php $errors = session('errors') ?? []; ?>

  <form action="/Admin/artikel/<?= esc($artikel['id']); ?>/update" method="post" class="space-y-6" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div>
      <label for="judul" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Judul Artikel</label>
      <input type="text" name="judul" id="judul" value="<?= old('judul', $artikel['judul']); ?>"
        class="w-full rounded-xl border <?= isset($errors['judul']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Contoh: Tradisi Panen Raya Nosu" />
      <?php if (isset($errors['judul'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['judul']); ?></p>
      <?php endif; ?>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
      <div>
        <label for="kategori_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
        <select name="kategori_id" id="kategori_id"
          class="w-full rounded-xl border <?= isset($errors['kategori_id']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100">
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= esc($category['id']); ?>" <?= old('kategori_id', $artikel['kategori_id']) == $category['id'] ? 'selected' : ''; ?>>
              <?= esc($category['nama']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($errors['kategori_id'])): ?>
          <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['kategori_id']); ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label for="penulis_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Penulis</label>
        <select name="penulis_id" id="penulis_id"
          class="w-full rounded-xl border <?= isset($errors['penulis_id']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100">
          <option value="">-- Pilih Penulis --</option>
          <?php foreach ($authors as $author): ?>
            <option value="<?= esc($author['id']); ?>" <?= old('penulis_id', $artikel['penulis_id']) == $author['id'] ? 'selected' : ''; ?>>
              <?= esc($author['nama_lengkap'] ?? $author['username']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($errors['penulis_id'])): ?>
          <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['penulis_id']); ?></p>
        <?php endif; ?>
      </div>
    </div>

    <div>
      <label for="gambar" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Gambar Artikel</label>
      <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png"
        class="w-full cursor-pointer rounded-xl border <?= isset($errors['gambar']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100" />
      <?php if (isset($errors['gambar'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['gambar']); ?></p>
      <?php else: ?>
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengganti gambar. Format yang diizinkan: JPG atau PNG.</p>
      <?php endif; ?>
      <?php if (! empty($artikel['gambar'])): ?>
        <?php
        $currentImage = $artikel['gambar'];
        if (! preg_match('#^https?://#i', $currentImage)) {
            $cleanImage = str_replace('\\', '/', ltrim($currentImage, '/'));
            if (strpos($cleanImage, 'uploads/') === 0) {
              $cleanImage = substr($cleanImage, strlen('uploads/')) ?: '';
            }
            $currentImage = base_url('/uploads/' . ltrim($cleanImage, '/'));
        }
        ?>
        <div class="mt-4">
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Gambar saat ini</p>
          <img src="<?= esc($currentImage); ?>" alt="Gambar artikel saat ini" class="mt-2 h-32 w-32 rounded-lg object-cover" />
        </div>
      <?php endif; ?>
    </div>

    <div>
      <label for="isi" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Isi Artikel</label>
      <textarea name="isi" id="isi" rows="8"
        class="w-full rounded-xl border <?= isset($errors['isi']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100"
        placeholder="Tuliskan isi artikel secara lengkap..."><?= old('isi', $artikel['isi']); ?></textarea>
      <?php if (isset($errors['isi'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['isi']); ?></p>
      <?php endif; ?>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="/Admin/artikel" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800/60">
        Batal
      </a>
      <button type="submit"
        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Perbarui Artikel
      </button>
    </div>
  </form>
</div>
<?= $this->endSection(); ?>
