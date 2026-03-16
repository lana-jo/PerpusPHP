<?php

include '../connection.php';

$id_kategori = $_GET['kategori_id'];

$query = "DELETE FROM kategori WHERE kategori_id = $id_kategori";
$hasil = mysqli_query($db, $query);

if ($hasil == true) {
    header('location: /kategori');
} else {
    header('location: tambah-kategori');
    exit();
}
