<?php
session_start();

// ... jika belum login, alihkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';

$query = "SELECT buku.buku_judul, pinjam.tgl_pinjam, pinjam.tgl_jatuh_tempo,kembali.kembali_id, kembali.tgl_kembali, anggota.anggota_nama
    FROM pinjam
    JOIN buku ON buku.buku_id = pinjam.buku_id
    JOIN anggota ON anggota.anggota_id = pinjam.anggota_id
    JOIN kembali ON pinjam.pinjam_id = kembali.pinjam_id";

$hasil = mysqli_query($db, $query);
mysqli_connect_error();
// ... menampung semua data kategori
$data_kembali = array();

// ... tiap baris dari hasil query dikumpulkan ke $data_buku
while ($row = mysqli_fetch_assoc($hasil)) {
    $data_kembali[] = $row;
}
// ... lanjut di tampilan