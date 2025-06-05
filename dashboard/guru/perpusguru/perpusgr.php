<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telusuri buku</title>
  <link rel="stylesheet" href="perpusgr.css">
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="../../../foto/logo.png" alt="Logo" class="logo">
      <nav>
        <a href="../beranda/berandaguru.php">Beranda</a>
        <a href="../berita/beritaguru.php" >Berita</a>
        <a href="perpusgr.php" class="active">Perpustakaan</a>
        <a href="#">Kembali</a>
      </nav>
    </aside>

    <!-- Main Content --> 
    <main class="main-content">
      <h1>Telusuri Buku</h1>
      <hr class="line">

      <!-- Search -->
      <div class="search-container">
        <form action="perpusgr.php" method="GET">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari buku">
          </div>
          <button type="submit" class="btn-cari">Cari</button>
          <a href="tambahbuku.php" class="btn-tambah">+</a>
        </form>
      </div>


      <!-- Filter -->
      <div class="filter-buttons">
        <button>Biografi</button>
        <button>Panduan</button>
        <button>Motivasi</button>
        <button>Sejarah</button>
      </div>

      <div class="filter-buttons2">
        <button>Religi</button>
        <button>Fiksi</button>
        <button>Non-Fiksi</button>
      </div>

      <!-- Berita -->
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
