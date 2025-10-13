<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>
    <?= $pageTitle; ?>
  </title>
  <link rel="icon" href="favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="/panel_assets/style.css" rel="stylesheet">
</head>

<body
  x-data="{ page: 'blank', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">
  <?php
  $session = session();
  $flashMessage = $session->getFlashdata('message');
  $flashError = $session->getFlashdata('error');
  $modalErrors = $session->getFlashdata('errors') ?? [];
  $shouldOpenSettingsModal = $session->getFlashdata('openSettingsModal');
  ?>
  <!-- ===== Preloader Start ===== -->
  <div x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
    <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
  </div>

  <!-- ===== Preloader End ===== -->

  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    <?= $this->include('admin/partials/sidebar'); ?>

    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <!-- Small Device Overlay Start -->
      <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
        class="fixed w-full h-screen z-9 bg-gray-900/50"></div>
      <!-- Small Device Overlay End -->

      <!-- ===== Header Start ===== -->
      <?= $this->include('admin/partials/header'); ?>
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
      <main>
        <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
          <!-- Breadcrumb Start -->
          <div x-data="{ pageName: `<?= esc($pageTitle ?? 'Blank Page') ?>`}">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>

              <nav>
                <ol class="flex items-center gap-1.5">
                  <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="/Admin/">
                      Home
                      <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </li>
                  <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName"></li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Breadcrumb End -->

          <?php if (! empty($flashMessage)) : ?>
            <div
              class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              <span><?= esc($flashMessage); ?></span>
            </div>
          <?php endif; ?>

          <?php if (! empty($flashError)) : ?>
            <div
              class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-200">
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
              </svg>
              <span><?= esc($flashError); ?></span>
            </div>
          <?php endif; ?>

          <?= $this->renderSection('content'); ?>
        </div>
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <?= $this->include('admin/partials/lightbox'); ?>
  <div id="settings-modal"
    class="fixed inset-0 z-[100000] hidden items-center justify-center bg-gray-900/60 p-4 backdrop-blur-sm">
    <div data-modal-overlay class="flex h-full w-full items-center justify-center">
      <div
        class="relative w-full max-w-xl rounded-3xl border border-gray-200 bg-white p-6 shadow-2xl dark:border-gray-800 dark:bg-gray-900 sm:p-8">
        <div class="mb-6 flex items-start justify-between gap-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Akun Admin</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi akun Anda.
            </p>
          </div>
          <button type="button"
            class="text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
            data-modal-close>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <?php if (! empty($modalErrors)) : ?>
          <div
            class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-200">
            <p class="mb-2 font-semibold">Periksa kembali data yang Anda masukkan:</p>
            <ul class="list-disc space-y-1 pl-5">
              <?php foreach ($modalErrors as $error) : ?>
                <li><?= esc($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="/Admin/pengaturan/update" method="post" class="space-y-5" autocomplete="off">
          <?= csrf_field(); ?>
          <div class="space-y-1">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
              Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap"
              value="<?= esc(old('nama_lengkap', (string) ($session->get('namaLengkap') ?? ''))); ?>"
              class="block w-full bg-white rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-brand-400 dark:focus:ring-brand-500/40"
              required>
          </div>

          <div class="space-y-1">
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
            <input type="text" id="username" name="username"
              value="<?= esc(old('username', (string) ($session->get('username') ?? ''))); ?>"
              class="block w-full bg-white rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-brand-400 dark:focus:ring-brand-500/40"
              required>
          </div>

          <div class="space-y-1">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
            <input type="email" id="email" name="email"
              value="<?= esc(old('email', (string) ($session->get('email') ?? ''))); ?>"
              class="block w-full bg-white rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-brand-400 dark:focus:ring-brand-500/40"
              required>
          </div>

          <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password
              Baru</label>
            <input type="password" id="password" name="password"
              placeholder="Kosongkan jika tidak ingin mengubah password"
              class="block w-full bg-white rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-brand-400 dark:focus:ring-brand-500/40"
              value="" autocomplete="off">
            <p class="text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak mau mengubah password.</p>
          </div>

          <div class="flex items-center justify-end gap-3">
            <button type="button"
              class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
              data-modal-close>Batal</button>
            <button type="submit"
              class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-brand-500/30 transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-300 dark:bg-brand-600 dark:hover:bg-brand-500">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script defer src="/panel_assets/bundle.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const body = document.body;
      const lightbox = document.getElementById('adminLightbox');
      if (!lightbox) {
        return;
      }

      const lightboxBackdrop = lightbox.querySelector('[data-lightbox-backdrop]');
      const lightboxImage = lightbox.querySelector('[data-lightbox-image]');
      const lightboxTitle = lightbox.querySelector('[data-lightbox-title]');
      const lightboxDescription = lightbox.querySelector('[data-lightbox-description]');
      const lightboxCloseButtons = lightbox.querySelectorAll('[data-lightbox-close]');

      const hideDescription = () => {
        if (!lightboxDescription) {
          return;
        }
        lightboxDescription.textContent = '';
        lightboxDescription.classList.add('hidden');
      };

      const showDescription = (text) => {
        if (!lightboxDescription) {
          return;
        }

        const trimmed = (text || '').trim();
        if (trimmed.length === 0) {
          hideDescription();
          return;
        }

        lightboxDescription.textContent = trimmed;
        lightboxDescription.classList.remove('hidden');
      };

      hideDescription();

      const openLightbox = (trigger) => {
        const image = trigger.getAttribute('data-lightbox-src');
        if (!image) {
          return;
        }

        const title = trigger.getAttribute('data-lightbox-title') || 'Pratinjau Foto';
        const description = trigger.getAttribute('data-lightbox-description') || '';

        lightboxImage.src = image;
        lightboxImage.alt = title;
        lightboxTitle.textContent = title;
        showDescription(description);

        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        body.classList.add('overflow-hidden');

        const closeButton = lightbox.querySelector('[data-lightbox-close]');
        if (closeButton) {
          setTimeout(() => closeButton.focus(), 120);
        }
      };

      const closeLightbox = () => {
        lightbox.classList.remove('flex');
        lightbox.classList.add('hidden');
        body.classList.remove('overflow-hidden');
        lightboxImage.src = '';
        hideDescription();
      };

      document.querySelectorAll('[data-admin-lightbox]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
          event.preventDefault();
          openLightbox(trigger);
        });

        trigger.addEventListener('keydown', (event) => {
          if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            openLightbox(trigger);
          }
        });
      });

      lightboxCloseButtons.forEach((button) => {
        button.addEventListener('click', closeLightbox);
      });

      lightbox.addEventListener('click', (event) => {
        if (event.target === lightboxBackdrop || event.target === lightbox) {
          closeLightbox();
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && lightbox.classList.contains('flex')) {
          closeLightbox();
        }
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('settings-modal');
      if (!modal) {
        return;
      }

      const openButtons = document.querySelectorAll('[data-modal-target="settings-modal"]');
      const closeButtons = modal.querySelectorAll('[data-modal-close]');

      const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
      };

      const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
      };

      openButtons.forEach((button) => {
        button.addEventListener('click', openModal);
      });

      closeButtons.forEach((button) => {
        button.addEventListener('click', closeModal);
      });

      modal.addEventListener('click', (event) => {
        if (event.target === modal) {
          closeModal();
        }
      });

      if (<?= $shouldOpenSettingsModal ? 'true' : 'false'; ?>) {
        openModal();
      }
    });
  </script>
</body>

</html>