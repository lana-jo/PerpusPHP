<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login');
    exit();
}

include '../connection.php';

// ambil artikel yang mau di edit
$id_anggota = $_GET['anggota_id'];
$query = "SELECT * FROM anggota WHERE anggota_id = $id_anggota";
$hasil = mysqli_query($db, $query);
$data_anggota = mysqli_fetch_assoc($hasil);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - Perpustakaan</title>
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
                <h1 class="header-title">Edit Anggota</h1>
            </header>

            <div class="content-header">
                <h2 class="content-title">Edit Data Anggota</h2>
                <p class="content-subtitle">Perbarui informasi anggota di bawah ini</p>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <?php if ($_GET['error'] === 'nim_duplikat'): ?>
                    <div class="alert alert-danger">
                        NIM <strong><?= htmlspecialchars($_GET['nim'] ?? '') ?></strong> sudah digunakan anggota lain.
                    </div>
                <?php elseif ($_GET['error'] === 'gagal'): ?>
                    <div class="alert alert-danger">
                        Gagal memperbarui data. Silakan coba lagi.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="form-card">
                <h3 class="form-title">Informasi Anggota</h3>
                <form method="post" action="/proses-edit-anggota">
                    <input type="hidden" name="id_anggota" value="<?php echo $data_anggota['anggota_id']; ?>">
                    <div class="form-group">
                        <label class="form-label" for="nim">NIM</label>
                        <input
                                placeholder="Masukkan NIM"
                                type="text"
                                id="nim"
                                name="nim"
                                class="form-input"
                                pattern="[0-9]{6,15}"
                                title="NIM harus berupa angka (6-15 digit)"
                                value="<?php echo htmlspecialchars($data_anggota['nim']); ?>"
                                required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="<?php echo htmlspecialchars($data_anggota['anggota_nama']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="form-input" value="<?php echo htmlspecialchars($data_anggota['anggota_alamat']); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="jk">Jenis Kelamin</label>
                            <select id="jk" name="jk" class="form-select" required>
                                <option value="L" <?php echo ($data_anggota['anggota_jk'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?php echo ($data_anggota['anggota_jk'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_telepon">No. Telepon</label>
                            <input
                                    type="tel"
                                    id="no_telepon"
                                    name="no_telepon"
                                    class="form-input"
                                    value="<?php echo htmlspecialchars($data_anggota['anggota_telp']); ?>"
                                    pattern="[0-9]{10,15}"
                                    title="Masukkan nomor telepon 10-15 digit angka"
                                    required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Semester</label>
                        <input
                                placeholder="Masukkan Semester, Contoh: 5"
                                type="number"
                                name="semester"
                                class="form-input"
                                min="1"
                                max="14"
                                value="<?php echo htmlspecialchars($data_anggota['semester']); ?>"
                                required
                        >
                    </div>

                    <div class="form-actions">
                        <a href="/anggota" class="btn" style="background: var(--gray-200); color: var(--gray-700);">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
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
