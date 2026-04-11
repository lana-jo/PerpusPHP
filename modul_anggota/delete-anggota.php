<?php

include '../connection.php';

// ── Validate input ───────────────────────────────────────────────
if (!isset($_GET['anggota_id']) || !is_numeric($_GET['anggota_id'])) {
    header('Location: /anggota');
    exit();
}

$id_anggota = (int) $_GET['anggota_id'];

// ── Check if anggota has any pinjam records (active or history) ──
$stmt = mysqli_prepare($db, "SELECT COUNT(*) AS total FROM pinjam WHERE anggota_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_anggota);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($row['total'] > 0) {
    session_start();
    $_SESSION['error'] = "Anggota tidak bisa dihapus karena memiliki {$row['total']} riwayat pinjaman.";
    header('Location: /anggota');
    exit();
}

// ── Safe to delete ───────────────────────────────────────────────
$stmt = mysqli_prepare($db, "DELETE FROM anggota WHERE anggota_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_anggota);
$hasil = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($hasil) {
    session_start();
    $_SESSION['success'] = "Data anggota berhasil dihapus.";
    header('Location: /anggota');
    exit();
} else {
    session_start();
    $_SESSION['error'] = "Gagal menghapus anggota: " . mysqli_error($db);
    header('Location: /anggota');
    exit();
}