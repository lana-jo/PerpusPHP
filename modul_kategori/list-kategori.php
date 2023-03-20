<?php

// ... ambil data dari database
include 'proses-list-kategori.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kategori</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container clearfix">
        <h1>Perpustakaan</h1>

        <?php include '../sidebar.php' ?>

        <div class="content">
            <h1>Daftar Kategori</h1>
            <div class="btn-tambah-div">
                <a href="tambah-kategori.php"><button class="btn btn-tambah">Tambah Data</button></a>
            </div>
            <?php if (empty($data_kategori)) : ?>
            Tidak ada data.
            <?php else : ?>
            <table class="data">
                <tr>
                    <th align="left">Kategori</th>
                    <th width="20%">Pilihan</th>
                </tr>
                <?php foreach ($data_kategori as $kategori) : ?>
                <tr>
                    <td><?php echo $kategori['kategori_nama'] ?></td>
                    <td align="center">
                        <a href="edit-kategori.php?id_kategori=<?php echo $kategori['kategori_id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete-kategori.php?id_kategori=<?php echo $kategori['kategori_id']; ?>" class="btn btn-hapus" onclick="return confirm('anda yakin akan menghapus data?');">Hapus</a>
                    </td>
                </tr>
                <?php  endforeach ?>
            </table>
            <?php endif ?>
        </div>

    </div>
</body>
</html>
