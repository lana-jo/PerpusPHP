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
  <title>Tambah Anggota - Perpustakaan</title>
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
        <h1 class="header-title">Tambah Anggota</h1>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Tambah Data Anggota Baru</h2>
        <p class="content-subtitle">Lengkapi informasi anggota di bawah ini</p>
      </div>
      
      <div class="form-card">
        <h3 class="form-title">Informasi Anggota</h3>
        <form method="post" action="proses-tambah-anggota.php">
          <div class="form-group">
            <label class="form-label" for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama lengkap" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-input" placeholder="Masukkan alamat" required>
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="jk">Jenis Kelamin</label>
              <select id="jk" name="jk" class="form-select" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="no_telepon">No. Telepon</label>
              <input type="text" id="no_telepon" name="no_telepon" class="form-input" placeholder="Masukkan no. telepon" required>
            </div>
          </div>
          
          <div class="form-actions">
            <a href="list-anggota.php" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
            <button type="submit" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
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