<?php
session_start();
// ... jika belum login, alihkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';
include '../function.php';

$tgl_kembali = $_POST['tgl_kembali'];
$denda = $_POST['denda'];
$pinjam_id = $_POST['pinjam_id'];

$query = "INSERT INTO kembali (pinjam_id, tgl_kembali, denda) 
    VALUES ($pinjam_id, '$tgl_kembali', $denda)";

$hasil = mysqli_query($db, $query);
if ($hasil == true) {
    // ambil buku_id berdasarkan pinjam_id
    $q = "SELECT buku.buku_id FROM buku JOIN pinjam ON buku.buku_id = pinjam.buku_id WHERE pinjam.pinjam_id = $pinjam_id";
    $hasil = mysqli_query($db, $q);
    $hasil = mysqli_fetch_assoc($hasil);
    $buku_id = $hasil['buku_id'];

    tambah_stok($db, $buku_id);
    // tambah stok

    $_SESSION['messages'] = '<font color="green">Pengembalian buku sukses!</font>';
    header('Location: ../modul_peminjaman/pinjam-data.php');
} else {
    header('Location: pengembalian.php?id_pinjam=' . $pinjam_id);
}