<?php
  $uri         = service('uri');
  $currentPath = trim((string) $uri->getPath(), '/');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Profil Adat Istiadat Kecamatan Nosu, Kabupaten Mamasa – Sulawesi Barat">
  <meta name="base-url" content="<?= base_url() ?>">
  <title>Profil Adat & Budaya Kecamatan Nosu</title>
  <link rel="stylesheet" href="<?= base_url('website_assets/style.css') ?>">
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
            <li>
              <a href="<?= site_url('/') ?>" class="nav-link <?= $currentPath === '' ? 'active' : '' ?>">Home</a>
            </li>
            <li>
              <a href="<?= site_url('informasi') ?>" class="nav-link <?= strpos($currentPath, 'informasi') === 0 ? 'active' : '' ?>">Informasi</a>
            </li>
            <li>
              <a href="<?= site_url('artikel') ?>" class="nav-link <?= strpos($currentPath, 'artikel') === 0 ? 'active' : '' ?>">Artikel</a>
            </li>
            <li>
              <a href="<?= site_url('/') ?>#galeri" data-scroll-target="#galeri" class="nav-link">Galeri</a>
            </li>
            <li>
              <a href="<?= site_url('login') ?>" class="nav-link">Admin</a>
            </li>
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

    <script src="<?= base_url('website_assets/app.js') ?>"></script>
</body>

</html>