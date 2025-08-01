<?php
include '../../koneksi/koneksi.php';

if (isset($_POST['submit'])) {
    $judul     = $_POST['Judul'];
    $subjudul  = $_POST['Subjudul'];
    $isi       = $_POST['isi'];
    $tanggal   = $_POST['tanggal'];
    $kategori  = $_POST['kategori']; // ✅ tambahkan ini

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "../../dashboard/guru/berita/fotoberita/";

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    move_uploaded_file($tmp, $folder . $gambar);

    // Query insert
    $query = "INSERT INTO berita (judul, subjudul, isi, gambar, tanggal, kategori)
              VALUES ('$judul', '$subjudul', '$isi', '$gambar', '$tanggal', '$kategori')";

    if (mysqli_query($conn, $query)) {
        header("Location: beritaadmin.php"); // Redirect jika berhasil
        exit();
    } else {
        header("Location: tambahberitaad.php?error=1"); // Redirect jika gagal
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Berita</title>
  <link rel="stylesheet" href="tambahad.css">
</head>
<body>
  <div class="overlay"></div> 
  <div class="tambah-box">
    <h1>Tambah Berita</h1>

    <form action="" method="POST" enctype="multipart/form-data">
      <input type="text" placeholder="Judul" name="Judul" for="Judul" required> 
      <input type="text" placeholder="Subjudul" name="Subjudul" for="Subjuudl" required>
      <textarea name="isi" rows="5" cols="40" placeholder="Isi" for="Isi" required></textarea>
      <input type="file" name="gambar" accept="image/*" for="Gambar" required>
      <input type="date" name="tanggal" for="tanggal"for="Tanggal" required>
      <select name="kategori" required>
           <option value="Kegiatan">Kegiatan</option>
           <option value="Lomba">Lomba</option>
           <option value="Prestasi">Prestasi</option>
           <option value="Ekstrakurikuler">Ekstrakurikuler</option>
      </select>

      <div class="tombol">
        <a href="beritaadmin.php"><button type="button">Kembali</button></a>
        <button type="submit" name="submit">Tambah</button>
      </div>
    </form>
  </div>
</body>
</html>

