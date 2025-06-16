<?php
include '../koneksi/koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['ID_USERS'] = $user['ID_USERS'];
            $_SESSION['role'] = $data['role']; 


            // Redirect berdasarkan role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin/data_users/usersadmin.php");
                    break;
                case 'guru':
                    header("Location: ../dashboard/guru/beranda/berandaguru.php");
                    break;
                case 'siswa':
                    header("Location: ../dashboard/siswa/berandasis/berandasiswa.php");
                    break;
                default:
                    echo "Role tidak dikenali!";
            }
            exit;
        } else {
            echo "<script>alert('Password salah')</script>";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="overlay"></div> 
  <div class="login-box">
    <h1>Login</h1>
    <form method="POST" action="">
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" required />
      <button type="submit">Login</button>
      <p class="kata">Belum punya akun? <a href="../Daftar/daftar.php">Daftar di sini</a></p>
    </form>
  </div>
</body>
</html>
