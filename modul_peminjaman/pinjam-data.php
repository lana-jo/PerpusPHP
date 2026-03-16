<?php
// ... ambil data dari database
include 'proses-list-pinjam-data.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Peminjaman - Perpustakaan</title>
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
          <!-- Hamburger: visible on mobile only -->
          <button class="hamburger-btn" id="hamburgerBtn" aria-label="Open menu">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="3" y1="6"  x2="21" y2="6"></line>
                  <line x1="3" y1="12" x2="21" y2="12"></line>
                  <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
          </button>
          <h1 class="header-title">Daftar Peminjaman</h1>
          <div class="header-user">
              <div class="user-avatar">
                  <?php
                  $username = is_array($_SESSION['user']) ? $_SESSION['user']['username'] : $_SESSION['user'];
                  echo strtoupper(substr($username, 0, 1));
                  ?>
              </div>
              <span><?php echo htmlspecialchars($username); ?></span>
          </div>
      </header>
      
      <div class="content-header">
        <h2 class="content-title">Manajemen Peminjaman Buku</h2>
        <p class="content-subtitle">Kelola transaksi peminjaman perpustakaan</p>
      </div>
      
      <?php
      if (!empty($_SESSION['messages'])) {
          echo '<div class="alert alert-info">' . $_SESSION['messages'] . '</div>';
          unset($_SESSION['messages']);
      }
      ?>
      
      <div class="table-container">
        <div class="table-header">
          <span class="table-title">Data Peminjaman</span>
          <div class="table-actions">
            <a href="pinjam-form.php" class="btn btn-tambah">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
              Transaksi Baru
            </a>
          </div>
        </div>
        
        <?php if (empty($data_pinjam)) : ?>
        <div class="empty-state">
          <div class="empty-state-icon">📅</div>
          <p>Tidak ada data peminjaman.</p>
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
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_pinjam as $pinjam) : ?>
            <?php $status = empty($pinjam['tgl_kembali']) ? 'pinjam' : 'kembali'; ?>
            <tr>
              <td><?php echo htmlspecialchars($pinjam['buku_judul']) ?></td>
              <td><?php echo htmlspecialchars($pinjam['anggota_nama']) ?></td>
              <td class="text-center"><?php echo date('d-m-Y', strtotime($pinjam['tgl_pinjam'])) ?></td>
              <td class="text-center"><?php echo date('d-m-Y', strtotime($pinjam['tgl_jatuh_tempo'])) ?></td>
              <td class="text-center">
                <?php
                if (empty($pinjam['tgl_kembali'])) {
                    echo "-";
                } else {
                    echo date('d-m-Y', strtotime($pinjam['tgl_kembali']));
                }
                ?>
              </td>
              <td class="text-center">
                <span class="status-badge <?php echo $status === 'pinjam' ? 'status-warning' : 'status-success'; ?>">
                  <?php echo $status === 'pinjam' ? 'Dipinjam' : 'Dikembalikan'; ?>
                </span>
              </td>
              <td>
                <div class="action-buttons">
                  <?php if (empty($pinjam['tgl_kembali'])) : ?>
                  <a href="../modul_pengembalian/pengembalian.php?id_pinjam=<?php echo $pinjam['pinjam_id'] ?>" 
                    class="btn btn-success" title="Klik untuk proses pengembalian">Kembali</a>
                  <a href="edit-pinjam.php?id_pinjam=<?php echo $pinjam['pinjam_id']; ?>&status=<?php echo $status; ?>" 
                    class="btn btn-edit">Edit</a>
                  <?php endif ?>
                  <a href="proses-delete-pinjam.php?id_pinjam=<?php echo $pinjam['pinjam_id']; ?>&status=<?php echo $status; ?>&buku_id=<?php echo $pinjam['buku_id']; ?>" 
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

  <script>
    (function () {
      const hamburger = document.getElementById('hamburgerBtn');
      const sidebar   = document.getElementById('sidebar');
      const overlay   = document.getElementById('sidebarOverlay');
      const closeBtn  = document.getElementById('sidebarClose');

      function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // prevent background scroll
      }

      function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }

      hamburger.addEventListener('click', openSidebar);
      closeBtn.addEventListener('click', closeSidebar);
      overlay.addEventListener('click', closeSidebar);

      // Close sidebar when any nav link is tapped on mobile
      sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
          if (window.innerWidth <= 768) closeSidebar();
        });
      });

      // Close on resize back to desktop
      window.addEventListener('resize', function () {
        if (window.innerWidth > 768) closeSidebar();
      });
    })();
  </script>

</body>

</html>