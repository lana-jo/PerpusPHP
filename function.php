<?php

function ambil_kategori($db)
{
    // ambil data kategori
    $query = "SELECT * FROM kategori";
    $hasil = mysqli_query($db, $query);
    $data_kategori = array();

    while ($row = mysqli_fetch_assoc($hasil)) {
        $data_kategori[] = $row;
    }

    return $data_kategori;
}

function hitung_denda($tgl_kembali, $tgl_jatuh_tempo)
{
    if (strtotime($tgl_kembali) > strtotime($tgl_jatuh_tempo)) {
        $kembali = new DateTime($tgl_kembali);
        $jatuh_tempo   = new DateTime($tgl_jatuh_tempo);

        $selisih = $kembali->diff($jatuh_tempo);
        $selisih = $selisih->format('%d');

        $denda = 2000 * $selisih;
    } else {
        $denda = 0;
    }

    return $denda;
}

function cek_stok($db, $buku_id)
{
    $q = "SELECT buku_jumlah FROM buku WHERE buku_id = $buku_id";
    $hasil = mysqli_query($db, $q);
    $hasil = mysqli_fetch_assoc($hasil);
    $stok = $hasil['buku_jumlah'];

    return $stok;
}

function kurangi_stok($db, $buku_id)
{
    $q = "UPDATE buku SET buku_jumlah = buku_jumlah - 1 WHERE buku_id = $buku_id";
    mysqli_query($db, $q);
}

function tambah_stok($db, $buku_id)
{
    $q = "UPDATE buku SET buku_jumlah = buku_jumlah + 1 WHERE buku_id = $buku_id";
    mysqli_query($db, $q);
}