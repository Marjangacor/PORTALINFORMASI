<?php
include '../../koneksi/koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID berita tidak ditemukan'); window.location.href='beritaadmin.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data berita lama
$stmt = $conn->prepare("SELECT * FROM berita WHERE ID_BERITA = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$berita = $result->fetch_assoc();

if (!$berita) {
    echo "<script>alert('Berita tidak ditemukan'); window.location.href='beritaadmin.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $subjudul = $_POST['subjudul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : $berita['tanggal'];

    // Handle gambar jika diupload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_name = basename($_FILES['gambar']['name']);
        $target_dir = "fotoberita/";
        $target_file = $target_dir . $gambar_name;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
    } else {
        $gambar_name = $berita['gambar']; // pakai gambar lama
    }

    $update = $conn->prepare("UPDATE berita SET judul = ?, subjudul = ?, isi = ?, gambar = ?, tanggal = ?, kategori = ? WHERE ID_BERITA = ?");
    $update->bind_param("ssssssi", $judul, $subjudul, $isi, $gambar_name, $tanggal, $kategori, $id);

    if ($update->execute()) {
        echo "<script>alert('Berita berhasil diupdate'); window.location.href='beritaadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate berita');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Berita</title>
  <link rel="stylesheet" href="editad.css" />
</head>
<body>
  <div class="overlay"></div>
  <div class="login-box">
    <h1>Edit Berita</h1>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="judul" placeholder="Judul" value="<?= htmlspecialchars($berita['judul']) ?>" required />
      <input type="text" name="subjudul" placeholder="Subjudul" value="<?= htmlspecialchars($berita['subjudul']) ?>" required />
      <textarea name="isi" placeholder="Isi Berita" required><?= htmlspecialchars($berita['isi']) ?></textarea>
      
      <label>Gambar Saat Ini: <?= $berita['gambar'] ?></label>
      <input type="file" name="gambar" accept="image/*" />

      <input type="date" name="tanggal" value="<?= $berita['tanggal'] ?>" />

      <select name="kategori" required>
        <option value="kegiatan" <?= $berita['kategori'] == 'kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
        <option value="lomba" <?= $berita['kategori'] == 'lomba' ? 'selected' : '' ?>>Lomba</option>
        <option value="prestasi" <?= $berita['kategori'] == 'prestasi' ? 'selected' : '' ?>>Prestasi</option>
        <option value="ekstrakurikuler" <?= $berita['kategori'] == 'ekstrakurikuler' ? 'selected' : '' ?>>Ekstrakurikuler</option>
      </select>

      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
