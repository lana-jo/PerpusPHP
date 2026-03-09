<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kategori - Perpustakaan</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="container">
    <?php include '../sidebar.php' ?>
    
    <main class="content">
      <header class="main-header">
        <h1 class="header-title">Tambah Kategori</h1>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Tambah Kategori Buku Baru</h2>
        <p class="content-subtitle">Masukkan nama kategori di bawah ini</p>
      </div>
      
      <div class="form-card">
        <h3 class="form-title">Informasi Kategori</h3>
        <form method="post" action="proses-tambah-kategori.php">
          <div class="form-group">
            <label class="form-label" for="kategori">Nama Kategori</label>
            <input type="text" id="kategori" name="kategori" class="form-input" placeholder="Masukkan nama kategori" required>
          </div>
          
          <div class="form-actions">
            <a href="list-kategori.php" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
            <button type="submit" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                <line x1="12" y1="11" x2="12" y2="17"></line>
                <line x1="9" y1="14" x2="15" y2="14"></line>
              </svg>
              Simpan
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>