<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Profil Adat Istiadat Kecamatan Nosu, Kabupaten Mamasa – Sulawesi Barat">
  <meta name="base_url" content="<?= base_url() ?>">
  <title>Profil Adat & Budaya Kecamatan Nosu</title>
  <link rel="stylesheet" href="/website_assets/style.css">
</head>

<body>
  <!-- ===== Header / Navigasi ===== -->
  <header class="header" id="header">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <h1>Kecamatan Nosu</h1>
        </div>
        <nav class="nav" id="nav">
          <ul class="nav-list">
            <li><a href="index.html" class="nav-link active">Home</a></li>
            <li><a href="informasi.html" class="nav-link">Informasi</a></li>
            <li><a href="artikel.html" class="nav-link">Artikel</a></li>
            <li><a href="#galeri" class="nav-link">Galeri</a></li>
            <li><a href="#admin" class="nav-link">Admin</a></li>
          </ul>
        </nav>
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>

  <?= $this->renderSection('content'); ?>

  <!-- ===== Footer ===== -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Kecamatan Nosu, Kabupaten Mamasa – Sulawesi Barat</p>
    </div>
  </footer>

  <script src="/website_assets/app.js"></script>
</body>

</html>