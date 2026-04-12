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
    <title>Tambah Kategori - Perpustakaan</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .toast-container {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            min-width: 280px;
            max-width: 360px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            font-size: 0.9rem;
            font-weight: 500;
            animation: slideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .toast.success {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
        }

        .toast.error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .toast-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .toast.success .toast-icon { color: #22c55e; }
        .toast.error .toast-icon { color: #ef4444; }

        .toast-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            opacity: 0.5;
            font-size: 1.1rem;
            line-height: 1;
            color: inherit;
            padding: 0;
        }

        .toast-close:hover { opacity: 1; }

        .toast.hide {
            animation: slideOut 0.35s ease forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(60px) scale(0.95); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }

        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(60px) scale(0.95); }
        }
    </style>
</head>

<body>

<!-- Toast Notifications -->
<div class="toast-container">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="toast error" id="toast-error">
            <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
            <button class="toast-close" onclick="dismissToast('toast-error')">&times;</button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="toast success" id="toast-success">
            <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
            <button class="toast-close" onclick="dismissToast('toast-success')">&times;</button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</div>

<div class="container">
    <?php include '../sidebar.php' ?>

    <main class="content">
        <header class="main-header">
            <h1 class="header-title">Tambah Kategori</h1>
        </header>

        <div class="content-header">
            <h2 class="content-title">Tambah Kategori Buku Baru</h2>
            <p class="content-subtitle">Masukkan nama kategori di bawah ini</p>
        </div>

        <div class="form-card">
            <h3 class="form-title">Informasi Kategori</h3>
            <form method="post" action="proses-tambah-kategori">
                <div class="form-group">
                    <label class="form-label" for="kategori">Nama Kategori</label>
                    <input type="text" id="kategori" name="kategori" class="form-input" placeholder="Masukkan nama kategori" required>
                </div>

                <div class="form-actions">
                    <a href="kategori" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            <line x1="12" y1="11" x2="12" y2="17"></line>
                            <line x1="9" y1="14" x2="15" y2="14"></line>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
  function dismissToast(id) {
    const toast = document.getElementById(id);
    if (!toast) return;
    toast.classList.add('hide');
    setTimeout(() => toast.remove(), 350);
  }

  // Auto dismiss setelah 4 detik
  document.querySelectorAll('.toast').forEach(toast => {
    setTimeout(() => dismissToast(toast.id), 4000);
  });
</script>

</body>
</html>