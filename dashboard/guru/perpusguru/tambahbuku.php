<?php
include '../../../koneksi/koneksi.php';

if (isset($_POST['submit'])) {
    $judul      = $_POST['Judul'];
    $Blurb      = $_POST['Blurb'];
    $Pengarang  = $_POST['Pengarang'];
    $tanggal    = $_POST['tanggal'];
    $kategori   = $_POST['kategori'];
    

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "fotobuku/";

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    move_uploaded_file($tmp, $folder . $gambar);

    // Query insert
    $status = 'Ada'; // Set default status buku 
   $query = "INSERT INTO perpustakaan (judul, blurb, tanggal, gambar, kategori, pengarang, status)
          VALUES ('$judul', '$Blurb', '$tanggal', '$gambar', '$kategori', '$Pengarang', '$status')";


    if (mysqli_query($conn, $query)) {
        header("Location: perpusgr.php"); // Redirect jika berhasil
        exit();
    } else {
        header("Location: tambahbuku.php?error=1"); // Redirect jika gagal
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Buku</title>
  <link rel="stylesheet" href="tamabahbk.css">
</head>
<body>
  <div class="overlay"></div> 
  <div class="tambah-box">
    <h1>Tambah Buku</h1>

    <form action="" method="POST" enctype="multipart/form-data">
      <input type="text" placeholder="Judul" name="Judul" for="Judul" required>
      <input type="text" placeholder="Blurb" name="Blurb" for="Blurb" required>
      <input type="text" placeholder="Pengarang" name="Pengarang" for="Pengarang" required>
      <input type="file" name="gambar" accept="image/*" for="Gambar" required>
      <input type="date" name="tanggal" for="tanggal"for="Tanggal" required>
       <select name="kategori" >
            <option value="Biografi">Biografi</option>
            <option value="Panduan">Panduan</option>
            <option value="Motivasi">Motivasi</option>
            <option value="Sejarah">Sejarah</option>
            <option value="Religi">Religi</option>
            <option value="Fiksi">Fiksi</option>
            <option value="Non-Fiksi">Non-Fiksi</option>
        </select>

      <div class="tombol">
        <a href="perpusgr.php"><button type="button">Kembali</button></a>
        <button type="submit" name="submit">Tambah</button>
      </div>
    </form>
  </div>
</body>
</html>

