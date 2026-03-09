<?php
include '../modul_kategori/proses-list-kategori.php';

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
  <title>Tambah Buku - Perpustakaan</title>
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
        <h1 class="header-title">Tambah Buku</h1>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Tambah Data Buku Baru</h2>
        <p class="content-subtitle">Lengkapi informasi buku di bawah ini</p>
      </div>
      
      <div class="form-card">
        <h3 class="form-title">Informasi Buku</h3>
        <form method="post" action="proses-tambah-buku.php" enctype="multipart/form-data">
          <div class="form-group">
            <label class="form-label" for="judul">Judul Buku</label>
            <input type="text" id="judul" name="judul" class="form-input" placeholder="Masukkan judul buku" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="form-select" required>
              <option value="">Pilih Kategori</option>
              <?php foreach ($data_kategori as $kategori) : ?>
              <option value="<?php echo $kategori['kategori_id'] ?>"><?php echo htmlspecialchars($kategori['kategori_nama']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-textarea" placeholder="Masukkan deskripsi buku" rows="4"></textarea>
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="jumlah">Jumlah</label>
              <input type="number" id="jumlah" name="jumlah" class="form-input" placeholder="0" min="0" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="cover">Cover Buku</label>
              <input type="file" id="cover" name="cover" class="form-input" accept="image/*">
            </div>
          </div>
          
          <div class="form-actions">
            <a href="list-buku.php" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
            <button type="submit" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
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