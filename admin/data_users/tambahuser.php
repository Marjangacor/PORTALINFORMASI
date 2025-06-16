<?php
include '../../koneksi/koneksi.php'; // Sesuaikan path jika perlu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    // Cek apakah email sudah digunakan
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $password, $role);
        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil'); window.location.href='usersadmin.php';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar. Coba lagi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar</title>
  <link rel="stylesheet" href="tambahus.css" />
</head>
<body>
  <div class="overlay"></div> 
  <div class="login-box">
    <h1>Daftar</h1>
    <form method="POST" action="">
      <input type="text" placeholder="Username" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" required />
      <select name="role" required>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
      </select>
      <button type="submit">Daftar</button>
    </form>
  </div>
</body>
</html>
