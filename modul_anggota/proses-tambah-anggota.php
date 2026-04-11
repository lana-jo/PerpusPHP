<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';

$nama          = $_POST['nama'];
$jenis_kelamin = $_POST['jk'];
$alamat        = $_POST['alamat'];
$no_telepon    = $_POST['no_telepon'];
$nim           = $_POST['nim'];
$semester      = $_POST['semester'];

/* cek apakah nim sudah ada */
$cek = mysqli_prepare($db, "SELECT nim FROM anggota WHERE nim = ?");
mysqli_stmt_bind_param($cek, "i", $nim);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
    // jika nim sudah ada
    echo "<script>
        alert('NIM sudah terdaftar!');
        window.location='tambah-anggota';
    </script>";
    exit();
}

/* jika nim belum ada, lakukan insert */
$stmt = mysqli_prepare($db,
    "INSERT INTO anggota (anggota_nama, anggota_alamat, anggota_jk, anggota_telp, nim, semester) 
     VALUES (?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, 'ssssii', $nama, $alamat, $jenis_kelamin, $no_telepon, $nim, $semester);
$hasil = mysqli_stmt_execute($stmt);

if ($hasil) {
    header('Location: anggota');
} else {
    header('Location: tambah-anggota');
}
?>