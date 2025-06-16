<?php
include '../../../koneksi/koneksi.php'; // koneksi ke database
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Telusuri Berita</title>
  <link rel="stylesheet" href="berandasisw.css"/>
</head>
<body>

<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="../../../foto/logo.png" alt="Logo" class="logo"/>
    <nav>
      <a href="berandasiswa.php" class="active">Beranda</a>
      <a href="../beritasis/beritasiswa.php">Berita</a>
      <a href="../perpussis/perpussiswa.php">Perpustakaan</a>
      <a href="../history/history.php">History</a>
      <a href="../../landing_page/index.php">Kembali</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <h1>Selamat datang Siswa</h1>
    <p class="subjudul">Temukan Berita Terbaru</p>
    <hr class="line"/>

    <div class="kategori">
      <?php
      $kategori = ['Kegiatan', 'Lomba', 'Ekstrakurikuler','Prestasi'];
      foreach ($kategori as $kat) {
          echo "<h2>$kat</h2>";
          echo '<div class="card-container">';

          $stmt = $conn->prepare("SELECT ID_BERITA, judul, subjudul, gambar FROM berita WHERE kategori = ? ORDER BY tanggal DESC LIMIT 3");
          $stmt->bind_param("s", $kat);
          $stmt->execute();
          $result = $stmt->get_result();

          while ($row = $result->fetch_assoc()) {
              $id = $row['ID_BERITA'];
              $judul = htmlspecialchars($row['judul']);
              $subjudul = htmlspecialchars($row['subjudul']);
              $gambar = htmlspecialchars($row['gambar']);

              echo "
                <a href='../beritasis/isibrtsis.php?ID_BERITA=$id' class='card'>
                  <img src='../../guru/berita/fotoberita/$gambar' alt='$judul'/>
                  <div class='card-text'>
                    <h3>$judul</h3>
                  </div>
                </a>
              ";
          }

          echo '</div>';
      }
      ?>
    </div>
  </main>
</div>

</body>
</html>
