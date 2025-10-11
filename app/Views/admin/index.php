<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>

<div class="space-y-10">
  <section
    class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white/80 p-8 shadow-lg shadow-brand-500/5 backdrop-blur-xl dark:border-gray-800 dark:bg-white/[0.03] sm:p-10 lg:p-12">
    <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
      <div class="max-w-xl space-y-3">
        <span
          class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700 dark:bg-brand-500/10 dark:text-brand-100">
          Ringkasan singkat
        </span>
        <h1 class="text-3xl font-semibold leading-tight text-gray-900 dark:text-white/90 sm:text-4xl">
          Selamat datang di Dashboard Admin
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
          Pantau perkembangan artikel, informasi penting, dan galeri foto dalam satu tempat. Gunakan ringkasan di bawah
          ini untuk melihat sekilas performa konten terbaru Anda.
        </p>
      </div>
    </div>
    <div
      class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-gradient-to-br from-brand-500/10 to-brand-500/0 blur-3xl">
    </div>
  </section>

  <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
    <article
      class="group relative overflow-hidden rounded-3xl border border-blue-200/60 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 p-7 text-white shadow-lg shadow-blue-500/30">
      <div
        class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl transition duration-300 group-hover:scale-110">
      </div>
      <div class="relative z-10 flex items-start justify-between gap-6">
        <div class="space-y-4">
          <p class="text-sm font-medium uppercase tracking-wide text-white/70">Total Artikel</p>
          <h2 class="text-4xl font-semibold leading-tight">
            <?= number_format((int) ($artikelCount ?? 0), 0, ',', '.'); ?>
          </h2>
          <a href="/Admin/artikel"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white/90 transition hover:text-white">
            Kelola Artikel
            <svg class="h-4 w-4" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="currentColor" stroke-width="1.2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
        <div
          class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-white shadow-lg shadow-blue-500/40">
          <svg class="h-10 w-10 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path
              d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z" />
          </svg>
        </div>
      </div>
    </article>

    <article
      class="group relative overflow-hidden rounded-3xl border border-purple-200/60 bg-gradient-to-br from-purple-500 via-fuchsia-500 to-pink-500 p-7 text-white shadow-lg shadow-purple-500/30">
      <div
        class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl transition duration-300 group-hover:scale-110">
      </div>
      <div class="relative z-10 flex items-start justify-between gap-6">
        <div class="space-y-4">
          <p class="text-sm font-medium uppercase tracking-wide text-white/70">Total Informasi</p>
          <h2 class="text-4xl font-semibold leading-tight">
            <?= number_format((int) ($informasiCount ?? 0), 0, ',', '.'); ?>
          </h2>
          <a href="/Admin/informasi"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white/90 transition hover:text-white">
            Kelola Informasi
            <svg class="h-4 w-4" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="currentColor" stroke-width="1.2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
        <div
          class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-white shadow-lg shadow-purple-500/40">
          <svg class="h-10 w-10 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path
              d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM288 224C288 206.3 302.3 192 320 192C337.7 192 352 206.3 352 224C352 241.7 337.7 256 320 256C302.3 256 288 241.7 288 224zM280 288L328 288C341.3 288 352 298.7 352 312L352 400L360 400C373.3 400 384 410.7 384 424C384 437.3 373.3 448 360 448L280 448C266.7 448 256 437.3 256 424C256 410.7 266.7 400 280 400L304 400L304 336L280 336C266.7 336 256 325.3 256 312C256 298.7 266.7 288 280 288z" />
          </svg>
        </div>
      </div>
    </article>

    <article
      class="group relative overflow-hidden rounded-3xl border border-emerald-200/60 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 p-7 text-white shadow-lg shadow-emerald-500/30">
      <div
        class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl transition duration-300 group-hover:scale-110">
      </div>
      <div class="relative z-10 flex items-start justify-between gap-6">
        <div class="space-y-4">
          <p class="text-sm font-medium uppercase tracking-wide text-white/70">Total Foto Galeri</p>
          <h2 class="text-4xl font-semibold leading-tight">
            <?= number_format((int) ($galeriCount ?? 0), 0, ',', '.'); ?>
          </h2>
          <a href="/Admin/galeri"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white/90 transition hover:text-white">
            Kelola Galeri
            <svg class="h-4 w-4" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="currentColor" stroke-width="1.2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        </div>
        <div
          class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-white shadow-lg shadow-emerald-500/40">
          <svg class="h-10 w-10 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path
              d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160C544 124.7 515.3 96 480 96L160 96zM224 176C250.5 176 272 197.5 272 224C272 250.5 250.5 272 224 272C197.5 272 176 250.5 176 224C176 197.5 197.5 176 224 176zM368 288C376.4 288 384.1 292.4 388.5 299.5L476.5 443.5C481 450.9 481.2 460.2 477 467.8C472.8 475.4 464.7 480 456 480L184 480C175.1 480 166.8 475 162.7 467.1C158.6 459.2 159.2 449.6 164.3 442.3L220.3 362.3C224.8 355.9 232.1 352.1 240 352.1C247.9 352.1 255.2 355.9 259.7 362.3L286.1 400.1L347.5 299.6C351.9 292.5 359.6 288.1 368 288.1z" />
          </svg>
        </div>
      </div>
    </article>
  </section>
</div>

<?= $this->endSection(); ?>