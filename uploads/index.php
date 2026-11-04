<?php
session_start();
// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("Location: dashboard.php");
    exit();
}

// Cookie "Remember Me" (materi 9.2): isi username otomatis
$cookie_user = "";
if (isset($_COOKIE['user_cookie'])) {
    $cookie_user = $_COOKIE['user_cookie'];
}
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Mini Digital Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container" style="max-width:400px; margin-top:80px">
 <div class="card shadow-sm"><div class="card-body p-4">
  <h4 class="text-center mb-3">Mini Digital Library</h4>

  <?php if ($pesan == "gagal") { ?>
    <div class="alert alert-danger">Username atau Password salah!</div>
  <?php } elseif ($pesan == "logout") { ?>
    <div class="alert alert-success">Anda berhasil logout.</div>
  <?php } elseif ($pesan == "belum_login") { ?>
    <div class="alert alert-warning">Silakan login terlebih dahulu.</div>
  <?php } ?>

  <form action="proses_login.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" class="form-control mb-2"
           value="<?php echo htmlspecialchars($cookie_user); ?>" required>
    <label>Password:</label>
    <input type="password" name="password" class="form-control mb-2" required>
    <div class="form-check mb-3">
      <input type="checkbox" name="remember" id="remember" class="form-check-input"
             <?php if ($cookie_user != "") { echo "checked"; } ?>>
      <label for="remember" class="form-check-label">Remember Me</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
  </form>
 </div></div>
</div>
</body>
</html>