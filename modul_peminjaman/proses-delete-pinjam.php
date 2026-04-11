<?php
session_start();
include '../connection.php';
include '../function.php';

// ── Input validation ────────────────────────────────────────────
if (
    empty($_GET['id_pinjam']) || !is_numeric($_GET['id_pinjam']) ||
    empty($_GET['buku_id'])   || !is_numeric($_GET['buku_id'])   ||
    empty($_GET['status'])
) {
    $_SESSION['messages'] = '<div class="alert alert-danger">Request tidak valid.</div>';
    header('Location: pinjam-data.php');
    exit();
}

$id_pinjam = (int) $_GET['id_pinjam'];
$buku_id   = (int) $_GET['buku_id'];
$status    = $_GET['status'];

// ── Fetch pinjam record (make sure it exists & not already deleted) ──
$stmt = mysqli_prepare($db, "
    SELECT pinjam_id, status 
    FROM pinjam 
    WHERE pinjam_id = ? AND deleted_at IS NULL
");
mysqli_stmt_bind_param($stmt, 'i', $id_pinjam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pinjam = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pinjam) {
    $_SESSION['messages'] = '<div class="alert alert-danger">Data pinjam tidak ditemukan.</div>';
    header('Location: pinjam-data.php');
    exit();
}

// ── If still borrowed, return stock before soft-deleting ────────
if ($pinjam['status'] === 'dipinjam') {
    tambah_stok($db, $buku_id);
}

// ── Soft delete: set deleted_at instead of DELETE ───────────────
$stmt = mysqli_prepare($db, "
    UPDATE pinjam 
    SET deleted_at = NOW() 
    WHERE pinjam_id = ? AND deleted_at IS NULL
");
mysqli_stmt_bind_param($stmt, 'i', $id_pinjam);
$hasil = mysqli_stmt_execute($stmt);
$affected = mysqli_stmt_affected_rows($stmt);
mysqli_stmt_close($stmt);

if ($hasil && $affected > 0) {
    $_SESSION['messages'] = '<div class="alert alert-success">Hapus data sukses!</div>';
} else {
    // Stock was already incremented — roll it back
    if ($pinjam['status'] === 'dipinjam') {
        kurang_stok($db, $buku_id); // make sure this function exists
    }
    $_SESSION['messages'] = '<div class="alert alert-danger">Hapus data gagal!</div>';
}

header('Location: pinjam-data.php');
exit();