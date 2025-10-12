<?= $this->extend('web/base'); ?>

<?= $this->section('content'); ?>

<!-- ===== Hero Section ===== -->
<section class="hero" id="home">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h2 class="hero-title">Profil Adat & Budaya Kecamatan Nosu</h2>
    <p class="hero-subtitle">Mengenal adat istiadat dan budaya masyarakat Nosu, Kabupaten Mamasa.</p>
    <div class="hero-buttons">
      <a href="<?= site_url('informasi') ?>" class="btn btn-primary">Lihat Informasi</a>
      <a href="<?= site_url('artikel') ?>" class="btn btn-secondary">Lihat Artikel</a>
    </div>
  </div>
</section>

<!-- ===== Informasi Singkat Section ===== -->
<section class="informasi" id="informasi">
  <div class="container">
    <h2 class="section-title">Tentang Kecamatan Nosu</h2>
    <p class="section-description">
      Kecamatan Nosu merupakan salah satu kecamatan di Kabupaten Mamasa, Sulawesi Barat yang kaya akan
      adat istiadat dan budaya lokal. Masyarakat Nosu masih menjaga warisan leluhur dengan sangat baik,
      terlihat dari berbagai upacara adat, kesenian tradisional, dan kearifan lokal yang masih lestari
      hingga saat ini. Keindahan alam pegunungan yang mengelilingi wilayah ini menambah pesona budaya
      yang dimiliki oleh masyarakat Nosu.
    </p>
    <div class="info-boxes" id="informasiPreview">
      <!-- Informasi cards will be loaded here by JavaScript -->
    </div>
    <div style="text-align: center; margin-top: 2rem;">
      <a href="<?= site_url('informasi') ?>" class="btn btn-primary">Lihat Semua Informasi</a>
    </div>
  </div>
</section>

<!-- ===== Artikel Terbaru Section ===== -->
<section class="artikel" id="artikel">
  <div class="container">
    <h2 class="section-title">Artikel Terbaru</h2>
    <div class="artikel-grid" id="artikelGrid">
      <!-- Artikel cards will be loaded here by JavaScript -->
    </div>
    <div style="text-align: center; margin-top: 2rem;">
      <a href="<?= site_url('artikel') ?>" class="btn btn-primary">Lihat Semua Artikel</a>
    </div>
  </div>
</section>

<!-- ===== Galeri Section ===== -->
<section class="galeri" id="galeri">
  <div class="container">
    <h2 class="section-title">Galeri Kegiatan Adat</h2>
    <div class="galeri-grid" id="galeriGrid">
      <!-- Gallery images will be loaded here by JavaScript -->
    </div>
  </div>
</section>

<?= $this->endSection(); ?>