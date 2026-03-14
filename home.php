<?php
session_start();

//jika belum login, alihkan ke login
if (empty($_SESSION['user'])) {
    header('Location: login');
    exit();
}

include 'connection.php';

$total_buku = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM buku"))['total'];
$total_anggota = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM anggota"))['total'];
$total_pinjam = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM pinjam"))['total'];
$total_kembali = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM kembali"))['total'];
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
<div class="container">
    <?php include 'sidebar.php' ?>

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

            <h1 class="header-title">Dashboard</h1>

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
            <h2 class="content-title">Selamat Datang di Perpustakaan</h2>
            <p class="content-subtitle">Sistem Manajemen Perpustakaan Digital</p>
        </div>

        <div class="welcome-card">
            <?php
            $images = glob("images/mly.png");
            if (!empty($images)) {
                foreach ($images as $single_image) {
                    ?>
                    <img src="<?php echo $single_image; ?>" alt="Logo Perpustakaan" class="welcome-logo">
                    <?php
                }
            }
            ?>
            <h3 class="welcome-title">Perpustakaan Ma'had Aly Balekambang</h3>
            <p class="welcome-text">Kelola data buku, anggota, dan transaksi peminjaman dengan mudah</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Buku</span>
                    <span class="stat-value"><?php echo $total_buku; ?></span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Anggota</span>
                    <span class="stat-value"><?php echo $total_anggota; ?></span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Peminjaman</span>
                    <span class="stat-value"><?php echo $total_pinjam; ?></span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Pengembalian</span>
                    <span class="stat-value"><?php echo $total_kembali; ?></span>
                </div>
            </div>
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