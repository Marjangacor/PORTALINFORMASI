<?php
include '../../koneksi/koneksi.php';

// =================== PROSES SAAT SUBMIT ===================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_pinjaman'], $_POST['jangka_waktu'], $_POST['id_buku'])) {
        $id_pinjaman = (int) $_POST['id_pinjaman'];
        $jangka_waktu = $_POST['jangka_waktu'];
        $id_buku = (int) $_POST['id_buku'];

        // Update jangka waktu peminjaman
        $updatePinjaman = mysqli_query($conn, "
            UPDATE pinjaman 
            SET jangka_waktu = '$jangka_waktu' 
            WHERE ID_pinjaman = $id_pinjaman
        ");

        // Ubah status buku menjadi 'Tiada'
        $updateBuku = mysqli_query($conn, "
            UPDATE perpustakaan 
            SET status = 'Tiada' 
            WHERE ID_BUKU = $id_buku
        ");

        if ($updatePinjaman && $updateBuku) {
            echo "<script>alert('Peminjaman berhasil dikonfirmasi.'); window.location.href='verifikasi.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal mengonfirmasi peminjaman.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
        exit;
    }
}

// =================== AMBIL DATA PEMINJAMAN UNTUK FORM ===================
if (!isset($_GET['id'])) {
    echo "<script>alert('ID peminjaman tidak ditemukan'); window.location.href='verifikasi.php';</script>";
    exit;
}

$id_pinjaman = (int) $_GET['id'];

$query = "
    SELECT p.ID_pinjaman, p.tanggal, u.nama AS nama_peminjam, b.judul, b.ID_BUKU 
    FROM pinjaman p 
    JOIN users u ON p.ID_USERS = u.ID_USERS 
    JOIN perpustakaan b ON p.ID_BUKU = b.ID_BUKU 
    WHERE p.ID_pinjaman = $id_pinjaman
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data peminjaman tidak ditemukan'); window.location.href='verifikasi.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Konfirmasi Peminjaman</title>
  <link rel="stylesheet" href="kon.css" />
</head>
<body>
  <div class="overlay"></div>
  <div class="login-box">
    <h1>Konfirmasi Peminjaman</h1>
    <form method="POST">
      <input type="hidden" name="id_pinjaman" value="<?= $data['ID_pinjaman'] ?>" />
      <input type="hidden" name="id_buku" value="<?= $data['ID_BUKU'] ?>" />

      <p><strong>Nama Peminjam:</strong> <?= htmlspecialchars($data['nama_peminjam']) ?></p>
      <p><strong>Judul Buku:</strong> <?= htmlspecialchars($data['judul']) ?></p>
      <p><strong>Tanggal Pinjam:</strong> <?= htmlspecialchars($data['tanggal']) ?></p>

      <div class="waktu">
      <label for="jangka_waktu">Pilih Tanggal Pengembalian:</label>
      <input type="date" name="jangka_waktu" required />
      </div>
      
      <button type="submit">Konfirmasi</button>
    </form>
  </div>
</body>
</html>
