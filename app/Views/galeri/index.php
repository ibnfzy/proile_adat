<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($pageTitle ?? 'Galeri'); ?></title>
  <meta name="description" content="Galeri foto adat Nosu dengan tampilan modern dan pengalaman melihat yang memukau." />
  <link rel="icon" href="/favicon.ico" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    body {
      background: radial-gradient(circle at top left, rgba(16, 185, 129, 0.15), transparent 45%),
        radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.15), transparent 45%),
        #020617;
    }

    .hidden {
      display: none !important;
    }

    .glass-panel {
      backdrop-filter: blur(18px);
      background: rgba(15, 23, 42, 0.82);
      border: 1px solid rgba(148, 163, 184, 0.15);
    }

    .lightbox-open {
      overflow: hidden;
    }

    #lightboxMedia {
      background: radial-gradient(circle at center, rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.9));
    }

    #lightboxMedia img,
    #lightboxMedia video {
      max-height: min(80vh, 640px);
      width: 100%;
      object-fit: contain;
      background-color: #000;
      transition: opacity 0.2s ease-in-out;
    }

    #lightboxMedia video {
      border: none;
    }
  </style>
</head>

<body class="min-h-screen text-slate-100">
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute -left-32 top-20 h-72 w-72 rounded-full bg-emerald-500/20 blur-3xl"></div>
    <div class="absolute right-[-10%] top-40 h-80 w-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
  </div>

  <main class="relative z-10 mx-auto max-w-6xl px-6 py-16">
    <header class="mb-12 text-center">
      <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/40 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300/80">
        Galeri Adat Nosu
      </p>
      <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Jelajahi Momen Budaya yang Menakjubkan</h1>
      <p class="mt-4 text-base text-slate-300 sm:text-lg">Koleksi foto-foto terbaik yang menangkap kehangatan, keindahan, dan kekayaan tradisi adat Nosu. Gunakan pencarian untuk menemukan momen favorit Anda.</p>
    </header>

    <form action="/galeri" method="get" class="mx-auto mb-12 max-w-xl">
      <label for="search" class="sr-only">Cari foto berdasarkan judul</label>
      <div class="glass-panel relative flex items-center rounded-2xl px-5 py-3 shadow-xl">
        <svg class="h-5 w-5 text-emerald-300/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="7"></circle>
          <line x1="20" y1="20" x2="16.65" y2="16.65"></line>
        </svg>
        <input id="search" name="search" value="<?= esc($search); ?>" type="text" placeholder="Cari berdasarkan judul foto..."
          class="ml-3 w-full bg-transparent text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none" />
        <?php if ($search): ?>
          <a href="/galeri" class="text-xs font-semibold uppercase tracking-widest text-emerald-300 transition hover:text-emerald-200">Reset</a>
        <?php endif; ?>
      </div>
    </form>

    <?php if (! empty($photos)): ?>
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($photos as $photo): ?>
          <?php
          $imagePath = $photo['gambar'] ?? '';
          $videoPath = $photo['video'] ?? '';
          $imageUrl  = $imagePath ? base_url('uploads/' . ltrim((string) $imagePath, '/')) : '';
          $videoUrl  = $videoPath ? base_url('uploads/' . ltrim((string) $videoPath, '/')) : '';
          $hasVideo  = $videoUrl !== '';
          $hasImage  = $imageUrl !== '';
          $fallbackImage = 'https://via.placeholder.com/1200x675?text=Video';
          ?>
          <article class="group relative overflow-hidden rounded-3xl border border-slate-100/10 bg-white/5 shadow-2xl shadow-emerald-500/10 transition duration-500 hover:-translate-y-1 hover:border-emerald-400/40 hover:shadow-emerald-500/30">
            <button type="button" data-lightbox-trigger
              data-image="<?= esc($hasImage ? $imageUrl : ($hasVideo ? $fallbackImage : ''), 'attr'); ?>"
              <?php if ($hasVideo): ?> data-video="<?= esc($videoUrl, 'attr'); ?>"<?php endif; ?>
              data-title="<?= esc($photo['judul'], 'attr'); ?>"
              data-description="<?= esc($photo['deskripsi'] ?? '', 'attr'); ?>"
              data-type="<?= $hasVideo ? 'video' : 'image'; ?>"
              class="relative block w-full">
              <div class="aspect-video overflow-hidden">
                <?php if ($hasVideo): ?>
                  <img src="<?= esc($hasImage ? $imageUrl : $fallbackImage, 'attr'); ?>" alt="<?= esc($photo['judul'], 'attr'); ?>"
                    class="h-full w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy" />
                  <div class="absolute inset-0 flex items-center justify-center bg-slate-950/30">
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-emerald-500/90 text-white shadow-lg shadow-emerald-500/40 transition group-hover:scale-110">▶</span>
                  </div>
                <?php else: ?>
                  <img src="<?= esc($imageUrl ?: $fallbackImage, 'attr'); ?>" alt="<?= esc($photo['judul'], 'attr'); ?>"
                    class="h-full w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy" />
                <?php endif; ?>
              </div>
              <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent p-5 text-left">
                <h2 class="text-lg font-semibold text-white"><?= esc($photo['judul']); ?></h2>
                <?php if (! empty($photo['deskripsi'])): ?>
                  <p class="mt-1 line-clamp-2 text-xs text-slate-300/80"><?= esc(character_limiter($photo['deskripsi'] ?? '', 90)); ?></p>
                <?php endif; ?>
                <p class="mt-3 text-[11px] uppercase tracking-[0.35em] text-emerald-300/80">Klik untuk melihat detail</p>
              </div>
            </button>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="glass-panel mx-auto mt-16 max-w-2xl rounded-3xl px-10 py-12 text-center shadow-2xl">
        <h2 class="text-2xl font-semibold text-white">Tidak ada foto ditemukan</h2>
        <p class="mt-3 text-sm text-slate-300">Coba gunakan kata kunci lainnya atau kembali lagi nanti untuk melihat pembaruan galeri.</p>
        <a href="/" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 transition hover:text-emerald-200">
          <svg class="h-4 w-4" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.9235 4.33301L6.75684 8.49967L10.9235 12.6663" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Kembali ke Beranda
        </a>
      </div>
    <?php endif; ?>
  </main>

  <div id="lightbox" class="fixed inset-0 z-50 hidden place-items-center bg-slate-950/90 p-6">
      <div class="glass-panel relative w-full max-w-4xl overflow-hidden rounded-3xl">
        <button type="button" id="lightboxClose" class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-100/20 bg-slate-900/60 text-slate-100 transition hover:border-red-400/60 hover:text-red-200">
          <span class="sr-only">Tutup</span>
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
        <div class="flex flex-col gap-0 lg:flex-row">
          <div id="lightboxMedia" class="lg:w-3/5">
            <img id="lightboxImage" src="" alt="" class="lightbox-media" />
            <video id="lightboxVideo" controls preload="metadata" class="lightbox-media hidden" data-background-music-interrupt></video>
          </div>
        <div class="flex flex-1 flex-col gap-4 p-6">
          <div>
            <p class="text-xs uppercase tracking-[0.45em] text-emerald-300/80">Galeri Adat Nosu</p>
            <h3 id="lightboxTitle" class="mt-2 text-2xl font-semibold text-white"></h3>
          </div>
          <p id="lightboxDescription" class="text-sm leading-relaxed text-slate-300"></p>
          <div class="mt-auto flex items-center justify-between pt-6 text-xs text-slate-400">
            <span>Tekan <kbd class="rounded border border-slate-600 bg-slate-800 px-2 py-1 text-[10px] tracking-[0.3em] text-slate-200">Esc</kbd> untuk menutup</span>
            <a id="lightboxDownload" href="#" download class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 px-3 py-1.5 font-semibold text-emerald-300 transition hover:border-emerald-300 hover:text-emerald-200">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3V15" />
                <path d="M8 11L12 15L16 11" />
                <path d="M20 18H4" />
              </svg>
              <span id="lightboxDownloadLabel">Unduh Foto</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const body = document.body;
      const lightbox = document.getElementById('lightbox');
      const lightboxImage = document.getElementById('lightboxImage');
      const lightboxVideo = document.getElementById('lightboxVideo');
      const lightboxTitle = document.getElementById('lightboxTitle');
      const lightboxDescription = document.getElementById('lightboxDescription');
      const lightboxDownload = document.getElementById('lightboxDownload');
      const lightboxDownloadLabel = document.getElementById('lightboxDownloadLabel');
      const closeButton = document.getElementById('lightboxClose');

      function resetVideo() {
        lightboxVideo.pause();
        lightboxVideo.currentTime = 0;
        lightboxVideo.removeAttribute('src');
        lightboxVideo.removeAttribute('poster');
        lightboxVideo.load();
        lightboxVideo.classList.add('hidden');
      }

      function showImage(src, altText) {
        if (src) {
          lightboxImage.src = src;
        } else {
          lightboxImage.removeAttribute('src');
        }
        lightboxImage.alt = altText || 'Foto Galeri';
        lightboxImage.classList.remove('hidden');
      }

      function openLightbox({ image, video, title, description, type }) {
        const isVideo = type === 'video' && video;

        lightboxTitle.textContent = title || 'Tanpa Judul';
        lightboxDescription.textContent = description || 'Tidak ada deskripsi tambahan untuk foto ini.';

        resetVideo();

        if (isVideo) {
          lightboxImage.classList.add('hidden');
          if (image) {
            // Keep image cached so next switch back to image type is instant
            lightboxImage.src = image;
            lightboxVideo.poster = image;
          } else {
            lightboxVideo.removeAttribute('poster');
          }
          lightboxVideo.src = video;
          lightboxVideo.classList.remove('hidden');
          lightboxVideo.load();
          lightboxDownload.href = video;
          lightboxDownloadLabel.textContent = 'Unduh Video';
        } else {
          showImage(image, title);
          lightboxDownload.href = image || '#';
          lightboxDownloadLabel.textContent = 'Unduh Foto';
        }

        lightbox.classList.remove('hidden');
        lightbox.classList.add('grid');
        body.classList.add('lightbox-open');
        setTimeout(() => closeButton.focus(), 120);
      }

      function closeLightbox() {
        resetVideo();
        lightbox.classList.remove('grid');
        lightbox.classList.add('hidden');
        body.classList.remove('lightbox-open');
        lightboxImage.src = '';
        lightboxDownload.href = '#';
        lightboxDownloadLabel.textContent = 'Unduh Foto';
      }

      document.querySelectorAll('[data-lightbox-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
          openLightbox({
            image: trigger.getAttribute('data-image'),
            video: trigger.getAttribute('data-video'),
            title: trigger.getAttribute('data-title'),
            description: trigger.getAttribute('data-description'),
            type: trigger.getAttribute('data-type'),
          });
        });
      });

      closeButton.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) {
          closeLightbox();
        }
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          closeLightbox();
        }
      });
    })();
  </script>
</body>

</html>
