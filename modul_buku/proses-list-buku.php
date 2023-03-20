<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

// ... jika belum login, alihkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';
// if ($hasil == true) {
//     // ambil buku_id berdasarkan pinjam_id
//     $q = "SELECT buku.buku_id FROM buku JOIN pinjam ON buku.buku_id = pinjam.buku_id WHERE pinjam.pinjam_id = $pinjam_id";
//     $hasil = mysqli_query($db, $q);
//     $hasil = mysqli_fetch_assoc($hasil);
//     $buku_id = $hasil['buku_id'];

// tambah_stok($db, $buku_id);

$query = "SELECT buku.*, kategori.kategori_nama
    FROM buku
    JOIN kategori
    ON buku.kategori_id = kategori.kategori_id";

$hasil = mysqli_query($db, $query);
mysqli_connect_error();
// ... menampung semua data kategori
$data_buku = array();

// ... tiap baris dari hasil query dikumpulkan ke $data_buku
while ($row = mysqli_fetch_assoc($hasil)) {
    $data_buku[] = $row;
}

// ... lanjut di tampilan