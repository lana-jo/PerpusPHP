<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';
include '../function.php';

$buku            = $_POST['buku'];
$anggota         = $_POST['anggota'];
$tgl_pinjam      = $_POST['tgl_pinjam'];
$tgl_jatuh_tempo = $_POST['tgl_jatuh_tempo'];

// Validate dates
if (empty($tgl_pinjam) || empty($tgl_jatuh_tempo)) {
    $_SESSION['messages'] = '<font color="red">Tanggal tidak boleh kosong!</font>';
    header('Location: pinjam-form');
    exit();
}

if ($tgl_jatuh_tempo < $tgl_pinjam) {
    $_SESSION['messages'] = '<font color="red">Tanggal jatuh tempo tidak boleh sebelum tanggal pinjam!</font>';
    header('Location: pinjam-form');
    exit();
}

// Cek stok buku
$stok_buku = cek_stok($db, $buku);
if ($stok_buku < 1) {
    $_SESSION['messages'] = '<font color="red">Stok buku sudah habis, proses peminjaman gagal!</font>';
    header('Location: pinjam-form');
    exit();
}

$stmt = mysqli_prepare($db, "INSERT INTO pinjam (buku_id, anggota_id, tgl_pinjam, tgl_jatuh_tempo) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'iiss', $buku, $anggota, $tgl_pinjam, $tgl_jatuh_tempo);
$hasil = mysqli_stmt_execute($stmt);

if ($hasil) {
    kurangi_stok($db, $buku);
    $_SESSION['messages'] = '<font color="green">Peminjaman sukses!</font>';
    header('Location: peminjaman');
} else {
    $_SESSION['messages'] = '<font color="red">Peminjaman gagal, silakan coba lagi!</font>';
    header('Location: pinjam-form');
}

mysqli_stmt_close($stmt);