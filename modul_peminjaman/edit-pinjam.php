<?php
// ... ambil data dari database
include '../modul_buku/proses-list-buku.php';

// ... ambil data dari database
include '../modul_anggota/proses-list-anggota.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

$id_pinjam = $_GET['id_pinjam'];
$query = "SELECT * FROM pinjam WHERE pinjam.pinjam_id = $id_pinjam";
$hasil = mysqli_query($db, $query);
$data_pinjam = mysqli_fetch_assoc($hasil);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Peminjaman - Perpustakaan</title>
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
        <h1 class="header-title">Edit Peminjaman</h1>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Edit Data Peminjaman</h2>
        <p class="content-subtitle">Perbarui informasi peminjaman di bawah ini</p>
      </div>
      
      <?php
      if (!empty($_SESSION['messages'])) {
          echo '<div class="alert alert-info">' . $_SESSION['messages'] . '</div>';
          unset($_SESSION['messages']);
      }
      ?>
      
      <div class="form-card">
        <h3 class="form-title">Informasi Peminjaman</h3>
        <form action="proses-edit-pinjam.php" method="post">
          <input type="hidden" name="pinjam_id" value="<?php echo $id_pinjam ?>">
          
          <div class="form-group">
            <label class="form-label" for="buku">Buku</label>
            <select id="buku" name="buku" class="form-select" required>
              <?php foreach ($data_buku as $buku) : ?>
              <option value="<?php echo $buku['buku_id'] ?>" <?php echo ($buku['buku_id'] == $data_pinjam['buku_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($buku['buku_judul']) ?>
              </option>
              <?php endforeach ?>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="anggota">Anggota</label>
            <select id="anggota" name="anggota" class="form-select" required>
              <?php foreach ($data_anggota as $anggota) : ?>
              <option value="<?php echo $anggota['anggota_id'] ?>" <?php echo ($anggota['anggota_id'] == $data_pinjam['anggota_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($anggota['anggota_nama']) ?>
              </option>
              <?php endforeach ?>
            </select>
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="tgl_pinjam">Tanggal Pinjam</label>
              <input type="date" id="tgl_pinjam" name="tgl_pinjam" class="form-input" value="<?php echo $data_pinjam['tgl_pinjam'] ?>" required>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="tgl_jatuh_tempo">Tanggal Jatuh Tempo</label>
              <input type="date" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" class="form-input" value="<?php echo $data_pinjam['tgl_jatuh_tempo'] ?>" required>
            </div>
          </div>
          
          <div class="form-actions">
            <a href="pinjam-data.php" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
            <button type="submit" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
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