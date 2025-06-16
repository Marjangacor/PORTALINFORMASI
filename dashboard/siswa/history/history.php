<?php
include "../../../koneksi/koneksi.php";
session_start();

// Cek apakah user adalah siswa
// if (!isset($_SESSION['ID_USERS']) || $_SESSION['role'] !== 'siswa') {
//   echo "<script>alert('Akses ditolak. Hanya untuk siswa.'); window.location.href='../../../login/login.php';</script>";
//   exit;
// }

$id_siswa = $_SESSION['ID_USERS'];

// Filter dan pencarian
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$q = isset($_GET['q']) ? $_GET['q'] : '';

$where = ["p.ID_USERS = $id_siswa"]; // hanya pinjaman milik siswa

if (!empty($kategori)) {
  $kategori = mysqli_real_escape_string($conn, $kategori);
  $where[] = "b.kategori = '$kategori'";
}
if (!empty($q)) {
  $q = mysqli_real_escape_string($conn, $q);
  $where[] = "(b.judul LIKE '%$q%' OR b.pengarang LIKE '%$q%')";
}

$whereClause = "WHERE " . implode(" AND ", $where);

// Ambil data peminjaman
$query = "
  SELECT 
    p.tanggal,
    p.jangka_waktu,
    b.judul,
    b.pengarang,
    b.kategori,
    b.status
  FROM pinjaman p
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
  <title>Riwayat Peminjaman</title>
  <link rel="stylesheet" href="his.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="../../../foto/logo.png" alt="Logo" class="logo">
      <nav>
         <a href="../berandasis/berandasiswa.php">Beranda</a>
        <a href="../beritasis/beritasiswa.php">Berita</a>
        <a href="../perpussis/perpussiswa.php" >Perpustakaan</a>
        <a href="history.php"class="active">History</a>
        <a href="../../../landing_page/index.php">Kembali</a>
    
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Riwayat Peminjaman</h1>
      <hr class="line">

      <!-- Search -->
      <div class="search-container">
        <form action="riwayat.php" method="GET">
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Cari buku" value="<?= htmlspecialchars($q) ?>">
          </div>
          <button type="submit" class="btn-cari">Cari</button>
        </form>
      </div>

      <!-- Filter -->
      <div class="filter-buttons">
        <a href="history.php?kategori=Biografi&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Biografi' ? 'active-filter' : '' ?>">Biografi</button></a>
        <a href="history.php?kategori=Panduan&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Panduan' ? 'active-filter' : '' ?>">Panduan</button></a>
        <a href="history.php?kategori=Motivasi&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Motivasi' ? 'active-filter' : '' ?>">Motivasi</button></a>
        <a href="history.php?kategori=Sejarah&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Sejarah' ? 'active-filter' : '' ?>">Sejarah</button></a>
      </div>

      <div class="filter-buttons2">
        <a href="history.php?kategori=Religi&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Religi' ? 'active-filter' : '' ?>">Religi</button></a>
        <a href="history.php?kategori=Fiksi&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Fiksi' ? 'active-filter' : '' ?>">Fiksi</button></a>
        <a href="history.php?kategori=Non-Fiksi&q=<?= urlencode($q) ?>"><button class="<?= $kategori === 'Non-Fiksi' ? 'active-filter' : '' ?>">Non-Fiksi</button></a>
        <a href="history.php"><button class="<?= empty($kategori) ? 'active-filter' : '' ?>">Semua</button></a>
      </div>

      <!-- History Cards -->
      <div class="all">
        <div class="container1">
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <div class="user-card">
                <p><strong>Judul Buku</strong> : <?= htmlspecialchars($row['judul']) ?></p>
                <p><strong>Pengarang</strong> : <?= htmlspecialchars($row['pengarang']) ?></p>
                <p><strong>Kategori</strong> : <?= htmlspecialchars($row['kategori']) ?></p>
                <p><strong>Status</strong> : <?= htmlspecialchars($row['status']) ?></p>
                <p><strong>Tanggal Pinjam</strong> : <?= htmlspecialchars($row['tanggal']) ?></p>
                <p><strong>Jangka Waktu</strong> : <?= $row['jangka_waktu'] ? htmlspecialchars($row['jangka_waktu']) : '<em>Belum dikonfirmasi</em>' ?></p>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>Tidak ada riwayat peminjaman.</p>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
