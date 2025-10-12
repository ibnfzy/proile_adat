<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<!-- ===== Page Header ===== -->
<section class="page-header">
  <div class="container">
    <h1 class="page-title">Semua Artikel</h1>
    <p class="page-subtitle">Kumpulan artikel tentang adat istiadat dan budaya Kecamatan Nosu</p>
  </div>
</section>

<!-- ===== Filter & Search Section ===== -->
<section class="filter-section">
  <div class="container">
    <div class="filter-controls">
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari artikel...">
      </div>
      <div class="filter-buttons">
        <button class="filter-btn active" data-category="all">Semua</button>
        <button class="filter-btn" data-category="adat">Adat Istiadat</button>
        <button class="filter-btn" data-category="budaya">Budaya</button>
        <button class="filter-btn" data-category="sejarah">Sejarah</button>
      </div>
    </div>
  </div>
</section>

<!-- ===== Artikel Grid Section ===== -->
<section class="artikel-page">
  <div class="container">
    <div class="artikel-grid" id="artikelGrid">
      <!-- Artikel cards will be loaded here by JavaScript -->
    </div>
  </div>
</section>

<?= $this->endSection(); ?>