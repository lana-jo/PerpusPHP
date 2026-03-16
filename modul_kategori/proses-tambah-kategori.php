<?php
session_start();

// jika belum login, alihkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: ../login');
    exit();
}

include '../connection.php';

$kategori = mysqli_real_escape_string($db, trim($_POST['kategori']));

// validasi sederhana
if (empty($kategori)) {
    $_SESSION['error'] = "Nama kategori tidak boleh kosong.";
    header('Location: tambah-kategori');
    exit();
}

// query insert
$query = "INSERT INTO kategori (kategori_nama) VALUES ('$kategori')";
$hasil = mysqli_query($db, $query);

if ($hasil) {
    $_SESSION['success'] = "Kategori berhasil ditambahkan.";
    header('Location: kategori');
    exit();
} else {
    // simpan error mysqli ke session
    $_SESSION['error'] = "Gagal menambahkan kategori: " . mysqli_error($db);
    header('Location: tambah-kategori');
    exit();
}