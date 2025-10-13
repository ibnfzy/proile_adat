<div id="adminLightbox"
  class="fixed inset-0 z-[120] hidden items-center justify-center bg-slate-950/75 p-4 backdrop-blur-md">
  <div data-lightbox-backdrop class="absolute inset-0"></div>
  <div data-lightbox-container
    class="relative z-10 w-full max-w-5xl overflow-hidden rounded-3xl border border-white/10 bg-slate-900/80 shadow-2xl ring-1 ring-white/20">
    <div class="absolute -inset-px bg-gradient-to-br from-emerald-400/20 via-transparent to-indigo-500/20"></div>
    <button type="button" data-lightbox-close
      class="absolute right-6 top-6 z-20 inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:border-rose-400/70 hover:bg-rose-500/20 hover:text-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-400/40">
      <span class="sr-only">Tutup pratinjau foto</span>
      <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
        stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>

    <div class="relative grid gap-8 p-6 md:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] md:p-8">
      <figure class="relative isolate overflow-hidden rounded-2xl border border-white/10 bg-slate-950/40">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-emerald-500/10"></div>
        <img data-lightbox-image src="" alt="" class="relative z-10 h-full w-full max-h-[28rem] object-contain" />
      </figure>

      <div class="relative z-10 flex flex-col gap-4 text-slate-200">
        <div class="space-y-2">
          <p class="text-[0.7rem] uppercase tracking-[0.35em] text-emerald-300">Pratinjau Foto</p>
          <h3 data-lightbox-title class="text-2xl font-semibold leading-snug text-white"></h3>
        </div>
        <p data-lightbox-description class="text-sm leading-relaxed text-slate-300"></p>
        <div class="mt-auto flex items-center gap-2 text-xs text-slate-400">
          <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-3 py-1 font-medium">
            Tekan <kbd
              class="rounded border border-white/20 bg-slate-900/60 px-2 py-0.5 text-[0.65rem] font-semibold tracking-[0.3em] text-white">Esc</kbd>
            untuk menutup
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
