<?= $this->extend('admin/base'); ?>

<?= $this->section('content'); ?>
  <div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          <?= $isShowingApproved ? 'Komentar Layak Tayang' : 'Komentar Menunggu Review'; ?>
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          <?= $isShowingApproved
            ? 'Daftar komentar yang telah disetujui dan tampil di halaman publik.'
            : 'Tinjau komentar yang dikirim pengunjung sebelum ditampilkan ke publik.'; ?>
        </p>
      </div>
      <div class="flex items-center gap-2">
        <?php if ($isShowingApproved) : ?>
          <a href="/Admin/komentar" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
            Lihat komentar yang belum dicek
          </a>
        <?php else : ?>
          <a href="/Admin/komentar?show=approved" class="inline-flex items-center gap-2 rounded-xl border border-brand-200 bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-600 transition hover:bg-brand-100 dark:border-brand-400/40 dark:bg-brand-500/10 dark:text-brand-200">
            Lihat semua komentar layak
          </a>
        <?php endif; ?>
      </div>
    </div>

    <?php if (empty($comments)) : ?>
      <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
        <p class="text-base font-medium">
          <?= $isShowingApproved ? 'Belum ada komentar yang disetujui.' : 'Belum ada komentar yang perlu direview.'; ?>
        </p>
        <p class="mt-1 text-sm">
          <?= $isShowingApproved
            ? 'Setelah komentar disetujui, daftar komentar yang layak akan tampil di sini.'
            : 'Komentar yang dikirim pengunjung akan muncul otomatis untuk ditinjau.'; ?>
        </p>
      </div>
    <?php else : ?>
      <div class="space-y-4">
        <?php foreach ($comments as $comment) : ?>
          <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-brand-200 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-brand-500/40">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
              <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                  <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-600 dark:bg-brand-500/10 dark:text-brand-200">
                    <?= esc($comment['content_type']); ?>
                  </span>
                  <span>pada</span>
                  <span class="font-medium text-gray-900 dark:text-gray-100">
                    <?= esc($comment['content_title']); ?>
                  </span>
                </div>

                <div>
                  <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    <?= esc($comment['nama']); ?>
                    <?php if (! empty($comment['email'])) : ?>
                      <span class="text-gray-400">•</span>
                      <span class="text-sm text-gray-500 dark:text-gray-400"><?= esc($comment['email']); ?></span>
                    <?php endif; ?>
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    Dikirim <?= esc($comment['created_at_human'] ?? $comment['created_at']); ?>
                  </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-4 text-sm leading-relaxed text-gray-700 dark:bg-gray-800/60 dark:text-gray-200">
                  <?= nl2br(esc($comment['komentar'])); ?>
                </div>

                <?php if (! empty($comment['checked_at_human']) && ! empty($comment['checked_by_name'])) : ?>
                  <p class="text-xs text-emerald-600 dark:text-emerald-300">
                    Ditinjau oleh <?= esc($comment['checked_by_name']); ?> pada <?= esc($comment['checked_at_human']); ?>
                  </p>
                <?php endif; ?>
              </div>

              <div class="flex w-full items-center justify-end gap-2 md:w-auto md:flex-col md:items-end">
                <?php if ($comment['status'] === 'pending') : ?>
                  <form action="/Admin/komentar/<?= esc($comment['id']); ?>/status<?= $isShowingApproved ? '?show=approved' : ''; ?>" method="post" class="w-full md:w-auto">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/50">
                      Setujui
                    </button>
                  </form>
                  <form action="/Admin/komentar/<?= esc($comment['id']); ?>/status<?= $isShowingApproved ? '?show=approved' : ''; ?>" method="post" class="w-full md:w-auto">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-400/50">
                      Tandai Tidak Layak
                    </button>
                  </form>
                <?php else : ?>
                  <span class="inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <?= $comment['status'] === 'approved' ? 'Sudah Disetujui' : 'Ditandai Tidak Layak'; ?>
                  </span>
                <?php endif; ?>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
<?= $this->endSection(); ?>
