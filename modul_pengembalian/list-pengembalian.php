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
          <!-- Hamburger: visible on mobile only -->
          <button class="hamburger-btn" id="hamburgerBtn" aria-label="Open menu">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="3" y1="6"  x2="21" y2="6"></line>
                  <line x1="3" y1="12" x2="21" y2="12"></line>
                  <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
          </button>
          <h1 class="header-title">Daftar Pengembalian</h1>
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
                  <a href="/hapus-pengembalian/<?php echo $kembali['kembali_id'] ?>"
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