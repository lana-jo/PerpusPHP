<?php
include '../connection.php';
include '../function.php';

$id_pinjam = (int)$_GET['id_pinjam']; // Cast to int to prevent SQL injection
$q = "SELECT anggota.anggota_nama, buku.*, pinjam.*
      FROM pinjam
      LEFT JOIN buku    ON pinjam.buku_id    = buku.buku_id
      LEFT JOIN anggota ON pinjam.anggota_id = anggota.anggota_id
      WHERE pinjam.pinjam_id = $id_pinjam
      LIMIT 1";

$hasil = mysqli_query($db, $q);
$data = mysqli_fetch_assoc($hasil);
$tgl_kembali = date('Y-m-d');
$denda = hitung_denda($tgl_kembali, $data['tgl_jatuh_tempo']);
$terlambat = $denda > 0;

?>
<!DOCTYPE html>
<html lang="id">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengembalian Buku — Perpustakaan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --bg:        #f5f0e8;
        --surface:   #fffdf8;
        --border:    #e0d8c8;
        --ink:       #1a1410;
        --ink-soft:  #6b5f52;
        --accent:    #c0392b;
        --accent-lt: #fdf0ee;
        --gold:      #b8860b;
        --ok:        #2d6a4f;
        --ok-lt:     #edf7f3;
        --radius:    12px;
        --shadow:    0 4px 24px rgba(26,20,16,.08);
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--ink);
        min-height: 100vh;
        display: flex;
    }

    /* ── Sidebar ── */
    .sidebar {
        width: 220px;
        min-height: 100vh;
        background: var(--ink);
        padding: 2rem 1.5rem;
        flex-shrink: 0;
        position: sticky;
        top: 0;
        height: 100vh;
    }

    .sidebar-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        color: #fff;
        line-height: 1.3;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,.12);
    }

    .sidebar-logo span {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        font-weight: 300;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255,255,255,.45);
        margin-bottom: .25rem;
    }

    /* placeholder nav — swap with your sidebar.php output */
    .sidebar nav a {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem .75rem;
        border-radius: 8px;
        color: rgba(255,255,255,.6);
        text-decoration: none;
        font-size: .85rem;
        transition: background .18s, color .18s;
        margin-bottom: .25rem;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background: rgba(255,255,255,.1);
        color: #fff;
    }

    /* ── Main content ── */
    .main {
        flex: 1;
        padding: 2.5rem 3rem;
        overflow-y: auto;
    }

    .breadcrumb {
        font-size: .78rem;
        color: var(--ink-soft);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .breadcrumb a { color: var(--ink-soft); text-decoration: none; }
    .breadcrumb a:hover { color: var(--ink); }
    .breadcrumb .sep { opacity: .4; }

    .page-header {
        display: flex;
        align-items: baseline;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 99px;
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .badge.late {
        background: var(--accent-lt);
        color: var(--accent);
        border: 1px solid rgba(192,57,43,.2);
    }

    .badge.ontime {
        background: var(--ok-lt);
        color: var(--ok);
        border: 1px solid rgba(45,106,79,.2);
    }

    /* ── Card ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        max-width: 680px;
        animation: slideUp .4s ease both;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--ink);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-icon svg { width: 20px; height: 20px; color: #fff; }

    .card-header-text h2 {
        font-size: 1rem;
        font-weight: 500;
    }

    .card-header-text p {
        font-size: .8rem;
        color: var(--ink-soft);
        margin-top: .15rem;
    }

    .card-body { padding: 2rem; }

    /* ── Field grid ── */
    .field-grid {
        display: grid;
        gap: 1.25rem;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .field { display: flex; flex-direction: column; gap: .4rem; }

    .field label {
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--ink-soft);
    }

    .field input {
        width: 100%;
        padding: .65rem .9rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-family: inherit;
        font-size: .9rem;
        color: var(--ink);
        background: var(--bg);
        outline: none;
        cursor: default;
    }

    .field input:disabled { opacity: 1; }

    /* denda highlight */
    .field.denda-field input {
        background: <?php echo $terlambat ? 'var(--accent-lt)' : 'var(--ok-lt)'; ?>;
        border-color: <?php echo $terlambat ? 'rgba(192,57,43,.3)' : 'rgba(45,106,79,.25)'; ?>;
        color: <?php echo $terlambat ? 'var(--accent)' : 'var(--ok)'; ?>;
        font-weight: 500;
    }

    .divider {
        height: 1px;
        background: var(--border);
        margin: .5rem 0;
    }

    /* ── Footer / submit ── */
    .card-footer {
        padding: 1.25rem 2rem;
        border-top: 1px solid var(--border);
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-cancel {
        padding: .65rem 1.4rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: transparent;
        font-family: inherit;
        font-size: .875rem;
        color: var(--ink-soft);
        cursor: pointer;
        transition: border-color .18s, color .18s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel:hover { border-color: var(--ink-soft); color: var(--ink); }

    .btn-submit {
        padding: .65rem 1.75rem;
        border-radius: 8px;
        border: none;
        background: var(--ink);
        color: #fff;
        font-family: inherit;
        font-size: .875rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: opacity .18s, transform .12s;
    }

    .btn-submit:hover { opacity: .88; transform: translateY(-1px); }
    .btn-submit:active { transform: translateY(0); }

    .btn-submit svg { width: 16px; height: 16px; }

    @media (max-width: 700px) {
        .sidebar { display: none; }
        .main { padding: 1.5rem; }
        .field-row { grid-template-columns: 1fr; }
    }
</style>
</head>

<body>
<!-- Main -->
<main class="main">

    <div class="breadcrumb">
        <a href="../index.php">Dashboard</a>
        <span class="sep">›</span>
        <a href="index.php">Peminjaman</a>
        <span class="sep">›</span>
        Pengembalian
    </div>

    <div class="page-header">
        <h1>Pengembalian Buku</h1>
        <?php if ($terlambat): ?>
            <span class="badge late">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        Terlambat
      </span>
        <?php else: ?>
            <span class="badge ontime">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"/></svg>
        Tepat Waktu
      </span>
        <?php endif; ?>
    </div>

    <form method="post" action="/proses-pengembalian">
        <!-- Hidden fields -->
        <input type="hidden" name="pinjam_id" value="<?= htmlspecialchars($data['pinjam_id']) ?>">
        <input type="hidden" name="tgl_kembali" value="<?= htmlspecialchars($tgl_kembali) ?>">
        <input type="hidden" name="denda" value="<?= htmlspecialchars($denda) ?>">

        <div class="card">

            <!-- Card header -->
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="card-header-text">
                    <h2>Detail Transaksi</h2>
                    <p>ID Peminjaman #<?= htmlspecialchars($data['pinjam_id']) ?></p>
                </div>
                <?php
                if (!empty($_SESSION['messages'])) {
                    echo '<div class="alert alert-info">' . $_SESSION['messages'] . '</div>';
                    unset($_SESSION['messages']);
                }
                ?>
            </div>

            <!-- Card body -->
            <div class="card-body">
                <div class="field-grid">

                    <!-- Buku & Anggota -->
                    <div class="field-row">
                        <div class="field">
                            <label>Judul Buku</label>
                            <input type="text" value="<?= htmlspecialchars($data['buku_judul']) ?>" disabled>
                        </div>
                        <div class="field">
                            <label>Nama Anggota</label>
                            <input type="text" value="<?= htmlspecialchars($data['anggota_nama']) ?>" disabled>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Tanggal -->
                    <div class="field-row">
                        <div class="field">
                            <label>Tanggal Pinjam</label>
                            <input type="date" value="<?= htmlspecialchars($data['tgl_pinjam']) ?>" disabled>
                        </div>
                        <div class="field">
                            <label>Tanggal Jatuh Tempo</label>
                            <input type="date" value="<?= htmlspecialchars($data['tgl_jatuh_tempo']) ?>" disabled>
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>Tanggal Kembali</label>
                            <input type="date" value="<?= htmlspecialchars($tgl_kembali) ?>" disabled>
                        </div>
                        <div class="field denda-field">
                            <label>Denda</label>
                            <input type="text"
                                   value="<?= $denda > 0 ? 'Rp ' . number_format($denda, 0, ',', '.') : 'Tidak ada denda' ?>"
                                   disabled>
                        </div>
                    </div>

                </div>
            </div><!-- /.card-body -->

            <!-- Card footer -->
            <div class="card-footer">
                <a href="/peminjaman" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Konfirmasi Pengembalian
                </button>
            </div>

        </div><!-- /.card -->
    </form>
</main>
</body>

</html>