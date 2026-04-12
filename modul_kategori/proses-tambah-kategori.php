<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login');
    exit();
}

include '../connection.php';

$kategori = mysqli_real_escape_string($db, trim($_POST['kategori']));

if (empty($kategori)) {
    $_SESSION['error'] = "Nama kategori tidak boleh kosong.";
    header('Location: tambah-kategori');
    exit();
}

// Cek apakah kategori sudah ada
$cek = mysqli_query($db, "SELECT kategori_id FROM kategori WHERE kategori_nama = '$kategori' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
    $_SESSION['error'] = "Kategori '$kategori' sudah ada.";
    header('Location: tambah-kategori');
    exit();
}

// Query insert
$query = "INSERT INTO kategori (kategori_nama) VALUES ('$kategori')";
$hasil = mysqli_query($db, $query);

if ($hasil) {
    $_SESSION['success'] = "Kategori berhasil ditambahkan.";
    header('Location: kategori');
    exit();
} else {
    $_SESSION['error'] = "Gagal menambahkan kategori: " . mysqli_error($db);
    header('Location: tambah-kategori');
    exit();
}