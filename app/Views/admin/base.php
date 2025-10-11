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
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                      href="index.html">
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

          <?= $this->renderSection('content'); ?>
        </div>
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <script defer src="/panel_assets/bundle.js"></script>
</body>

</html>