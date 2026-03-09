<?php

// ... ambil data dari database
include 'proses-list-anggota.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - Perpustakaan</title>
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
                <h1 class="header-title">Daftar Anggota</h1>
            </header>
            
            <div class="content-header">
                <h2 class="content-title">Manajemen Data Anggota</h2>
                <p class="content-subtitle">Kelola data pengunjung perpustakaan</p>
            </div>
            
            <div class="table-container">
                <div class="table-header">
                    <span class="table-title">Total Anggota</span>
                    <div class="table-actions">
                        <a href="tambah-anggota.php" class="btn btn-tambah">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Data
                        </a>
                    </div>
                </div>
                
                <?php if (empty($data_anggota)) : ?>
                <div class="empty-state">
                    <div class="empty-state-icon">👥</div>
                    <p>Tidak ada data anggota.</p>
                </div>
                <?php else : ?>
                <table class="data">
                    <thead>
                        <tr>
                            <!-- <th>NIM</th> -->
                            <th>Nama</th>
                            <!-- <th>Semester</th> -->
                            <th>Alamat</th>
                            <th>JK</th>
                            <th>No Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_anggota as $anggota) : ?>
                        <tr>
                            <!-- <td><?php echo htmlspecialchars($anggota['nim']) ?></td> -->
                            <td><?php echo htmlspecialchars($anggota['anggota_nama']) ?></td>
                            <!-- <td class="text-center"><?php echo htmlspecialchars($anggota['semester']) ?></td> -->
                            <td><?php echo htmlspecialchars($anggota['anggota_alamat']) ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($anggota['anggota_jk']) ?></td>
                            <td><?php echo htmlspecialchars($anggota['anggota_telp']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit-anggota.php?id_anggota=<?php echo $anggota['anggota_id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="delete-anggota.php?id_anggota=<?php echo $anggota['anggota_id']; ?>" class="btn btn-hapus" 
                                        onclick="return confirm('Anda yakin akan menghapus data?');">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php endif ?>
            </div>
        </main>
    </div>
</body>
</html>
