<?php
include '../../koneksi/koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID buku tidak ditemukan'); window.location.href='perpusgr.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data buku berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM perpustakaan WHERE ID_BUKU = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$buku = $result->fetch_assoc();

if (!$buku) {
    echo "<script>alert('Buku tidak ditemukan'); window.location.href='perpusadmin.php';</script>";
    exit;
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $blurb = $_POST['blurb'];
    $pengarang = $_POST['pengarang'];
    $tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : $buku['tanggal'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];

    // Gambar
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_name = basename($_FILES['gambar']['name']);
        $target_dir = "../../dashboard/guru/perpusguru/fotobuku/";
        $target_file = $target_dir . $gambar_name;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
    } else {
        $gambar_name = $buku['gambar'];
    }

    $update = $conn->prepare("UPDATE perpustakaan SET judul = ?, blurb = ?, pengarang = ?, gambar = ?, tanggal = ?, kategori = ?, status = ? WHERE ID_BUKU = ?");
    $update->bind_param("sssssssi", $judul, $blurb, $pengarang, $gambar_name, $tanggal, $kategori, $status, $id);

    if ($update->execute()) {
        echo "<script>alert('Buku berhasil diperbarui'); window.location.href='perpusadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui buku');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Buku</title>
  <link rel="stylesheet" href="editperpus.css" />
</head>
<body>
  <div class="overlay"></div>
  <div class="login-box">
    <h1>Edit Buku</h1>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="judul" placeholder="Judul Buku" value="<?= htmlspecialchars($buku['judul']) ?>" required />
      <input type="text" name="blurb" placeholder="Blurb (Ringkasan)" value="<?= htmlspecialchars($buku['blurb']) ?>" required />
      <input type="text" name="pengarang" placeholder="Pengarang" value="<?= htmlspecialchars($buku['pengarang']) ?>" required />

      <label>Gambar Saat Ini: <?= $buku['gambar'] ?></label>
      <input type="file" name="gambar" accept="image/*" />

      <input type="date" name="tanggal" value="<?= $buku['tanggal'] ?>" />

      <select name="kategori" required>
        <?php
        $kategoriList = ['biografi', 'panduan', 'motivasi', 'sejarah', 'religi', 'fiksi', 'non-fiksi'];
        foreach ($kategoriList as $kat) {
            $selected = ($buku['kategori'] == $kat) ? 'selected' : '';
            echo "<option value='$kat' $selected>$kat</option>";
        }
        ?>
      </select>

      <select name="status" required>
        <option value="ada" <?= $buku['status'] == 'ada' ? 'selected' : '' ?>>Ada</option>
        <option value="tiada" <?= $buku['status'] == 'tiada' ? 'selected' : '' ?>>Tiada</option>
      </select>

      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
