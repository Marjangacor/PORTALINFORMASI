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

$query = "
  SELECT 
  p.ID_pinjaman,
  p.tanggal,
  p.jangka_waktu,
  u.nama AS nama_peminjam,
  b.judul,
  b.pengarang,
  b.kategori,
  b.status
  FROM pinjaman p
  JOIN users u ON p.ID_USERS = u.ID_USERS
  JOIN perpustakaan b ON p.ID_BUKU = b.ID_BUKU
  $whereClause
  ORDER BY p.tanggal DESC
";


$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telusuri Buku</title>
  <link rel="stylesheet" href="verifikasih.css">
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
        <a href="../data_perpus/perpusadmin.php">Perpustakaan</a>
        <a href="verifikasi.php" class="active">Verifikasi</a>
        <a href="../../landing_page/index.php">Kembali</a>
      </nav>
    </aside>


    <!-- Main Content -->
    <main class="main-content">
      <h1>Verifikasi</h1>
      <hr class="line">

      <!-- Search -->
      <div class="search-container">
        <form action="verifikasi.php" method="GET">
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari buku" value="<?= htmlspecialchars($q) ?>">
          </div>
          <button type="submit" class="btn-cari">Cari</button>

        </form>
      </div>

      <!-- Filter -->
      <!-- Filter -->
      <div class="filter-buttons">
        <a href="verifikasi.php?kategori=Biografi&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Biografi' ? 'active-filter' : '' ?>">Biografi</button>
        </a>
        <a href="verifikasi.php?kategori=Panduan&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Panduan' ? 'active-filter' : '' ?>">Panduan</button>
        </a>
        <a href="verifikasi.php?kategori=Motivasi&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Motivasi' ? 'active-filter' : '' ?>">Motivasi</button>
        </a>
        <a href="verifikasi.php?kategori=Sejarah&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Sejarah' ? 'active-filter' : '' ?>">Sejarah</button>
        </a>
      </div>

      <div class="filter-buttons2">
        <a href="verifikasi.php?kategori=Religi&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Religi' ? 'active-filter' : '' ?>">Religi</button>
        </a>
        <a href="verifikasi.php?kategori=Fiksi&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Fiksi' ? 'active-filter' : '' ?>">Fiksi</button>
        </a>
        <a href="verifikasi.php?kategori=Non-Fiksi&q=<?= urlencode($q) ?>">
          <button class="<?= $kategori === 'Non-Fiksi' ? 'active-filter' : '' ?>">Non-Fiksi</button>
        </a>
        <a href="verifikasi.php">
          <button class="<?= empty($kategori) ? 'active-filter' : '' ?>">Semua</button>
        </a>
      </div>


      <div class="all">
        <div class="container1">
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="user-card">
              <p><strong>Nama Peminjam</strong> : <?= htmlspecialchars($row['nama_peminjam']) ?></p>
              <p><strong>Judul Buku</strong> : <?= htmlspecialchars($row['judul']) ?></p>
              <p><strong>Pengarang</strong> : <?= htmlspecialchars($row['pengarang']) ?></p>
              <p><strong>Kategori</strong> : <?= htmlspecialchars($row['kategori']) ?></p>
              <p><strong>Status</strong> : <?= htmlspecialchars($row['status']) ?></p>
              <p><strong>Tanggal Pinjam</strong> : <?= htmlspecialchars($row['tanggal']) ?></p>
              <p><strong>Jangka Waktu</strong> : <?= $row['jangka_waktu'] ? htmlspecialchars($row['jangka_waktu']) : '<em>Belum ditentukan</em>' ?></p>


              <div class="hped">
                <a href="konfimasi.php?id=<?= $row['ID_pinjaman'] ?>" class="edit">
                  <i class="fas fa-check"> </i>
                </a>

                <a href="hapus_peminjaman.php?id=<?= $row['ID_pinjaman'] ?>" class="hapus"
                  onclick="return confirm('Yakin ingin membatalkan peminjaman?')"><i class="fas fa-trash"></i></a>
              </div>
            </div>
          <?php endwhile; ?>

        </div>
      </div>