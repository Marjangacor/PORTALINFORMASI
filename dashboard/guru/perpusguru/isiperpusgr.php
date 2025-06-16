<?php
include "../../../koneksi/koneksi.php";
$id = $_GET['ID_BUKU'];
$result = mysqli_query($conn, "SELECT * FROM perpustakaan WHERE ID_BUKU = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($data['judul']) ?></title>
  <link rel="stylesheet" href="isiperpusgr.css"> 
</head>
<body>
  <nav>
  <a href="perpusgr.php" class="kembali"> kembali</a>
  
 </nav>

  <!-- Judul Buku -->
  <h2><?= htmlspecialchars($data['judul']) ?></h2>

  <!-- Gambar Buku -->
  <div class="thumbnail" style="background-image: url('fotobuku/<?= htmlspecialchars($data['gambar']) ?>');"></div>

  <!-- Blurb -->
  <p class="isi-berita"><?= nl2br(htmlspecialchars($data['blurb'])) ?></p>

  <!-- Jika ingin menampilkan pengarang/tanggal: -->
  <p class="pengarang">Pengarang: <?= htmlspecialchars($data['pengarang']) ?></p> 
  <p class="tanggal">Diterbitkan: <?= htmlspecialchars($data['tanggal']) ?></p>


</body>
</html>
