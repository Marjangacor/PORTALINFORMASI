<?php
session_start();
include "../../../koneksi/koneksi.php";


// Ambil ID berita dari URL, dengan validasi
if (!isset($_GET['ID_BERITA'])) {
    die("ID Berita tidak ditemukan.");
}

$id = (int) $_GET['ID_BERITA'];

// Ambil data berita
$result = mysqli_query($conn, "SELECT * FROM berita WHERE ID_BERITA = $id") or die("Query error: " . mysqli_error($conn));
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Berita tidak ditemukan.");
}

// Proses kirim komentar
if (isset($_POST['kirim'])) {
    $isi = mysqli_real_escape_string($conn, $_POST['isi_coment']);
    $id_user = $_SESSION['user']['ID_USERS'];
    $tanggal = date("Y-m-d");

    mysqli_query($conn, "INSERT INTO coment (isi_coment, tanggal, ID_USERS, ID_BERITA) 
        VALUES ('$isi', '$tanggal', '$id_user', '$id')") 
        or die("Gagal kirim komentar: " . mysqli_error($conn));
}

// Proses hapus komentar
if (isset($_POST['hapus'])) { 
    $id_coment = (int) $_POST['id_coment'];
    $id_user = $_SESSION['user']['ID_USERS'];

    mysqli_query($conn, "DELETE FROM coment WHERE ID_Coment = $id_coment AND ID_USERS = $id_user") 
        or die("Gagal hapus komentar: " . mysqli_error($conn));
}

// Ambil semua komentar
$komentar = mysqli_query($conn, "SELECT k.*, u.nama 
    FROM coment k 
    JOIN users u ON k.ID_USERS = u.ID_USERS 
    WHERE k.ID_BERITA = $id 
    ORDER BY k.tanggal DESC") 
    or die("Gagal ambil komentar: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berita + Chat</title>
  <link rel="stylesheet" href="isibrt.css">
</head>
<body>

<a href="beritasiswa.php" class="kembali">&lt; kembali</a>

<!-- Konten Berita -->
<h2><?= htmlspecialchars($data['judul']) ?></h2>
<div class="thumbnail" style="background-image: url('../../guru/berita/fotoberita/<?= htmlspecialchars($data['gambar']) ?>');"></div>
<p class="isi-berita"><?= nl2br(htmlspecialchars($data['subjudul'])) ?></p>
<p class="isi-berita"><?= nl2br(htmlspecialchars($data['isi'])) ?></p>

<!-- Toggle dan Icon Chat -->
<input type="checkbox" id="chat-toggle" class="chat-toggle" hidden>
<label for="chat-toggle" class="chat-icon">💬</label>

<!-- Kotak Chat -->
<div class="chat-popup">
  <div class="chat-content">
    <?php while ($k = mysqli_fetch_assoc($komentar)) : ?>
      <div class="chat-message">
        <span class="user <?= strtolower($k['nama']) ?>"><?= htmlspecialchars($k['nama']) ?></span>
        <span class="date"><?= date("d/m/Y", strtotime($k['tanggal'])) ?></span><br>
        <?= nl2br(htmlspecialchars($k['isi_coment'])) ?>
        <?php if ($_SESSION['user']['ID_USERS'] == $k['ID_USERS']) : ?>
          <form method="post" style="margin-top:5px;">
            <input type="hidden" name="id_coment" value="<?= $k['ID_Coment'] ?>">
            <button type="submit" name="hapus" style="color:red; background:none; border:none; cursor:pointer;">Hapus</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Form Kirim Komentar -->
  <form class="chat-input" method="post">
    <input type="text" name="isi_coment" placeholder="Ketik pesan..." required>
    <button type="submit" name="kirim">➤</button>
  </form>
</div>

</body>
</html>
