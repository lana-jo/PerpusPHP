<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

include '../connection.php';
include '../function.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$pinjam_id = (int)$_POST['pinjam_id'];
$tgl_kembali = $_POST['tgl_kembali'];
$denda = (int)$_POST['denda'];

mysqli_begin_transaction($db);

try {

    // cek status pinjam
    $cekStatus = mysqli_prepare($db, "SELECT status,buku_id FROM pinjam WHERE pinjam_id=?");
    mysqli_stmt_bind_param($cekStatus, 'i', $pinjam_id);
    mysqli_stmt_execute($cekStatus);
    mysqli_stmt_bind_result($cekStatus, $status, $buku_id);
    mysqli_stmt_fetch($cekStatus);
    mysqli_stmt_close($cekStatus);

    if (!$buku_id) {
        throw new Exception("Data peminjaman tidak ditemukan");
    }

    if ($status == 'kembali') {
        throw new Exception("Buku sudah dikembalikan");
    }


    // insert pengembalian
    $stmt = mysqli_prepare($db, "INSERT INTO kembali (pinjam_id,tgl_kembali,denda) VALUES (?,?,?)");
    mysqli_stmt_bind_param($stmt, 'isi', $pinjam_id, $tgl_kembali, $denda);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    // tambah stok
    tambah_stok($db, $buku_id);


    // update status
    $update = mysqli_prepare($db, "UPDATE pinjam SET status='kembali' WHERE pinjam_id=?");
    mysqli_stmt_bind_param($update, 'i', $pinjam_id);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);


    mysqli_commit($db);

    $_SESSION['messages'] = '<font color="green">Pengembalian buku sukses!</font>';
    header('Location: /peminjaman');

} catch (Exception $e) {

    mysqli_rollback($db);

    $_SESSION['messages'] = '<font color="red">' . $e->getMessage() . '</font>';
    header('Location: /kembalikan/' . $pinjam_id);
}