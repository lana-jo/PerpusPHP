<?php
include '../modul_kategori/proses-list-kategori.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}
if (!isset($_GET['id_buku'])) {
    die("ID buku tidak ditemukan.");
}

$id_buku = (int)$_GET['id_buku']; // pastikan integer
$query = "SELECT buku.*, kategori.kategori_id
    FROM buku
    JOIN kategori
    ON buku.kategori_id = kategori.kategori_id
    WHERE buku.buku_id = $id_buku";
$hasil = mysqli_query($db, $query);
$data_buku = mysqli_fetch_assoc($hasil);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Perpustakaan</title>
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
                <h1 class="header-title">Edit Buku</h1>
            </header>
            
            <div class="content-header">
                <h2 class="content-title">Edit Data Buku</h2>
                <p class="content-subtitle">Perbarui informasi buku di bawah ini</p>
            </div>
            
            <div class="form-card">
                <h3 class="form-title">Informasi Buku</h3>
                <form method="post" action="/proses-edit-buku" enctype="multipart/form-data">
                    <input type="hidden" name="buku_id" value="<?php echo $id_buku; ?>">
                    
                    <div class="form-group">
                        <label class="form-label" for="judul">Judul Buku</label>
                        <input type="text" id="judul" name="judul" class="form-input" value="<?php echo htmlspecialchars($data_buku['buku_judul']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="form-select" required>
                            <?php foreach ($data_kategori as $kategori) : ?>
                            <option value="<?php echo $kategori['kategori_id'] ?>" <?php echo ($data_buku['kategori_id'] == $kategori['kategori_id']) ? 'selected' : '' ?>>
                                <?php echo htmlspecialchars($kategori['kategori_nama']) ?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-textarea" rows="4"><?php echo htmlspecialchars($data_buku['buku_deskripsi']) ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="jumlah">Jumlah</label>
                            <input type="number" id="jumlah" name="jumlah" class="form-input" value="<?php echo $data_buku['buku_jumlah'] ?>" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="cover">Cover Buku</label>
                            <input type="file" id="cover" name="cover" class="form-input" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <?php $base_url = "/"; ?>
                        <a href="<?= $base_url ?>buku" class="btn" style="background: var(--gray-200); color: var(--gray-700);">
                            Batal
                        </a>                        <button type="submit" class="btn btn-primary">
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
