<?php
include "../../koneksi/koneksi.php";

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$q = isset($_GET['q']) ? $_GET['q'] : '';

$where = [];

if (!empty($kategori)) {
  $kategori = mysqli_real_escape_string($conn, $kategori);
  $where[] = "kategori = '$kategori'";
}
if (!empty($q)) {
  $q = mysqli_real_escape_string($conn, $q);
  $where[] = "(judul LIKE '%$q%' OR pengarang LIKE '%$q%')";
}

$whereClause = '';
if (count($where) > 0) {
  $whereClause = "WHERE " . implode(" AND ", $where);
}

$query = "SELECT * FROM perpustakaan $whereClause ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telusuri Buku</title>
  <link rel="stylesheet" href="perpusad.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="../../foto/logo.png" alt="Logo" class="logo">
      <nav>
        <a href="../data_users/usersadmin.php">Users</a>
        <a href="../data_berita/beritaadmin.php">Berita</a>
        <a href="perpusadmin.php" class="active">Perpustakaan</a>
        <a href="../verifikasi/verifikasi.php">Verifikasi</a>
        <a href="../../landing_page/index.php">Kembali</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Telusuri Buku</h1>
      <hr class="line">

      <!-- Search -->
      <div class="search-container">
        <form action="perpusadmin.php" method="GET">
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari buku" value="<?= htmlspecialchars($q) ?>">
          </div>
          <button type="submit" class="btn-cari">Cari</button>
          <a href="tambah.php" class="btn-tambah">+</a>
        </form>
      </div>

      <!-- Filter -->
      <div class="filter-buttons">
        <a href="perpusadmin.php?kategori=Biografi&q=<?= urlencode($q) ?>"><button>Biografi</button></a>
        <a href="perpusadmin.php?kategori=Panduan&q=<?= urlencode($q) ?>"><button>Panduan</button></a>
        <a href="perpusadmin.php?kategori=Motivasi&q=<?= urlencode($q) ?>"><button>Motivasi</button></a>
        <a href="perpusadmin.php?kategori=Sejarah&q=<?= urlencode($q) ?>"><button>Sejarah</button></a>
      </div>
      <div class="filter-buttons2">
        <a href="perpusadmin.php?kategori=Religi&q=<?= urlencode($q) ?>"><button>Religi</button></a>
        <a href="perpusadmin.php?kategori=Fiksi&q=<?= urlencode($q) ?>"><button>Fiksi</button></a>
        <a href="perpusadmin.php?kategori=Non-Fiksi&q=<?= urlencode($q) ?>"><button>Non-Fiksi</button></a>
        <a href="perpusadmin.php"><button>Semua</button></a>
      </div> 

      <!-- Buku -->
      <h2>Daftar Buku</h2>
      <div class="berita-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="berita-card">
            <a href="isiperpus.php?ID_BUKU=<?= $row['ID_BUKU'] ?>">
              <div class="berita-gambar">
                <img src="../../dashboard/guru/perpusguru/fotobuku/<?= $row['gambar'] ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
              </div>
              <div class="berita-info">
                <h3><?= htmlspecialchars($row['judul']) ?></h3>
                <p><?= htmlspecialchars($row['pengarang']) ?></p>
              </div>
               <div class="hped">
                 <a href="editperpus.php?id=<?= $row['ID_BUKU'] ?>" class="edit"> <i
                         class="fas fa-pen-to-square fa-lg"></i></a>
                 <a href="hapus.php?id=<?= $row['ID_BUKU'] ?>" class="hapus"
                     onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash fa-lg"></i></a>
               </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    </main>
  </div>

</body>
</html>
