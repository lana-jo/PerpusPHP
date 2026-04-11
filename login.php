<?php

session_start();

// jika sudah login, alihkan ke halaman list
if (isset($_SESSION['user'])) {
	header('Location: dashboard');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan - Sistem Manajemen Perpustakaan</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="login-container">
    <form method="post" name="form_login" id="form_login" action="proses-login.php" class="login-card">
      <img src="images/mly.png" alt="Logo" class="login-logo">
      <h1 class="login-title">Selamat Datang</h1>
      <p class="login-subtitle">Sistem Manajemen Perpustakaan Digital</p>
      
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-input" placeholder="Masukkan username" required>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-input" placeholder="Masukkan password" required>
      </div>
      
      <button type="submit" name="login" id="login" class="btn btn-submit">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
          <polyline points="10 17 15 12 10 7"></polyline>
          <line x1="15" y1="12" x2="3" y2="12"></line>
        </svg>
        Masuk
      </button>
    </form>
  </div>
</body>

</html>