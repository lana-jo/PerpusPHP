<?php
include '../connection.php';

$id_anggota = $_POST['id_anggota'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$smt = $_POST['semester'];
$jenis_kelamin = $_POST['jk'];
$alamat = $_POST['alamat'];
$no_telepon = $_POST['no_telepon'];

$query = "UPDATE anggota 
    SET anggota_nama = '$nama',
        nim = '$nim',
        anggota_alamat = '$alamat',
        semester = '$smt',
        anggota_jk = '$jenis_kelamin',
        anggota_telp = '$no_telepon'
    WHERE anggota_id = $id_anggota";

$hasil = mysqli_query($db, $query);
// var_dump(mysqli_error($db));
if ($hasil == true) {
    header('Location: list-anggota.php');
} else {
    header('Location: tambah-anggota.php');
}
