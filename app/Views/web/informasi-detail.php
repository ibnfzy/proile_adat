<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<!-- ===== Breadcrumb ===== -->
<section class="breadcrumb">
  <div class="container">
    <a href="index.html">Home</a>
    <span>/</span>
    <a href="informasi.html">Informasi</a>
    <span>/</span>
    <span id="breadcrumbTitle">Detail</span>
  </div>
</section>

<!-- ===== Informasi Detail Section ===== -->
<section class="informasi-detail-section">
  <div class="container">
    <article class="informasi-detail" id="informasiDetail">
      <!-- Content will be loaded by JavaScript -->
    </article>
  </div>
</section>

<?= $this->endSection(); ?>