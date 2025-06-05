<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar</title>
  <link rel="stylesheet" href="regis.css">
</head>
<body>
   <div class="overlay"></div> 
    <div class="login-box">
      <h1>Daftar</h1>
      <form>
        <input type="text" placeholder="Username" name="username" required>
        <input type="email" placeholder="Email" name="email" required>
        <input type="password" placeholder="Password" name="password" required>
        <select name="role" >
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select>
        <button type="submit">Daftar</button>
        <p class="kata">Sudah punya akun? <a href="../login/login.php">Login di sini</a></p>
      </form>
    </div>

</body>
</html>
 