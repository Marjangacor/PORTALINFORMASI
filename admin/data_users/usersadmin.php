<?php
include '../../koneksi/koneksi.php';
session_start();

$query = "SELECT * FROM users"; // sesuaikan nama tabel jika berbeda
$result = mysqli_query($conn, $query);


if (!isset($_SESSION['users']) || $_SESSION['users']['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Telusuri Berita</title>
  <link rel="stylesheet" href="users.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</head>
<body>

<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="../../foto/logo.png" alt="Logo" class="logo"/>
    <nav>
      <a href="usersadmin.php" class="active">Users</a>
      <a href="../data_berita/beritaadmin.php">Berita</a>
      <a href="../data_perpus/perpusadmin.php">Perpustakaan</a>
      <a href="../verifikasi/verifikasi.php">Verifikasi</a>
      <a href="../../landing_page/index.php">Kembali</a>
    </nav>
  </aside>

<div classv="all">
  <div class="atas">
  <h1>Data Users</h1>
  <a href="tambahuser.php"><button class="tambah-btn">+ Tambah</button></a>
  </div>
  <div class="container1">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <div class="user-card">
        <p><strong>Nama</strong> : <?= htmlspecialchars($row['nama']) ?></p>
        <p><strong>Email</strong> : <?= htmlspecialchars($row['email']) ?></p>
        <p><strong>Role</strong> : <?= htmlspecialchars($row['role']) ?></p>
        <div class="hped">
          <a href="edituser.php?id=<?= $row['ID_USERS'] ?>" class="edit"> <i class="fas fa-pen-to-square"></i></a>
  
          <a href="hapususers.php?id=<?= $row['ID_USERS'] ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
        </div>
   </div>
    <?php endwhile; ?>
</div>



</body>
</html>
