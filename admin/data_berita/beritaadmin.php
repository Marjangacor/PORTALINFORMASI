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
    $where[] = "(judul LIKE '%$q%' OR subjudul LIKE '%$q%')";
}

$whereClause = '';
if (count($where) > 0) {
    $whereClause = "WHERE " . implode(" AND ", $where);
}

$query = "SELECT * FROM berita $whereClause ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telusuri Berita</title>
    <link rel="stylesheet" href="beritaad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="../../foto/logo.png" alt="Logo" class="logo">
            <nav>
                <a href="../data_users/usersadmin.php">Users</a>
                <a href="beritaadmin.php" class="active">Berita</a>
                <a href="../data_perpus/perpusadmin.php">Perpustakaan</a>
                <a href="../verifikasi/verifikasi.php">Verifikasi</a>
                <a href="../../landing_page/index.php">Kembali</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Telusuri berita</h1>
            <hr class="line">

            <!-- Search -->
            <div class="search-container">
                <form action="beritaadmin.php" method="GET">
                    <input type="hidden" name="kategori"
                        value="<?= isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori']) : '' ?>">
                    <div class="search-bar">
                        <span class="search-icon">🔍</span>
                        <input type="text" name="q" placeholder="Cari berita"
                            value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                    </div>
                    <button type="submit" class="btn-cari">Cari</button>
                    <a href="tambahberitaad.php" class="btn-tambah">+</a>
                </form>
            </div>

            <!-- Filter -->
            <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
            <div class="filter-buttons">
                <a href="beritaadmin.php?kategori=Kegiatan&q=<?= urlencode($q) ?>"><button>Kegiatan</button></a>
                <a href="beritaadmin.php?kategori=Lomba&q=<?= urlencode($q) ?>"><button>Lomba</button></a>
                <a href="beritaadmin.php?kategori=Prestasi&q=<?= urlencode($q) ?>"><button>Prestasi</button></a>
                <a
                    href="beritaadmin.php?kategori=Ekstrakurikuler&q=<?= urlencode($q) ?>"><button>Ekstrakurikuler</button></a>
                <a href="beritaadmin.php"><button>Semua</button></a>
            </div>


            <!-- Berita -->
            <h2>Berita terbaru</h2>
            <div class="berita-grid">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="berita-card">
                        <a href="isiberitaad.php?ID_BERITA=<?= $row['ID_BERITA'] ?>">
                            <div class="berita-gambar">
                                <img src="../../dashboard/guru/berita/fotoberita/<?= $row['gambar'] ?>"
                                    alt="<?= $row['judul'] ?>">
                            </div>
                            <div class="berita-info">
                                <h3><?= $row['judul'] ?></h3>
                            </div>
                            <div class="hped">
                                <a href="editberitaad.php?id=<?= $row['ID_BERITA'] ?>" class="edit"> <i
                                        class="fas fa-pen-to-square fa-lg"></i></a>
                                <a href="hapusberita.php?id=<?= $row['ID_BERITA'] ?>" class="hapus"
                                    onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash fa-lg"></i></a>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>



</body>

</html>