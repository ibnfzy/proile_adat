<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<!-- ===== Breadcrumb ===== -->
<section class="breadcrumb">
  <div class="container">
    <a href="<?= site_url('/') ?>">Home</a>
    <span>/</span>
    <a href="<?= site_url('artikel') ?>">Artikel</a>
    <span>/</span>
    <span id="breadcrumbTitle">Detail</span>
  </div>
</section>

<!-- ===== Artikel Detail Section ===== -->
<section class="artikel-detail-section">
  <div class="container">
    <article class="artikel-detail" id="artikelDetail">
      <!-- Content will be loaded by JavaScript -->
    </article>

    <!-- Related Articles -->
    <div class="related-articles">
      <h3>Artikel Terkait</h3>
      <div class="related-grid" id="relatedGrid">
        <!-- Related articles will be loaded here -->
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>