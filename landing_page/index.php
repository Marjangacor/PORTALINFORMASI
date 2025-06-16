<?php
session_start(); // Wajib ada sebelum output HTML
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Informasi</title>
  <link rel="stylesheet" href="indek.css">
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">
      <img class="logo" src="../foto/logo.png" alt="Logo" />
    </div>
    <nav class="nav-links">
      <a href="index.php">HOME</a>
      <a href="about.php">ABOUT</a>

      <?php if (isset($_SESSION['user'])): ?>
        <?php
          $role = $_SESSION['user']['role'];
          switch ($role) {
        case 'admin':
        $link = "../admin/data_users/usersadmin.php";
        break;
        case 'guru':
        $link = "../dashboard/guru/beranda/berandaguru.php";
        break;
       case 'siswa':
        $link = "../dashboard/siswa/berandasis/berandasiswa.php";
        break;
       default:
        $link = "../login/login.php";
}

        ?>
        <a href="<?= $link ?>">DASHBOARD</a>
      <?php else: ?>
        <a href="../login/login.php">DASHBOARD</a>
      <?php endif; ?>

      <a href="../login/login.php">LOGIN</a>
    </nav>
  </header>


  <!-- Hero Section 1 -->
  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-gradient"></div>
      <h1>Selamat datang di Portal Informasi</h1>
      <p>Temukan Berita Terbaru</p>
    </div>
  </section>

  <!-- Hero Section 2 (teks + tombol sejajar) -->
  <section class="hero2">
    <div class="herodiv2down">
      <div class="herodiv2">
        <div class="textdiv2">
          <h1>Satu Portal, Sejuta Informasi</h1>
          <p>Jelajahi berita, wawasan, dan pengetahuan terkini dalam genggamanmu.</p>
        </div>
        <div class="btn-wrapper">
          <a href="../login/login.php" class="btndiv2">Mulai</a>
        </div>
      </div>
    </div>
  </section>
 

</body>
</html>
