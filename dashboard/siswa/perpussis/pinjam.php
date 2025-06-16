<?php
session_start();
include "../../../koneksi/koneksi.php";


$id_users = $_SESSION['ID_USERS'];
$id_buku = $_POST['ID_BUKU'];
$tanggal = date('Y-m-d');

// Insert ke tabel peminjaman
$stmt = $conn->prepare("INSERT INTO pinjaman (tanggal, ID_USERS, ID_BUKU) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $tanggal, $id_users, $id_buku);

if ($stmt->execute()) {
    echo "<script>alert('Berhasil mengajukan peminjaman. Menunggu konfirmasi admin.'); window.location.href='perpussiswa.php';</script>";
} else {
    echo "<script>alert('Gagal melakukan peminjaman.'); window.history.back();</script>";
}
?>
