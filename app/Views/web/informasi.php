<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<!-- ===== Page Header ===== -->
<section class="page-header">
  <div class="container">
    <h1 class="page-title">Informasi Lengkap</h1>
    <p class="page-subtitle">Berbagai informasi tentang Kecamatan Nosu, Mamasa</p>
  </div>
</section>

<!-- ===== Informasi Grid Section ===== -->
<section class="informasi-page">
  <div class="container">
    <div class="informasi-grid" id="informasiGrid">
      <!-- Informasi cards will be loaded here by JavaScript -->
    </div>
  </div>
</section>

<?= $this->endSection(); ?>