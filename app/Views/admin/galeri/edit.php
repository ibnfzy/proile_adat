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

    <?php
      $defaultMedia = ! empty($photo['video']) ? 'video' : 'image';
      $selectedMedia = old('media_type', $defaultMedia);
    ?>

    <div>
      <span class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Pilih Jenis Media</span>
      <div class="flex flex-wrap gap-3">
        <label class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-600 transition hover:border-emerald-400 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-300">
          <input type="radio" name="media_type" value="image" <?= $selectedMedia === 'image' ? 'checked' : ''; ?> class="h-4 w-4 text-emerald-600 focus:ring-emerald-500" required>
          Gunakan Foto
        </label>
        <label class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-600 transition hover:border-emerald-400 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-300">
          <input type="radio" name="media_type" value="video" <?= $selectedMedia === 'video' ? 'checked' : ''; ?> class="h-4 w-4 text-emerald-600 focus:ring-emerald-500">
          Gunakan Video
        </label>
      </div>
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pilih media yang akan ditampilkan di galeri.</p>
    </div>

    <div data-media-section="image" class="hidden space-y-4">
      <div>
        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Saat Ini</label>
        <?php if (! empty($photo['gambar'])): ?>
          <button type="button" data-admin-lightbox
            data-lightbox-src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>"
            data-lightbox-title="<?= esc($photo['judul'], 'attr'); ?>"
            data-lightbox-description="<?= esc(character_limiter(strip_tags($photo['deskripsi'] ?? ''), 160), 'attr'); ?>"
            class="block w-full overflow-hidden rounded-xl border border-gray-200 bg-gray-50 shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400 dark:border-gray-700 dark:bg-gray-900/50">
            <span class="sr-only">Perbesar foto galeri saat ini</span>
            <img src="<?= esc(base_url('uploads/' . ($photo['gambar'] ?? '')), 'attr'); ?>" alt="<?= esc($photo['judul'], 'attr'); ?>"
              class="h-56 w-full object-cover" />
          </button>
        <?php else: ?>
          <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-300">
            Belum ada foto yang diunggah. Anda dapat menambahkan foto baru di bawah ini.
          </div>
        <?php endif; ?>
      </div>

      <div>
        <label for="gambar" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Ganti Foto</label>
        <input type="file" id="gambar" name="gambar" accept="image/png,image/jpeg,image/jpg,image/webp"
          class="w-full rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 text-sm text-gray-600 transition file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:font-medium file:text-white hover:border-emerald-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:file:bg-emerald-500" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengganti foto. Format yang diizinkan: JPG, PNG, atau WEBP.</p>
      </div>
    </div>

    <div data-media-section="video" class="hidden space-y-4">
      <div>
        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Video Saat Ini</label>
        <?php if (! empty($photo['video'])): ?>
          <video src="<?= esc(base_url('uploads/' . ltrim((string) $photo['video'], '/')), 'attr'); ?>" controls preload="metadata"
            class="w-full rounded-lg bg-black"></video>
        <?php else: ?>
          <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-300">
            Belum ada video yang diunggah. Anda dapat menambahkan video baru di bawah ini.
          </div>
        <?php endif; ?>
      </div>

      <div>
        <label for="video" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Unggah Video Baru</label>
        <input type="file" id="video" name="video" accept="video/mp4,video/webm,video/ogg"
          class="w-full rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 text-sm text-gray-600 transition file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:font-medium file:text-white hover:border-emerald-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:file:bg-emerald-500" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format video yang didukung: MP4, WEBM, atau OGG (maksimal 50MB).</p>
      </div>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="/Admin/galeri" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Batal</a>
      <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">Update Foto</button>
    </div>
  </form>
</div>
<script>
  (function () {
    const mediaRadios = document.querySelectorAll('input[name="media_type"]');
    const mediaSections = document.querySelectorAll('[data-media-section]');

    function toggleMediaSections() {
      const selected = document.querySelector('input[name="media_type"]:checked');
      const selectedValue = selected ? selected.value : 'image';

      mediaSections.forEach((section) => {
        const type = section.getAttribute('data-media-section');
        if (type === selectedValue) {
          section.classList.remove('hidden');
        } else {
          section.classList.add('hidden');
        }
      });
    }

    mediaRadios.forEach((radio) => {
      radio.addEventListener('change', toggleMediaSections);
    });

    toggleMediaSections();
  })();
</script>
<?= $this->endSection(); ?>
