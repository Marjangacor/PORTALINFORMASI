<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telusuri Berita</title>
  <link rel="stylesheet" href="beritagr.css">
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="../../../foto/logo.png" alt="Logo" class="logo">
      <nav>
        <a href="../beranda/berandaguru.php">Beranda</a>
        <a href="beritaguru.php" class="active">Berita</a>
        <a href="../perpusguru/perpusgr.php">Perpustakaan</a>
        <a href="../../../landing_page/index.php">Kembali</a>
      </nav>
    </aside>

    <!-- Main Content --> 
    <main class="main-content">
      <h1>Telusuri berita</h1>
      <hr class="line">

      <!-- Search -->
      <div class="search-container">
        <form action="beritaguru.php" method="GET">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari berita">
          </div>
          <button type="submit" class="btn-cari">Cari</button>
          <a href="tambahberita.php" class="btn-tambah">+</a>
        </form>
      </div>

      <!-- Filter -->
      <div class="filter-buttons">
        <button>Kegiatan</button>
        <button>Lomba</button>
        <button>Prestasi</button>
        <button>Ekstrakurikuler</button>
      </div>

      <!-- Berita -->
      <h2>Berita terbaru</h2>
      <div class="berita-grid">
        <!-- Ulangi div ini untuk menambahkan berita -->
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
        <div class="berita-card"><div class="image"></div></div>
      </div>
    </main>
  </div>

</body>
</html>
