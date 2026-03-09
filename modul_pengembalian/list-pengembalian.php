<?php
include 'proses-list-pengembalian.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pengembalian - Perpustakaan</title>
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
        <h1 class="header-title">Daftar Pengembalian</h1>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Riwayat Pengembalian Buku</h2>
        <p class="content-subtitle">Data buku yang telah dikembalikan</p>
      </div>
      
      <div class="table-container">
        <div class="table-header">
          <span class="table-title">Data Pengembalian</span>
        </div>
        
        <?php if (empty($data_kembali)) : ?>
        <div class="empty-state">
          <div class="empty-state-icon">✅</div>
          <p>Tidak ada data pengembalian.</p>
        </div>
        <?php else : ?>
        <table class="data">
          <thead>
            <tr>
              <th>Buku</th>
              <th>Nama</th>
              <th>Tgl Pinjam</th>
              <th>Tgl Jatuh Tempo</th>
              <th>Tgl Kembali</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_kembali as $kembali) : ?>
            <tr>
              <td><?php echo htmlspecialchars($kembali['buku_judul']) ?></td>
              <td><?php echo htmlspecialchars($kembali['anggota_nama']) ?></td>
              <td class="text-center"><?php echo htmlspecialchars($kembali['tgl_pinjam']) ?></td>
              <td class="text-center"><?php echo htmlspecialchars($kembali['tgl_jatuh_tempo']) ?></td>
              <td class="text-center"><?php echo htmlspecialchars($kembali['tgl_kembali']) ?></td>
              <td>
                <div class="action-buttons">
                  <a href="delete-pengembalian.php?id_kembali=<?php echo $kembali['kembali_id'] ?>" 
                    onclick="return confirm('Anda yakin akan menghapus data?')" class="btn btn-hapus">Hapus</a>
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