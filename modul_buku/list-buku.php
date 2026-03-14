<?php

// ... ambil data dari database
include 'proses-list-buku.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan</title>
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
            <h1 class="header-title">Daftar Buku</h1>
        </header>

        <div class="content-header">
            <h2 class="content-title">Manajemen Data Buku</h2>
            <p class="content-subtitle">Kelola koleksi buku perpustakaan</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <span class="table-title">Total Buku</span>
                <div class="table-actions">
                    <form class="search-box" action="list-buku.php" method="get">
                        <input type="text" name="cari" class="search-input" placeholder="Cari buku...">
                        <button type="submit" class="search-btn">Cari</button>
                    </form>
                    <a href="tambah-buku" class="btn btn-tambah">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Data
                    </a>
                </div>
            </div>

            <?php if (empty($data_buku)) : ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <p>Tidak ada data buku.</p>
                </div>
            <?php else : ?>
                <table class="data">
                    <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Cover</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include '../connection.php';

                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                        $data = mysqli_query($db, "select * from buku where buku_id like '%".$cari."%' OR buku_judul like '%".$cari."%' 
                OR kategori_id like '%".$cari."%' OR buku_deskripsi like '%".$cari."%' OR buku_jumlah like '%".$cari."%' 
                OR buku_cover like '%".$cari."%'");
                    } else {
                        $data = mysqli_query($db, $query);
                    }

                    while ($buku = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($buku['buku_judul']); ?></td>
                            <td><?php echo htmlspecialchars($buku['kategori_nama']); ?></td>
                            <td><?php echo htmlspecialchars($buku['buku_deskripsi']); ?></td>
                            <td class="text-center"><?php echo $buku['buku_jumlah']; ?></td>
                            <td class="text-center">
                                <img class="buku-cover" src="modul_buku/cover/<?php echo htmlspecialchars($buku['buku_cover']); ?>" alt="<?php echo htmlspecialchars($buku['buku_judul']); ?>">
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit-buku/<?php echo $buku['buku_id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="hapus-buku/<?php echo $buku['buku_id']; ?>" class="btn btn-hapus"
                                       onclick="return confirm('Anda yakin akan menghapus data?');">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>

</html>