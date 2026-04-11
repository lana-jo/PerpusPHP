<?php

include '../connection.php';

// Validate input
if (!isset($_GET['kategori_id']) || !is_numeric($_GET['kategori_id'])) {
    header('Location: /kategori');
    exit();
}

$id_kategori = (int) $_GET['kategori_id'];

// Check if any buku still references this kategori
$check_query = "SELECT COUNT(*) AS total FROM buku WHERE kategori_id = ?";
$stmt = mysqli_prepare($db, $check_query);
mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
mysqli_stmt_execute($stmt);
$check_result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($check_result);
mysqli_stmt_close($stmt);

if ($row['total'] > 0) {
    // Kategori still has books — cannot delete
    session_start();
    $_SESSION['error'] = "Kategori tidak bisa dihapus karena masih memiliki {$row['total']} buku terkait.";
    header('Location: /kategori');
    exit();
}

// Safe to delete — use prepared statement
$stmt = mysqli_prepare($db, "DELETE FROM kategori WHERE kategori_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
$hasil = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($hasil) {
    session_start();
    $_SESSION['success'] = "Kategori berhasil dihapus.";
    header('Location: /kategori');
    exit();
} else {
    session_start();
    $_SESSION['error'] = "Gagal menghapus kategori: " . mysqli_error($db);
    header('Location: /kategori');
    exit();
}