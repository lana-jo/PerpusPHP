<?php

include '../connection.php';

$id_anggota = $_GET['anggota_id'];

$query = "DELETE FROM anggota WHERE anggota_id = $id_anggota";
$hasil = mysqli_query($db, $query);

if ($hasil == true) {
    header('location: /anggota');
} else {
    header('location: /tambah-anggota');
}
