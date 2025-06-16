<?php
include '../../koneksi/koneksi.php';
session_start();

// Pastikan ada parameter ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location.href='usersadmin.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM users WHERE ID_USERS = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); window.location.href='usersadmin.php';</script>";
    exit;
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Jika password tidak kosong, update dengan password baru
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET nama = ?, email = ?, password = ?, role = ? WHERE ID_USERS = ?");
        $update->bind_param("ssssi", $nama, $email, $password, $role, $id);
    } else {
        $update = $conn->prepare("UPDATE users SET nama = ?, email = ?, role = ? WHERE id = ?");
        $update->bind_param("sssi", $nama, $email, $role, $id);
    }

    if ($update->execute()) {
        echo "<script>alert('Data berhasil diupdate'); window.location.href='usersadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit User</title>
  <link rel="stylesheet" href="edituser.css" />
</head>
<body>
  <div class="overlay"></div>
  <div class="login-box">
    <h1>Edit User</h1>
    <form method="POST">
      <input type="text" placeholder="Username" name="username" value="<?= htmlspecialchars($user['nama']) ?>" required />
      <input type="email" placeholder="Email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
      <input type="password" placeholder="Password (kosongkan jika tidak diubah)" name="password" />
      <select name="role" required>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="guru" <?= $user['role'] == 'guru' ? 'selected' : '' ?>>Guru</option>
        <option value="siswa" <?= $user['role'] == 'siswa' ? 'selected' : '' ?>>Siswa</option>
      </select>
      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
