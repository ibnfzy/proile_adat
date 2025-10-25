<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
  <div class="mb-6">
    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Artikel</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Perbarui konten artikel agar selalu relevan dan akurat.</p>
  </div>

  <?php
  $errors = session('errors') ?? [];
  $imageErrors = [];

  foreach ($errors as $field => $message) {
    if (strpos((string) $field, 'gambar') === 0) {
      $imageErrors[] = $message;
    }
  }

  $existingImages = $artikel['images'] ?? [];
  ?>

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
      <label for="gambar" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Galeri Gambar Artikel</label>
      <input type="file" name="gambar[]" id="gambar" accept="image/png,image/jpeg,image/jpg,image/webp" multiple
        class="w-full cursor-pointer rounded-xl border <?= ! empty($imageErrors) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100" />
      <?php if (! empty($imageErrors)): ?>
        <div class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
          <?php foreach ($imageErrors as $message): ?>
            <p><?= esc($message); ?></p>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Tambahkan gambar baru untuk memperkaya artikel. Format yang diizinkan: JPG, PNG, atau WEBP (maksimal 4MB per gambar).</p>
      <?php endif; ?>

      <?php if (! empty($existingImages)): ?>
        <div class="mt-5 space-y-3">
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Gambar saat ini</p>
          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($existingImages as $imagePath): ?>
              <?php
              $displayImage = $imagePath;
              if (! preg_match('#^https?://#i', (string) $displayImage)) {
                $cleanImage = str_replace('\\', '/', ltrim((string) $displayImage, '/'));
                if (strpos($cleanImage, 'uploads/') === 0) {
                  $cleanImage = substr($cleanImage, strlen('uploads/')) ?: '';
                }
                $displayImage = base_url('/uploads/' . ltrim($cleanImage, '/'));
              }
              ?>
              <label class="group relative block overflow-hidden rounded-xl border border-gray-200 bg-gray-50 shadow-sm transition hover:border-indigo-400 focus-within:border-indigo-500 dark:border-gray-700 dark:bg-gray-800/60">
                <input type="checkbox" name="remove_images[]" value="<?= esc($imagePath, 'attr'); ?>"
                  class="peer absolute left-3 top-3 h-4 w-4 cursor-pointer rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <img src="<?= esc($displayImage, 'attr'); ?>" alt="Gambar artikel" class="h-40 w-full object-cover transition duration-500 group-hover:scale-105" />
                <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></span>
                <span class="pointer-events-none absolute bottom-3 left-3 inline-flex items-center rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-gray-800 shadow-sm backdrop-blur-sm transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-gray-900/80 dark:text-gray-100">Hapus gambar ini</span>
              </label>
            <?php endforeach; ?>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400">Centang gambar yang ingin dihapus lalu simpan perubahan.</p>
        </div>
      <?php endif; ?>
    </div>

    <div>
      <label for="video" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Video Artikel (Opsional)</label>
      <input type="file" name="video" id="video" accept="video/mp4,video/webm,video/ogg"
        class="w-full cursor-pointer rounded-xl border <?= isset($errors['video']) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?> bg-white px-4 py-2.5 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 dark:bg-gray-900 dark:text-gray-100" />
      <?php if (isset($errors['video'])): ?>
        <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?= esc($errors['video']); ?></p>
      <?php else: ?>
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Unggah video baru berformat MP4, WEBM, atau OGG (maksimal 50MB) jika diperlukan.</p>
      <?php endif; ?>

      <?php if (! empty($artikel['video'])): ?>
        <?php
        $currentVideo = $artikel['video'];
        if (! preg_match('#^https?://#i', (string) $currentVideo)) {
          $cleanVideo = str_replace('\\', '/', ltrim((string) $currentVideo, '/'));
          if (strpos($cleanVideo, 'uploads/') === 0) {
            $cleanVideo = substr($cleanVideo, strlen('uploads/')) ?: '';
          }
          $currentVideo = base_url('/uploads/' . ltrim($cleanVideo, '/'));
        }
        ?>
        <div class="mt-4 space-y-3 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
          <video src="<?= esc($currentVideo, 'attr'); ?>" controls class="w-full rounded-lg bg-black" preload="metadata"></video>
          <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
            <input type="checkbox" name="remove_video" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            Hapus video saat ini
          </label>
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
